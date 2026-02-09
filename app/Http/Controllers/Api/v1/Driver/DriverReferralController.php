<?php

namespace App\Http\Controllers\Api\v1\Driver;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverReferralController extends Controller
{
    /**
     * Get comprehensive referral information including stats and referred users list
     * 
     * Query Parameters:
     * - per_page: Number of items per page (default: 15)
     * - type: Filter type ('all', 'users', 'drivers') (default: 'all')
     * - page: Page number (default: 1)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferralInfo(Request $request)
    {
        try {
            $driver = Auth::guard('driver-api')->user();
            
            // Pagination parameters
            $perPage = $request->get('per_page', 15);
            $type = $request->get('type', 'all'); // all, users, drivers
            $page = $request->get('page', 1);
            
            // Get referred users
            $referredUsers = [];
            $referredDrivers = [];
            
            if ($type === 'all' || $type === 'users') {
                $referredUsers = User::where('driver_id', $driver->id)
                    ->select('id', 'name', 'phone', 'photo', 'created_at')
                    ->get()
                    ->map(function ($refUser) {
                        return [
                            'id' => $refUser->id,
                            'name' => $refUser->name,
                            'phone' => $refUser->phone,
                            'photo_url' => $refUser->photo_url,
                            'type' => 'user',
                            'joined_date' => $refUser->created_at->format('Y-m-d H:i:s'),
                            'formatted_date' => $refUser->created_at->diffForHumans(),
                        ];
                    });
            }
            
            if ($type === 'all' || $type === 'drivers') {
                $referredDrivers = Driver::where('driver_id', $driver->id)
                    ->select('id', 'name', 'phone', 'photo', 'created_at')
                    ->get()
                    ->map(function ($refDriver) {
                        return [
                            'id' => $refDriver->id,
                            'name' => $refDriver->name,
                            'phone' => $refDriver->phone,
                            'photo_url' => $refDriver->photo_url,
                            'type' => 'driver',
                            'joined_date' => $refDriver->created_at->format('Y-m-d H:i:s'),
                            'formatted_date' => $refDriver->created_at->diffForHumans(),
                        ];
                    });
            }
            
            // Merge and sort by date
            $allReferrals = collect($referredUsers)
                ->merge($referredDrivers)
                ->sortByDesc('joined_date')
                ->values();
            
            // Calculate counts
            $referredUsersCount = User::where('driver_id', $driver->id)->count();
            $referredDriversCount = Driver::where('driver_id', $driver->id)->count();
            $totalReferrals = $referredUsersCount + $referredDriversCount;
            
            // Paginate
            $total = $allReferrals->count();
            $items = $allReferrals->forPage($page, $perPage)->values();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'referral_code' => $driver->referral_code,
                    'total_referrals' => $totalReferrals,
                    'referred_users_count' => $referredUsersCount,
                    'referred_drivers_count' => $referredDriversCount,
                    'referred_list' => $items,
                    'pagination' => [
                        'total' => $total,
                        'per_page' => $perPage,
                        'current_page' => $page,
                        'last_page' => $total > 0 ? ceil($total / $perPage) : 1,
                    ]
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching referral information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
}