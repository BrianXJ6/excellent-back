<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Dto\StoreOrderDto;
use Illuminate\Validation\Rule;
use App\Rules\CheckProductStock;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'products' => ['required', 'array'],
            'products.*.id' => [
                'required',
                'integer',
                'min:1',
                Rule::exists(Product::class, (new Product())->getKeyName())
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
                new CheckProductStock()
            ],
        ];
    }

    /**
     * Get the DTO from this request
     *
     * @return \App\Dto\StoreOrderDto
     */
    public function data(): StoreOrderDto
    {
        return new StoreOrderDto($this->validated('products'));
    }
}
