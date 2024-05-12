<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    /**
     * Create a new Product Image Resource instance
     *
     * @param ProductImage $productImage
     */
    public function __construct(private ProductImage $productImage)
    {
        parent::__construct($productImage);
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
        return ['path' => $this->path];
    }
}
