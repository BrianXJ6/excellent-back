<?php

namespace App\Rules;

use Closure;
use App\Models\Product;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckProductStock implements ValidationRule, DataAwareRule
{
    public const MAIN = 'products';

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure $fail
     *
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $index = (int) explode('.', $attribute)[1];
        $productId = (int) $this->data[self::MAIN][$index]['id'];
        $stock = (int) $this->data[self::MAIN][$index]['quantity'];

        $availableStock = Product::where((new Product())->getKeyName(), $productId)->value('stock');

        if ($availableStock < $stock) {
            $fail("The unavailable quantity in stock for product ID: {$productId}");
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     *
     * @return static
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
