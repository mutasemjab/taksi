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

    /**
     * Execute - NO dependencies, call service via HTTP or artisan command
     */
    public function handle()
    {
        try {
            // Check if order still pending
            $order = Order::find($this->orderId);
            
            if (!$order || $order->status != OrderStatus::Pending) {
                \Log::info("Order {$this->orderId} not pending. Stopping search.");
                return;
            }
            
            // Get settings
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
            
            \Log::info("Triggering search for {$nextRadius}km zone for order {$this->orderId}");
            
            // ✅ Call artisan command to trigger search (runs in web context, has gRPC)
            \Artisan::call('orders:expand-search', [
                'order_id' => $this->orderId,
                'radius' => $nextRadius,
            ]);
            
            // Schedule next zone
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