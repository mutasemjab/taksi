<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

    public function handle()  // ✅ NO parameters!
    {
        try {
            $order = Order::find($this->orderId);
            
            if (!$order || $order->status != OrderStatus::Pending) {
                \Log::info("Order {$this->orderId} not pending. Stopping.");
                return;
            }
            
            $initialRadius = \DB::table('settings')
                ->where('key', 'find_drivers_in_radius')
                ->value('value') ?? 5;
            
            $maximumRadius = \DB::table('settings')
                ->where('key', 'maximum_radius_to_find_drivers')
                ->value('value') ?? 20;
            
            $nextRadius = $this->currentRadius + $initialRadius;
            
            if ($nextRadius > $maximumRadius) {
                \Log::info("Max radius reached for order {$this->orderId}");
                return;
            }
            
            \Log::info("Expanding search to {$nextRadius}km for order {$this->orderId}");
            
            // ✅ Use app() to resolve service (creates Firestore only when needed)
            $driverLocationService = app(\App\Services\DriverLocationService::class);
            
            $result = $driverLocationService->findAndStoreOrderInFirebase(
                $this->userLat,
                $this->userLng,
                $this->orderId,
                $this->serviceId,
                $nextRadius * 1000, // Convert to meters
                OrderStatus::Pending->value
            );
            
            if ($result['success']) {
                \Log::info("Found {$result['drivers_found']} drivers in {$nextRadius}km for order {$this->orderId}");
            }
            
            // Schedule next expansion
            if ($nextRadius < $maximumRadius) {
                SearchDriversInNextZone::dispatch(
                    $this->orderId,
                    $nextRadius,
                    $this->serviceId,
                    $this->userLat,
                    $this->userLng
                );
            }
            
        } catch (\Exception $e) {
            \Log::error("Error in SearchDriversInNextZone: " . $e->getMessage());
        }
    }
}