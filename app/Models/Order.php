<?php

namespace App\Models;

use App\Support\ORM\BaseSimpleModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends BaseSimpleModel
{
    /**
     * The products that belong to the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
