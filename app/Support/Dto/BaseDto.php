<?php

namespace App\Support\Dto;

use Illuminate\Contracts\Support\Arrayable;

abstract class BaseDto implements Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
