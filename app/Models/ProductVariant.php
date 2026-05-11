<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string|null $size
 * @property string|null $color
 * @property int|null $stock
 * @property string|float|null $price_modifier
 */
class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'stock',
        'price_modifier',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
