<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class UpdateProductDto extends BaseDto
{
    /**
     * Create a new Update ProductDto instance
     *
     * @param string $title
     * @param float $price
     * @param integer $stock
     * @param null|string $description
     * @param null|array<integer, \Illuminate\Http\File|\Illuminate\Http\UploadedFile> $images
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?float $price = null,
        public readonly ?int $stock = null,
        public readonly ?string $description = null,
        public readonly ?array $images = null,
    ) {
        // ...
    }

    /**
     * Get data to storage product
     *
     * @return array
     */
    public function dataToStorage(): array
    {
        $nullableFields = ['description' => $this->description];

        return array_merge($nullableFields, array_filter((array) [
            'title' => $this->title,
            'price' => $this->price,
            'stock' => $this->stock,
        ], fn ($field) => !is_null($field)));
    }
}
