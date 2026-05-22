<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () use ($request, $product) {
            $cartItem = CartItem::query()->firstOrNew([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'size' => $request->input('size', 'M'),
            ]);

            $cartItem->quantity = min(($cartItem->exists ? $cartItem->quantity : 0) + 1, 99);
            $cartItem->save();

            WishlistItem::query()
                ->where('user_id', $request->user()->id)
                ->where('product_id', $product->id)
                ->delete();
        });

        return back()->with('status', 'Item moved to bag and removed from wishlist.');
    }

    public function destroy(Request $request, WishlistItem $wishlistItem)
    {
        abort_unless($wishlistItem->user_id === $request->user()->id, 403);

        WishlistItem::destroy($wishlistItem->getKey());

        return back()->with('status', 'Item removed from wishlist.');
    }
}
