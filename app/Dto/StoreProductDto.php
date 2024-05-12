<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class StoreProductDto extends BaseDto
{
    /**
     * Create a new Store ProductDto instance
     *
     * @param string $title
     * @param float $price
     * @param integer $stock
     * @param null|string $description
     * @param null|array<integer, \Illuminate\Http\File|\Illuminate\Http\UploadedFile> $images
     */
    public function __construct(
        public readonly string $title,
        public readonly float $price,
        public readonly int $stock,
        public readonly ?string $description = null,
        public readonly ?array $images = null
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
        return array_filter((array) [
            'title' => $this->title,
            'price' => $this->price,
            'stock' => $this->stock,
            'description' => $this->description,
        ], fn ($field) => !is_null($field));
    }
}
