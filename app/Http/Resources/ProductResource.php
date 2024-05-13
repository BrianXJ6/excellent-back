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
            'description' => $this->when(!empty($this->description), $this->description),
            'price' => $this->when(!empty($this->price), (float) $this->price),
            'stock' => $this->when(!empty($this->stock), $this->stock),
            'images' => ProductImageResource::collection($this->productImages),
            'updated_at' => $this->when(!empty($this->updated_at), $this->updated_at?->from()),
            'created_at' => $this->when(!empty($this->created_at), $this->created_at?->from()),
        ];
    }
}
