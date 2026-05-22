<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with(['product.variants'])->get();
        $pricing = $this->buildPricingSummary($cartItems);

        return view('cart.index', array_merge(compact('cartItems'), $pricing));
    }

    /**
     * @return array{subtotal:float,tax_included_total:float,tax_added_total:float,shipping_fee:float,grand_total:float}
     */
    private function buildPricingSummary($cartItems): array
    {
        $subtotal = 0.0;
        $taxIncludedTotal = 0.0;
        $taxAddedTotal = 0.0;

        foreach ($cartItems as $item) {
            $breakdown = $item->product->priceBreakdownForSize($item->size, $item->quantity);

            // subtotal is sum of gross totals (product total price customers see)
            $subtotal += $breakdown['gross_total'];

            // accumulate tax amounts separately
            if ($breakdown['is_gst_inclusive']) {
                $taxIncludedTotal += $breakdown['tax_total'];
            } else {
                $taxAddedTotal += $breakdown['tax_total'];
            }
        }

        $shippingFee = 0.0;

        return [
            'subtotal' => round($subtotal, 2),
            'tax_included_total' => round($taxIncludedTotal, 2),
            'tax_added_total' => round($taxAddedTotal, 2),
            'shipping_fee' => round($shippingFee, 2),
            // grand total = subtotal (which already includes GST for each item) + shipping
            'grand_total' => round($subtotal + $shippingFee, 2),
        ];
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
