<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    /**
     * Create a new Product Controller instance
     *
     * @param ProductService $service
     */
    public function __construct(private ProductService $service)
    {
        // ...
    }

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(): JsonResource
    {
        $response = $this->service->listAll();

        return ProductResource::collection($response);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreProductRequest $request): JsonResource
    {
        $product = DB::transaction(fn () => $this->service->store($request->data()));

        return ProductResource::make($product);
    }

    /**
     * Display the specified product.
     *
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Product $product): JsonResource
    {
        return ProductResource::make($product);
    }

    /**
     * Update the specified product in storage.
     *
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResource
    {
        $product = DB::transaction(fn () => $this->service->update($product, $request->data()));

        return ProductResource::make($product);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        DB::transaction(fn () => $this->service->destroy($product));

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
