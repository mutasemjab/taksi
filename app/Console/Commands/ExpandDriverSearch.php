<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DriverLocationService;
use App\Models\Order;
use App\Enums\OrderStatus;

class ExpandDriverSearch extends Command
{
    protected $signature = 'orders:expand-search {order_id} {radius}';
    protected $description = 'Expand driver search to new radius';

    public function handle(DriverLocationService $driverLocationService)
    {
        $orderId = $this->argument('order_id');
        $radius = $this->argument('radius');
        
        $order = Order::find($orderId);
        
        if (!$order || $order->status != OrderStatus::Pending) {
            return;
        }
        
        // Search and update Firebase
        $result = $driverLocationService->findAndStoreOrderInFirebase(
            $order->pick_lat,
            $order->pick_lng,
            $orderId,
            $order->service_id,
            $radius * 1000, // Convert to meters
            OrderStatus::Pending->value
        );
        
        $this->info("Search completed for radius {$radius}km");
        
        return Command::SUCCESS;
    }
}