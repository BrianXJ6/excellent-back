<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class StoreOrderDto extends BaseDto
{
    /**
     * Create a new Store Order Dto instance
     *
     * @param array $products
     */
    public function __construct(public readonly array $products)
    {
        // ...
    }
}
