<?php

namespace App\Services;

use App\Jobs\LowStockJob;
use App\Models\ProductVariant;
use App\Repositories\ProductRepositoryInterface;

class InventoryService
{
    public function deductStock(ProductVariant $variant, int $quantity)
    {
        if ($variant->stock < $quantity) {
            throw new \Exception("Not enough stock");
        }
        $variant->stock -= $quantity;
        $variant->save();
        if ($variant->stock < 5) { // low stock alert threshold
            LowStockJob::dispatch($variant);
        }
    }

    public function restoreStock(ProductVariant $variant, int $quantity)
    {
        $variant->stock += $quantity;
        $variant->save();
    }
}
