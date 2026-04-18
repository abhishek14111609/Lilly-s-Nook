<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'quote' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        $hasPurchasedProduct = OrderItem::query()
            ->where('product_id', '=', $product->id)
            ->whereHas('order', fn($query) => $query->where('user_id', '=', $request->user()->id))
            ->exists();

        if (! $hasPurchasedProduct) {
            return back()->withErrors([
                'quote' => 'You can review this product only after purchasing it.',
            ])->withInput();
        }

        Review::query()->updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
            ],
            [
                'name' => $request->user()->name,
                'role' => 'Verified Buyer',
                'quote' => $validated['quote'],
                'rating' => $validated['rating'],
                'sort_order' => 0,
                'is_active' => true,
            ]
        );

        return redirect()
            ->route('products.show', $product)
            ->with('status', 'Your review has been published successfully.');
    }
}