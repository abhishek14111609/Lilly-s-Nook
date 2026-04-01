<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => (float) $item->product->price * $item->quantity);

        return view('checkout.show', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150'],
        ]);

        $user = $request->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                return redirect()->route('cart.index')->withErrors(['cart' => 'Not enough stock for ' . $cartItem->product->name]);
            }
        }

        $order = DB::transaction(function () use ($validated, $user, $cartItems): Order {
            $productIds = $cartItems->pluck('product_id')->unique()->values();
            $lockedProducts = Product::query()
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($cartItems as $cartItem) {
                $lockedProduct = $lockedProducts->get($cartItem->product_id);

                if (! $lockedProduct || $lockedProduct->stock < $cartItem->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => 'Not enough stock for ' . $cartItem->product->name,
                    ]);
                }
            }

            $total = $cartItems->sum(fn($item) => (float) $item->product->price * $item->quantity);

            $order = Order::query()->create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'zip' => $validated['zip'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'total' => $total,
                'payment_method' => 'cod',
                'status' => 'placed',
                'ordered_at' => now(),
            ]);

            foreach ($cartItems as $cartItem) {
                $lockedProduct = $lockedProducts->get($cartItem->product_id);

                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'size' => $cartItem->size,
                    'price' => $cartItem->product->price,
                ]);

                $updated = Product::query()
                    ->where('id', $lockedProduct->id)
                    ->where('stock', '>=', $cartItem->quantity)
                    ->decrement('stock', $cartItem->quantity);

                if ($updated === 0) {
                    throw ValidationException::withMessages([
                        'cart' => 'Not enough stock for ' . $cartItem->product->name,
                    ]);
                }
            }

            $user->cartItems()->delete();

            return $order;
        });

        return redirect()->route('orders.thankyou', $order)->with('status', 'Order placed successfully.');
    }
}
