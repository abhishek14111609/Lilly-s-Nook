<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private const VALID_SIZES = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL'];

    public function show(Product $product)
    {
        $product->load(['category', 'variants']);
        $sizeOptions = $product->availableSizeOptions();
        $firstAvailableSize = collect($sizeOptions)->firstWhere('available', true);
        $selectedSize = old('size', $firstAvailableSize['value'] ?? $sizeOptions[0]['value'] ?? null);
        $selectedPrice = $product->priceForSize($selectedSize);
        $availableStock = collect($sizeOptions)->sum('stock');
        $canPurchase = collect($sizeOptions)->contains(fn(array $option) => $option['available']);

        $relatedProducts = Product::query()
            ->whereKeyNot($product->id)
            ->when($product->category_id, fn($query) => $query->where('category_id', $product->category_id))
            ->take(4)
            ->get();

        $productReviews = $product->reviews()
            ->where('is_active', '=', true)
            ->whereNotNull('quote', 'and')
            ->with('user:id,name')
            ->latest('id')
            ->paginate(6)
            ->withQueryString();

        $ratingAggregate = $product->reviews()
            ->where('is_active', '=', true)
            ->selectRaw('COUNT(*) as total_reviews, COALESCE(AVG(rating), 0) as average_rating')
            ->first();

        $canReviewProduct = false;
        $userReviewForProduct = null;

        if (Auth::check()) {
            $user = Auth::user();

            $canReviewProduct = OrderItem::query()
                ->where('product_id', '=', $product->id)
                ->whereHas('order', fn($query) => $query->where('user_id', '=', $user->id))
                ->exists();

            $userReviewForProduct = Review::query()
                ->where('product_id', '=', $product->id)
                ->where('user_id', '=', $user->id)
                ->first();
        }

        return view('products.show', compact(
            'product',
            'relatedProducts',
            'sizeOptions',
            'productReviews',
            'ratingAggregate',
            'canReviewProduct',
            'userReviewForProduct',
            'selectedSize',
            'selectedPrice',
            'canPurchase',
            'availableStock'
        ));
    }

    public function addToCart(Request $request, Product $product)
    {
        $sizeOptions = $product->availableSizeOptions();
        $availableSizeValues = collect($sizeOptions)->pluck('value')->all();

        $validated = $request->validate([
            'size' => empty($availableSizeValues)
                ? ['nullable', 'string', 'max:20']
                : ['required', 'string', Rule::in($availableSizeValues)],
        ]);

        $selectedSize = $validated['size'] ?? $sizeOptions[0]['value'] ?? 'ONE SIZE';
        $availableStock = $product->sizeStockFor($selectedSize);

        $cartItem = CartItem::query()->firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'size' => $selectedSize,
        ]);

        if ($availableStock <= 0) {
            return back()->with('status', 'Sorry, this product is out of stock.');
        }

        $newQuantity = min(($cartItem->exists ? $cartItem->quantity : 0) + 1, $availableStock);

        if ($cartItem->exists && $cartItem->quantity >= $availableStock) {
            return back()->with('status', 'No more stock available for this product.');
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        if ($request->boolean('buy_now')) {
            return redirect()->route('checkout.show');
        }

        return back()->with('status', 'Product added to cart.');
    }

    public function addToWishlist(Request $request, Product $product)
    {
        WishlistItem::query()->firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return back()->with('status', 'Product added to wishlist.');
    }

    public function search(Request $request)
    {
        $query = (string) $request->input('q', '');

        if (strlen($query) < 1) {
            return response()->json([
                'products' => [],
                'categories' => [],
                'subcategories' => [],
            ]);
        }

        $term = trim($query);

        $products = Product::query()
            ->with('category.parent')
            ->where(function ($builder) use ($term): void {
                $builder
                    ->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($term): void {
                        $categoryQuery
                            ->where('name', 'like', "%{$term}%")
                            ->orWhereHas('parent', function ($parentQuery) use ($term): void {
                                $parentQuery->where('name', 'like', "%{$term}%");
                            });
                    });
            })
            ->take(6)
            ->get(['id', 'name', 'price', 'image', 'category_id']);

        $categories = Category::query()
            ->whereNull('parent_id', 'and', false)
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name', 'asc')
            ->take(4)
            ->get(['id', 'name', 'slug']);

        $subcategories = Category::query()
            ->with('parent:id,name')
            ->whereNotNull('parent_id', 'and', false)
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name', 'asc')
            ->take(4)
            ->get(['id', 'name', 'slug', 'parent_id']);

        return response()->json([
            'products' => $products->map(fn(Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'type' => 'product',
            ]),
            'categories' => $categories->map(fn(Category $category) => [
                'id' => $category->id,
                'name' => $category->name,
                'type' => 'category',
                'url' => route('shop.index', ['category_id' => $category->id]),
            ]),
            'subcategories' => $subcategories->map(fn(Category $category) => [
                'id' => $category->id,
                'name' => $category->name,
                'parent_name' => $category->parent?->name,
                'type' => 'subcategory',
                'url' => route('shop.index', ['category_id' => $category->id]),
            ]),
        ]);
    }
}
