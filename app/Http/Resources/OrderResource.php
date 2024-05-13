<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Create a new Order Resource instance
     *
     * @param Order $product
     */
    public function __construct(private Order $product)
    {
        parent::__construct($product);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        $this->resource->loadMissing([
            'products:id,title',
            'products.productImages',
        ]);

        return [
            'id' => $this->id,
            'created_at' => $this->created_at->from(),
            'updated_at' => $this->updated_at->from(),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
