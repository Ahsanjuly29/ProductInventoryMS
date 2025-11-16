<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Models\ProductVariant;
use App\Jobs\SendOrderNotificationJob;
use App\Jobs\GenerateInvoiceJob;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $repo;
    protected $inventoryService;

    public function __construct(OrderRepository $repo, \App\Services\InventoryService $inventoryService)
    {
        $this->repo = $repo;
        $this->inventoryService = $inventoryService;
    }

    public function createOrder($user, $items)
    {
        DB::beginTransaction();

        try {
            $orderData = ['user_id' => $user->id, 'status' => 'pending', 'total_amount' => 0];
            $order = $this->repo->create($orderData);

            $total = 0;
            foreach ($items as $item) {
                $variant = ProductVariant::findOrFail($item['variant_id']);
                $this->inventoryService->deductStock($variant, $item['quantity']);

                $order->items()->create([
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'price' => $variant->price
                ]);

                $total += $variant->price * $item['quantity'];
            }

            $order->total_amount = $total;
            $order->status = 'processing';
            $order->save();

            // Queue invoice generation
            GenerateInvoiceJob::dispatch($order);

            // Queue order notification email
            SendOrderNotificationJob::dispatch($order);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function cancelOrder($orderId)
    {
        $order = $this->repo->find($orderId);
        DB::beginTransaction();

        try {
            foreach ($order->items as $item) {
                $this->inventoryService->restoreStock($item->variant, $item->quantity);
            }

            $order->status = 'cancelled';
            $order->save();

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
