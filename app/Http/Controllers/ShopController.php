<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString() ?: 'newest';
        $search = trim($request->string('s')->toString());
        $categoryId = $request->integer('category_id');
        $priceRange = trim($request->string('price')->toString());

        $query = Product::with('category');

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhereHas('parent', function ($parentQuery) use ($search): void {
                                $parentQuery->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        if ($categoryId > 0) {
            $selectedCategory = Category::query()->with('children:id,parent_id')->find($categoryId);

            if ($selectedCategory) {
                $categoryIds = collect([$selectedCategory->id])
                    ->merge($selectedCategory->children->pluck('id'))
                    ->unique()
                    ->values()
                    ->all();

                $query->whereIn('category_id', $categoryIds);
            }
        }

        $priceStats = (clone $query)
            ->toBase()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        $priceRanges = $this->buildPriceRanges(
            $priceStats?->min_price !== null ? (float) $priceStats->min_price : null,
            $priceStats?->max_price !== null ? (float) $priceStats->max_price : null,
        );

        if (preg_match('/^(\d+)-(\d+)$/', $priceRange, $matches)) {
            $query->whereBetween('price', [(float) $matches[1], (float) $matches[2]]);
        } elseif (preg_match('/^lt(\d+)$/', $priceRange, $matches)) {
            $query->where('price', '<', (float) $matches[1]);
        } elseif (preg_match('/^gte(\d+)$/', $priceRange, $matches)) {
            $query->where('price', '>=', (float) $matches[1]);
        }

        $wishlistProductIds = Auth::check()
            ? Auth::user()->wishlistItems()->pluck('product_id')->all()
            : [];

        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc' => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            default => $query->latest(),
        };

        return view('shop.index', [
            'products' => $query->paginate(12)->withQueryString(),
            'categories' => Category::query()
                ->whereNull('parent_id', 'and', false)
                ->with(['children' => fn($q) => $q->orderBy('name')])
                ->orderBy('name')
                ->get(),
            'filters' => ['sort' => $sort, 'search' => $search, 'category_id' => $categoryId, 'priceRange' => $priceRange],
            'priceRanges' => $priceRanges,
            'wishlistProductIds' => $wishlistProductIds,
        ]);
    }

    /**
     * Build dynamic price bands from the visible product price range.
     *
     * @return array<int, array{label:string,value:string,id:string}>
     */
    private function buildPriceRanges(?float $minPrice, ?float $maxPrice): array
    {
        $minPrice = $minPrice !== null ? max(0, $minPrice) : null;
        $maxPrice = $maxPrice !== null ? max(0, $maxPrice) : null;

        if ($minPrice === null || $maxPrice === null || $maxPrice <= 0) {
            return [
                ['label' => 'All Prices', 'value' => '', 'id' => 'priceAll'],
                ['label' => 'Under ₹100', 'value' => 'lt100', 'id' => 'price1'],
                ['label' => '₹100 - ₹200', 'value' => '100-200', 'id' => 'price2'],
                ['label' => '₹200 & Above', 'value' => 'gte200', 'id' => 'price3'],
            ];
        }

        if (abs($maxPrice - $minPrice) < 1) {
            $threshold = max(1, (int) round($maxPrice));

            return [
                ['label' => 'All Prices', 'value' => '', 'id' => 'priceAll'],
                ['label' => 'Under ₹' . $threshold, 'value' => 'lt' . $threshold, 'id' => 'price1'],
                ['label' => '₹' . $threshold . ' & Above', 'value' => 'gte' . $threshold, 'id' => 'price2'],
            ];
        }

        $span = $maxPrice - $minPrice;
        $firstBreak = (int) round($minPrice + ($span / 3));
        $secondBreak = (int) round($minPrice + (($span * 2) / 3));

        $firstBreak = max(1, min($firstBreak, (int) floor($maxPrice) - 1));
        $secondBreak = max($firstBreak + 1, min($secondBreak, (int) round($maxPrice)));

        if ($secondBreak <= $firstBreak) {
            $secondBreak = $firstBreak + 1;
        }

        return [
            ['label' => 'All Prices', 'value' => '', 'id' => 'priceAll'],
            ['label' => 'Under ₹' . number_format($firstBreak), 'value' => 'lt' . $firstBreak, 'id' => 'price1'],
            ['label' => '₹' . number_format($firstBreak) . ' - ₹' . number_format($secondBreak), 'value' => $firstBreak . '-' . $secondBreak, 'id' => 'price2'],
            ['label' => '₹' . number_format($secondBreak) . ' & Above', 'value' => 'gte' . $secondBreak, 'id' => 'price3'],
        ];
    }
}
