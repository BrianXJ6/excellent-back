<?php

namespace App\Models;

use App\Support\ORM\BaseSimpleModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends BaseSimpleModel
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['path'];

    /**
     * Get the product that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
