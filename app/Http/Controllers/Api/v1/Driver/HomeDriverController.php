<?php


namespace App\Http\Controllers\Api\v1\Driver;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Order;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;




class HomeDriverController extends Controller
{
    use Responses;
    
    public function __invoke(Request $request)
    {
        // Get the authenticated driver
        $driver = auth('driver-api')->user();
        
        // Get driver's rating
        $rating = $driver->ratings()->avg('rating') ?? 0;
        
        // Get only active services
        $activeServices = $driver->activeServices()->get();
        
        // Get driver's options
        $driverOptions = $driver->options()->get();
        
        // Get minimum wallet balance setting
        $minWalletBalance = DB::table('settings')
            ->where('key', 'minimum_money_in_wallet_driver_to_get_order')
            ->value('value') ?? 0;
        
        // Check if driver's balance is below minimum required
        $walletStatus = $this->checkWalletStatus($driver->balance, $minWalletBalance);
        
        // Get today's statistics
        $todayStats = $this->getTodayStatistics($driver->id);
        
        // Get today's hot spots (high demand areas)
        $hotSpots = $this->getTodayHotSpots();
        
        // Prepare the response data
        $responseData = [
            'profile' => $driver,
            'rating' => round($rating, 1),
            'active_services' => $activeServices,
            'options' => $driverOptions,
            'wallet_info' => [
                'current_balance' => $driver->balance,
                'minimum_required_balance' => $minWalletBalance,
                'is_eligible_for_orders' => $walletStatus['is_eligible'],
                'needs_recharge' => $walletStatus['needs_recharge'],
                'required_amount' => $walletStatus['required_amount'],
                'popup_message' => $walletStatus['popup_message']
            ],
            'today_statistics' => $todayStats,
            'hot_spots' => $hotSpots
        ];
        
        return $this->success_response('Home data retrieved successfully', $responseData);
    }
    
    /**
     * Get today's hot spots (high demand pickup locations)
     * Returns the top locations with most orders today
     */
    private function getTodayHotSpots($limit = 20, $radiusKm = 10)
    {
        $today = now()->format('Y-m-d');
        
        // Get all today's orders with pickup locations
        $todayOrders = DB::table('orders')
            ->whereDate('created_at', $today)
            ->whereNotNull('pick_lat')
            ->whereNotNull('pick_lng')
            ->select('pick_lat', 'pick_lng', 'pick_name')
            ->get();
        
        if ($todayOrders->isEmpty()) {
            return [
                'spots' => [],
                'total_spots' => 0,
                'message' => 'No hot spots available for today'
            ];
        }
        
        // Cluster nearby locations together
        $clusters = $this->clusterLocations($todayOrders, $radiusKm);
        
        // Sort clusters by order count (descending)
        usort($clusters, function($a, $b) {
            return $b['order_count'] <=> $a['order_count'];
        });
        
        // Get top spots
        $topSpots = array_slice($clusters, 0, $limit);
        
        // Format the response
        $formattedSpots = array_map(function($spot, $index) {
            return [
                'rank' => $index + 1,
                'location' => [
                    'latitude' => $spot['center_lat'],
                    'longitude' => $spot['center_lng'],
                    'area_name' => $spot['area_name']
                ],
                'order_count' => $spot['order_count'],
                'percentage' => $spot['percentage'],
                'demand_level' => $this->getDemandLevel($spot['order_count']),
                'recommended' => $index < 3 // Top 3 are highly recommended
            ];
        }, $topSpots, array_keys($topSpots));
        
        return [
            'spots' => $formattedSpots,
            'total_spots' => count($topSpots),
            'total_orders_today' => $todayOrders->count(),
            'last_updated' => now()->format('Y-m-d H:i:s'),
            'message' => 'These are the high-demand areas for today. Position yourself near these locations to receive more orders.'
        ];
    }
    
    /**
     * Cluster nearby locations together based on radius
     */
    private function clusterLocations($orders, $radiusKm)
    {
        $clusters = [];
        $processed = [];
        
        foreach ($orders as $index => $order) {
            if (in_array($index, $processed)) {
                continue;
            }
            
            // Create a new cluster
            $cluster = [
                'orders' => [$order],
                'indices' => [$index]
            ];
            
            // Find nearby orders
            foreach ($orders as $compareIndex => $compareOrder) {
                if ($index === $compareIndex || in_array($compareIndex, $processed)) {
                    continue;
                }
                
                $distance = $this->calculateDistance(
                    $order->pick_lat,
                    $order->pick_lng,
                    $compareOrder->pick_lat,
                    $compareOrder->pick_lng
                );
                
                // If within radius, add to cluster
                if ($distance <= $radiusKm) {
                    $cluster['orders'][] = $compareOrder;
                    $cluster['indices'][] = $compareIndex;
                    $processed[] = $compareIndex;
                }
            }
            
            $processed[] = $index;
            
            // Calculate cluster center (average of all points)
            $avgLat = collect($cluster['orders'])->avg('pick_lat');
            $avgLng = collect($cluster['orders'])->avg('pick_lng');
            $orderCount = count($cluster['orders']);
            
            // Get the most common area name in this cluster
            $areaName = collect($cluster['orders'])
                ->pluck('pick_name')
                ->mode()[0] ?? 'Unknown Area';
            
            $clusters[] = [
                'center_lat' => round($avgLat, 6),
                'center_lng' => round($avgLng, 6),
                'area_name' => $areaName,
                'order_count' => $orderCount,
                'percentage' => round(($orderCount / $orders->count()) * 100, 1)
            ];
        }
        
        return $clusters;
    }
    
    /**
     * Determine demand level based on order count
     */
    private function getDemandLevel($orderCount)
    {
        if ($orderCount >= 10) {
            return [
                'level' => 'very_high',
                'label' => 'Very High Demand',
                'color' => '#dc3545', // Red
                'icon' => '🔥'
            ];
        } elseif ($orderCount >= 7) {
            return [
                'level' => 'high',
                'label' => 'High Demand',
                'color' => '#fd7e14', // Orange
                'icon' => '⚡'
            ];
        } elseif ($orderCount >= 4) {
            return [
                'level' => 'medium',
                'label' => 'Medium Demand',
                'color' => '#ffc107', // Yellow
                'icon' => '📍'
            ];
        } else {
            return [
                'level' => 'low',
                'label' => 'Low Demand',
                'color' => '#28a745', // Green
                'icon' => '📌'
            ];
        }
    }
    
    /**
     * Check wallet status and determine if driver needs to recharge
     */
    private function checkWalletStatus($currentBalance, $minBalance)
    {
        $isEligible = $currentBalance >= $minBalance;
        $needsRecharge = !$isEligible;
        $requiredAmount = $needsRecharge ? ($minBalance - $currentBalance) : 0;
        
        $popupMessage = null;
        if ($needsRecharge) {
            $popupMessage = [
                'title' => 'Wallet Recharge Required',
                'message' => "Your wallet balance is {$currentBalance}. You need at least {$minBalance} to receive orders. Please recharge your wallet with {$requiredAmount} or more to start receiving orders.",
                'action_text' => 'Recharge Wallet',
                'show_popup' => true
            ];
        }
        
        return [
            'is_eligible' => $isEligible,
            'needs_recharge' => $needsRecharge,
            'required_amount' => $requiredAmount,
            'popup_message' => $popupMessage
        ];
    }
    
    /**
     * Get today's statistics for the driver
     */
     private function getTodayStatistics($driverId)
    {
        $today = now()->format('Y-m-d');
    
        // Get today's completed orders count
        $todayOrdersCount = \DB::table('orders')
            ->where('driver_id', $driverId)
            ->where('status', 'completed')
            ->whereDate('updated_at', $today)
            ->count();
    
        // Get today's earnings from completed orders
        $todayEarnings = \DB::table('orders')
            ->where('driver_id', $driverId)
            ->where('status', 'completed')
            ->whereDate('updated_at', $today)
            ->sum('net_price_for_driver');
    
        // Calculate today's distance
        $todayDistance = $this->calculateTodayDistance($driverId, $today);
    
        return [
            'orders_completed_today' => $todayOrdersCount,
            'earnings_today' => round($todayEarnings, 2),
            'distance_traveled_today' => [
                'meters' => round($todayDistance, 2),
                'kilometers' => round($todayDistance / 1000, 2)
            ],
            'date' => $today
        ];
    }

    
    /**
     * Calculate total distance traveled today based on completed orders
     */
    private function calculateTodayDistance($driverId, $today)
    {
        $completedOrders = \DB::table('orders')
            ->where('driver_id', $driverId)
            ->where('status', 'completed')
            ->whereDate('updated_at', $today)
            ->whereNotNull('pick_lat')
            ->whereNotNull('pick_lng')
            ->whereNotNull('drop_lat')
            ->whereNotNull('drop_lng')
            ->select('pick_lat', 'pick_lng', 'drop_lat', 'drop_lng')
            ->get();
        
        $totalDistance = 0;
        
        foreach ($completedOrders as $order) {
            $distance = $this->calculateDistance(
                $order->pick_lat,
                $order->pick_lng,
                $order->drop_lat,
                $order->drop_lng
            );
            
            // Convert from kilometers to meters
            $totalDistance += ($distance * 1000);
        }
        
        return $totalDistance;
    }
    
    /**
     * Calculate distance between two coordinates using Haversine formula
     * Returns distance in kilometers
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        
        $a = sin($dLat/2) * sin($dLat/2) + 
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLng/2) * sin($dLng/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;
        
        return $distance;
    }
}
