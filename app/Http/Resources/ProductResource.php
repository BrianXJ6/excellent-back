<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Create a new Product Resource instance
     *
     * @param Product $product
     */
    public function __construct(private Product $product)
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
        $this->resource->loadMissing('productImages');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => (float) $this->price,
            'stock' => $this->stock,
            'images' => ProductImageResource::collection($this->productImages),
            'created_at' => $this->created_at->from(),
            'updated_at' => $this->updated_at->from(),
        ];
    }
}
