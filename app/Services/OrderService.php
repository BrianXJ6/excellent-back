<?php

namespace App\Services;

use App\Models\Order;
use App\Dto\StoreOrderDto;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;

class OrderService
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Support\Collection
     */
    public function listAll(): Collection
    {
        return Order::with([
            'products' => function (Builder $query) {
                /** @disregard  */
                $query->select(['products.id', 'products.title'])
                    ->orderByDesc('products.id');
            },
            'products.productImages' => function (Builder $query) {
                /** @disregard */
                $query->select(['product_images.product_id', 'product_images.path'])
                    ->orderByDesc('product_images.id');
            }
        ])
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
