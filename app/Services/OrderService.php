<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Dto\StoreOrderDto;
use Illuminate\Support\Collection;

class OrderService
{
    /**
     * Default values for relationships between order and product
     *
     * @var array
     */
    protected const WITH = [
        'products:id,title',
        'products.productImages:product_id,path',
    ];

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Support\Collection
     */
    public function listAll(): Collection
    {
        return Order::with(self::WITH)
                    ->latest((new Order())->getKeyName())
                    ->get();
    }

    /**
     * Store a newly created order in storage.
     *
     * @param \App\Dto\StoreOrderDto $data
     *
     * @return \App\Models\Order
     */
    public function store(StoreOrderDto $data): Order
    {
        /** @var \App\Models\Order */
        $order = Order::create();

        $attachArray = [];
        foreach ($data->products as $product) {
            Product::find($product['id'])->decrement('stock', $product['quantity']);
            $attachArray[$product['id']] = ['quantity' => $product['quantity']];
        }

        $order->products()->attach($attachArray);
        $order->load(self::WITH);

        return $order;
    }
}
