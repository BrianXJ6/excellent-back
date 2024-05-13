<?php

namespace App\Services;

use App\Models\Order;
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
}
