<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\DriverLocationService;
use App\Models\Order;
use App\Enums\OrderStatus;

class SearchDriversInNextZone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;
    protected $currentRadius;
    protected $serviceId;
    protected $userLat;
    protected $userLng;

    public function __construct($orderId, $currentRadius, $serviceId, $userLat, $userLng)
    {
        $this->orderId = $orderId;
        $this->currentRadius = $currentRadius;
        $this->serviceId = $serviceId;
        $this->userLat = $userLat;
        $this->userLng = $userLng;
        
        $this->delay(now()->addSeconds(30));
    }

    public function handle(DriverLocationService $driverLocationService)
    {
        try {
            // Check if order still pending
            $order = Order::find($this->orderId);
            
            if (!$order) {
                \Log::info("Order {$this->orderId} not found. Stopping driver search.");
                return;
            }
            
            if ($order->status != OrderStatus::Pending) {
                \Log::info("Order {$this->orderId} is no longer pending. Stopping driver search.");
                return;
            }
            
            // Get radius settings
            $initialRadius = \DB::table('settings')
                ->where('key', 'find_drivers_in_radius')
                ->value('value') ?? 5;
            
            $maximumRadius = \DB::table('settings')
                ->where('key', 'maximum_radius_to_find_drivers')
                ->value('value') ?? 20;
            
            $nextRadius = $this->currentRadius + $initialRadius;
            
            if ($nextRadius > $maximumRadius) {
                \Log::info("Reached maximum radius ({$maximumRadius}km) for order {$this->orderId}.");
                return;
            }
            
            \Log::info("Expanding search to {$nextRadius}km for order {$this->orderId}");
            
            // ✅ Use the service to search and update Firebase
            $result = $driverLocationService->searchAndUpdateFirebase(
                $this->userLat,
                $this->userLng,
                $this->orderId,
                $this->serviceId,
                $nextRadius,
                OrderStatus::Pending->value
            );
            
            if ($result['success']) {
                \Log::info("Found {$result['drivers_found']} drivers in {$nextRadius}km zone for order {$this->orderId}");
                
                // Schedule next zone if not at maximum
                if ($nextRadius < $maximumRadius) {
                    SearchDriversInNextZone::dispatch(
                        $this->orderId,
                        $nextRadius,
                        $this->serviceId,
                        $this->userLat,
                        $this->userLng
                    );
                }
            } else {
                \Log::info("No drivers found in {$nextRadius}km zone for order {$this->orderId}");
                
                // Continue to next zone
                if ($nextRadius < $maximumRadius) {
                    SearchDriversInNextZone::dispatch(
                        $this->orderId,
                        $nextRadius,
                        $this->serviceId,
                        $this->userLat,
                        $this->userLng
                    );
                }
            }
            
        } catch (\Exception $e) {
            \Log::error("Error in SearchDriversInNextZone: " . $e->getMessage());
        }
    }
}