<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
                        $q->where('name', 'like', "%{$search}%");
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

        if (preg_match('/^(\d+)-(\d+)$/', $priceRange, $matches)) {
            $query->whereBetween('price', [(float) $matches[1], (float) $matches[2]]);
        } elseif (preg_match('/^lt(\d+)$/', $priceRange, $matches)) {
            $query->where('price', '<', (float) $matches[1]);
        }

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
                ->whereNull('parent_id')
                ->with(['children' => fn($q) => $q->orderBy('name')])
                ->orderBy('name')
                ->get(),
            'filters' => ['sort' => $sort, 'search' => $search, 'category_id' => $categoryId, 'priceRange' => $priceRange],
        ]);
    }
}
