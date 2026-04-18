<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    private const SIZE_ORDER = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL'];

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'video',
        'category_id',
        'subcategory_id',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function hasSizeVariants(): bool
    {
        return $this->variants()
            ->whereNotNull('size')
            ->where('size', '!=', '')
            ->exists();
    }

    public function normalizeSize(?string $size): string
    {
        return strtoupper(trim((string) $size));
    }

    public function availableSizeOptions(): array
    {
        $this->loadMissing('variants');

        $sizes = [];

        foreach ($this->variants as $variant) {
            if (! is_string($variant->size)) {
                continue;
            }

            $label = trim($variant->size);

            if ($label === '') {
                continue;
            }

            $value = $this->normalizeSize($label);

            if (! isset($sizes[$value])) {
                $sizes[$value] = [
                    'value' => $value,
                    'label' => $label,
                    'stock' => 0,
                    'price' => (float) $this->price,
                    'available' => false,
                ];
            }

            $sizes[$value]['stock'] += max(0, (int) $variant->stock);
            $sizes[$value]['price'] = (float) $this->price + (float) $variant->price_modifier;
            $sizes[$value]['available'] = $sizes[$value]['stock'] > 0;
        }

        if ($sizes === []) {
            return [[
                'value' => 'ONE SIZE',
                'label' => 'One Size',
                'stock' => max(0, (int) $this->stock),
                'price' => (float) $this->price,
                'available' => (int) $this->stock > 0,
            ]];
        }

        $options = array_values($sizes);

        usort($options, function (array $left, array $right): int {
            $leftIndex = array_search($left['value'], self::SIZE_ORDER, true);
            $rightIndex = array_search($right['value'], self::SIZE_ORDER, true);

            $leftKnown = $leftIndex !== false;
            $rightKnown = $rightIndex !== false;

            if ($leftKnown && $rightKnown) {
                return $leftIndex <=> $rightIndex;
            }

            if ($leftKnown) {
                return -1;
            }

            if ($rightKnown) {
                return 1;
            }

            return strcmp($left['label'], $right['label']);
        });

        return $options;
    }

    public function priceForSize(?string $size): float
    {
        $this->loadMissing('variants');

        if (! $this->hasSizeVariants()) {
            return (float) $this->price;
        }

        $normalizedSize = $this->normalizeSize($size);

        $matchingVariant = $this->variants->first(function (ProductVariant $variant) use ($normalizedSize): bool {
            return $this->normalizeSize($variant->size) === $normalizedSize;
        });

        return (float) $this->price + (float) ($matchingVariant?->price_modifier ?? 0);
    }

    public function sizeLabelFor(?string $size): string
    {
        $this->loadMissing('variants');

        if (! $this->hasSizeVariants()) {
            return 'One Size';
        }

        $normalizedSize = $this->normalizeSize($size);

        $matchingVariant = $this->variants->first(function (ProductVariant $variant) use ($normalizedSize): bool {
            return $this->normalizeSize($variant->size) === $normalizedSize;
        });

        return $matchingVariant?->size ?: (string) $size;
    }

    public function sizeStockFor(?string $size): int
    {
        if (! $this->hasSizeVariants()) {
            return max(0, (int) $this->stock);
        }

        $normalizedSize = $this->normalizeSize($size);

        return (int) $this->variants
            ->filter(function (ProductVariant $variant) use ($normalizedSize): bool {
                return $this->normalizeSize($variant->size) === $normalizedSize;
            })
            ->sum(fn(ProductVariant $variant) => max(0, (int) $variant->stock));
    }

    public function reduceStockForSize(?string $size, int $quantity): void
    {
        if ($quantity <= 0) {
            return;
        }

        if (! $this->hasSizeVariants()) {
            $this->stock = max(0, (int) $this->stock - $quantity);
            $this->save();

            return;
        }

        $normalizedSize = $this->normalizeSize($size);

        $matchingVariants = $this->variants
            ->filter(function (ProductVariant $variant) use ($normalizedSize): bool {
                return $this->normalizeSize($variant->size) === $normalizedSize;
            })
            ->sortBy('id');

        foreach ($matchingVariants as $variant) {
            if ($quantity <= 0) {
                break;
            }

            $deduct = min((int) $variant->stock, $quantity);

            if ($deduct > 0) {
                $variant->stock = max(0, (int) $variant->stock - $deduct);
                $variant->save();
                $quantity -= $deduct;
            }
        }
    }
}
