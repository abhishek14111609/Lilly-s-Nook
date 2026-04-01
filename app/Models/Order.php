<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'city',
        'zip',
        'phone',
        'email',
        'total',
        'payment_method',
        'status',
        'ordered_at',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'ordered_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
