<?php

namespace App\Models;

use App\Support\ORM\BaseSimpleModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
     * Get the path's image.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function path(): Attribute
    {
        return Attribute::make(
            get: function (?string $path) {
                if (!$path) {
                    return null;
                }

                /** @var \Illuminate\Filesystem\Filesystem */
                $disk = Storage::disk('public');

                return $disk->url($path);
            },
        );
    }

    /**
     * Get the product that owns the image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
