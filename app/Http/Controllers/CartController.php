<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with(['product.variants'])->get();
        $subtotal = $cartItems->sum(fn(CartItem $item) => (float) $item->product->priceForSize($item->size) * $item->quantity);

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return back()->with('status', 'Cart updated.');
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        CartItem::query()->whereKey($cartItem->getKey())->delete();

        return back()->with('status', 'Item removed from cart.');
    }
}
