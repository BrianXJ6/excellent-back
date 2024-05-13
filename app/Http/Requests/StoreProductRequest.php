<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Dto\StoreProductDto;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100', Rule::unique(Product::class)],
            'description' => ['sometimes', 'string', 'max:255'],
            'price' => ['required', 'decimal:0,2', 'between:0.01,999999.99'],
            'stock' => ['required', 'integer', 'min:1'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['required', File::image()->max(10 * 1024)],
        ];
    }

    /**
     * Get the DTO from this request
     *
     * @return \App\Dto\StoreProductDto
     */
    public function data(): StoreProductDto
    {
        return new StoreProductDto(...$this->validated());
    }
}
