<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    /**
     * Create a new Order Controller instance
     *
     * @param \App\Services\OrderService $orderService
     */
    public function __construct(private OrderService $service)
    {
        // ...
    }

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(): JsonResource
    {
        return OrderResource::collection($this->service->listAll());
    }
}
