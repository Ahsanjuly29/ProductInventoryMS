<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $order = $this->service->createOrder($request->user(), $request->items);
        return response()->json($order, 201);
    }

    public function cancel($id)
    {
        $order = $this->service->cancelOrder($id);
        return response()->json($order);
    }
}
