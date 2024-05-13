<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Dto\UpdateProductDto;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:100', Rule::unique(Product::class)->ignore($this->product->id)],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'price' => ['sometimes', 'decimal:0,2', 'between:0.01,999999.99'],
            'stock' => ['sometimes', 'integer', 'min:1'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['sometimes', File::image()->max(10 * 1024)],
        ];
    }

    /**
     * Get the DTO from this request
     *
     * @return \App\Dto\UpdateProductDto
     */
    public function data(): UpdateProductDto
    {
        return new UpdateProductDto(...$this->validated());
    }
}
