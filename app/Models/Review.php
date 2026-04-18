<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'role',
        'quote',
        'rating',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
            'user_id' => 'integer',
            'rating' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
