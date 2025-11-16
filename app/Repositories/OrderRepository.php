<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function all()
    {
        return Order::with('items.variant')->paginate(20);
    }

    public function find($id)
    {
        return Order::with('items.variant')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function updateStatus($id, $status)
    {
        $order = $this->find($id);
        $order->status = $status;
        $order->save();
        return $order;
    }
}
