<?php

namespace App\Models;

use App\Support\ORM\BaseSimpleModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends BaseSimpleModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['qtd'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['qtd' => 'integer'];
    }

    /**
     * The products that belong to the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
