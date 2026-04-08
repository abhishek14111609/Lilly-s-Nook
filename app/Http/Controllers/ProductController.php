<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private const VALID_SIZES = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

    public function show(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::query()
            ->whereKeyNot($product->id)
            ->when($product->category_id, fn($query) => $query->where('category_id', $product->category_id))
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $validated = $request->validate([
            'size' => ['required', 'in:' . implode(',', self::VALID_SIZES)],
        ]);

        $cartItem = CartItem::query()->firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'size' => $validated['size'],
        ]);

        if ($product->stock <= 0) {
            return back()->with('status', 'Sorry, this product is out of stock.');
        }

        $newQuantity = min(($cartItem->exists ? $cartItem->quantity : 0) + 1, $product->stock);

        if ($cartItem->exists && $cartItem->quantity >= $product->stock) {
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
        $query = $request->get('q', '');

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
            ->whereNull('parent_id')
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name')
            ->take(4)
            ->get(['id', 'name', 'slug']);

        $subcategories = Category::query()
            ->with('parent:id,name')
            ->whereNotNull('parent_id')
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name')
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
