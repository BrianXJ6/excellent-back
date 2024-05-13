<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderResource;
use App\Http\Requests\StoreOrderRequest;
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

    /**
     * Store a newly created order in storage.
     *
     * @param \App\Http\Requests\StoreOrderRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreOrderRequest $request): JsonResource
    {
        $order = DB::transaction(fn () => $this->service->store($request->data()));

        return OrderResource::make($order);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return new JsonResponse(status:JsonResponse::HTTP_NO_CONTENT);
    }
}
