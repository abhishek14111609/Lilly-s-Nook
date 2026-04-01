<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlistItems = $request->user()->wishlistItems()->with('product')->latest()->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function moveToCart(Request $request, Product $product)
    {
        $request->validate([
            'size' => ['nullable', 'in:XS,S,M,L,XL,XXL'],
        ]);

        $cartItem = CartItem::query()->firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'size' => $request->input('size', 'M'),
        ]);

        $cartItem->quantity = min(($cartItem->exists ? $cartItem->quantity : 0) + 1, 99);
        $cartItem->save();

        return back()->with('status', 'Wishlist item added to cart.');
    }

    public function destroy(Request $request, WishlistItem $wishlistItem)
    {
        abort_unless($wishlistItem->user_id === $request->user()->id, 403);

        $wishlistItem->delete();

        return back()->with('status', 'Item removed from wishlist.');
    }
}
