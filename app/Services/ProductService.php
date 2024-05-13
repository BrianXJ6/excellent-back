<?php

namespace App\Services;

use App\Models\Product;
use App\Dto\StoreProductDto;
use App\Dto\UpdateProductDto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Display a listing of the products.
     *
     * @return Collection
     */
    public function listAll(): Collection
    {
        return Product::with('productImages:product_id,path')
                        ->latest((new Product())->getKeyName())
                        ->get();
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \App\Dto\StoreProductDto $data
     *
     * @return \App\Models\Product
     */
    public function store(StoreProductDto $data): Product
    {
        $product = Product::create($data->dataToStorage());

        if (!empty($data->images)) {
            $this->addProductImages($product, $data->images);
        }

        return $product;
    }

    /**
     * Update the specified product in storage.
     *
     * @param \App\Models\Product $product
     * @param \App\Dto\UpdateProductDto $data
     *
     * @return \App\Models\Product
     */
    public function update(Product $product, UpdateProductDto $data): Product
    {
        $product->fill($data->dataToStorage())->save();

        if (!empty($data->images)) {
            $this->removeAllProductImages($product);
            $product->productImages()->delete();
            $this->addProductImages($product, $data->images);
        }

        return $product;
    }

    /**
     * Remove the specified product from storage.
     *
     * @param \App\Models\Product $product
     *
     * @return void
     */
    public function destroy(Product $product): void
    {
        $this->removeAllProductImages($product);
        $product->delete();
    }

    /**
     * Add product imagems from the specified product
     *
     * @param \App\Models\Product $product
     * @param array $images
     *
     * @return void
     */
    protected function addProductImages(Product $product, array $images): void
    {
        $paths = [];
        foreach ($images as $image) {
            $paths[] = ['path' => Storage::disk('public')->putFile('product-images', $image)];
        }

        $product->setRelation('productImages', $product->productImages()->createMany($paths));
    }

    /**
     * Remove all product images from the specified product
     *
     * @param \App\Models\Product $product
     *
     * @return void
     */
    protected function removeAllProductImages(Product $product): void
    {
        $product->loadMissing('productImages');

        /** @var \Illuminate\Support\Collection */
        $images = $product->productImages;

        if (!$images->isEmpty()) {
            Storage::disk('public')->delete($images->pluck('path')->toArray());
        }
    }
}
