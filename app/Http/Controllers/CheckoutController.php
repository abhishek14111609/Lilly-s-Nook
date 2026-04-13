<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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

        $subtotal = $cartItems->sum(fn($item) => (float) $item->product->price * $item->quantity);
        $amount = (int) round($subtotal * 100);
        $currency = 'INR';
        $receipt = 'checkout_' . $user->id . '_' . Str::upper(Str::random(10));
        $razorpayKeyId = config('services.razorpay.key_id');
        $razorpayKeySecret = config('services.razorpay.key_secret');

        if (! $razorpayKeyId || ! $razorpayKeySecret) {
            throw ValidationException::withMessages([
                'payment' => 'Razorpay credentials are not configured.',
            ]);
        }

        $response = Http::withBasicAuth($razorpayKeyId, $razorpayKeySecret)
            ->acceptJson()
            ->asForm()
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => $amount,
                'currency' => $currency,
                'receipt' => $receipt,
                'payment_capture' => 1,
            ]);

        if (! $response->successful() || ! $response->json('id')) {
            throw ValidationException::withMessages([
                'payment' => 'Unable to start Razorpay checkout. Please try again.',
            ]);
        }

        $checkoutItems = $cartItems->map(fn($item) => [
            'product_id' => $item->product_id,
            'product_name' => $item->product->name,
            'quantity' => $item->quantity,
            'size' => $item->size,
            'price' => (float) $item->product->price,
        ])->values()->all();

        session()->put('checkout.razorpay', [
            'user_id' => $user->id,
            'billing' => $validated,
            'items' => $checkoutItems,
            'subtotal' => $subtotal,
            'amount' => $amount,
            'currency' => $currency,
            'receipt' => $receipt,
            'razorpay_order_id' => $response->json('id'),
        ]);

        return view('checkout.payment', [
            'billing' => $validated,
            'items' => $checkoutItems,
            'subtotal' => $subtotal,
            'amount' => $amount,
            'currency' => $currency,
            'razorpayKeyId' => $razorpayKeyId,
            'razorpayOrderId' => $response->json('id'),
            'razorpayMerchantName' => config('app.name', 'Lilly\'s Nook'),
        ]);
    }

    public function verifyRazorpay(Request $request)
    {
        $validated = $request->validate([
            'razorpay_payment_id' => ['required', 'string', 'max:100'],
            'razorpay_order_id' => ['required', 'string', 'max:100'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        $checkout = session('checkout.razorpay');

        if (! is_array($checkout) || ($checkout['user_id'] ?? null) !== $request->user()->id) {
            return redirect()->route('checkout.show')->withErrors([
                'payment' => 'Your payment session expired. Please start checkout again.',
            ]);
        }

        if (($checkout['razorpay_order_id'] ?? null) !== $validated['razorpay_order_id']) {
            return redirect()->route('checkout.show')->withErrors([
                'payment' => 'The payment reference does not match your checkout session.',
            ]);
        }

        $expectedSignature = hash_hmac(
            'sha256',
            $validated['razorpay_order_id'] . '|' . $validated['razorpay_payment_id'],
            (string) config('services.razorpay.key_secret')
        );

        if (! hash_equals($expectedSignature, $validated['razorpay_signature'])) {
            return redirect()->route('checkout.show')->withErrors([
                'payment' => 'Payment verification failed. Please try again.',
            ]);
        }

        $order = DB::transaction(function () use ($checkout, $validated, $request): Order {
            $items = collect($checkout['items'] ?? []);
            $productIds = $items->pluck('product_id')->unique()->values();

            $lockedProducts = Product::query()
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($items as $item) {
                $product = $lockedProducts->get($item['product_id']);

                if (! $product || $product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'cart' => 'Not enough stock for ' . $item['product_name'],
                    ]);
                }
            }

            $billing = $checkout['billing'];
            $subtotal = (float) ($checkout['subtotal'] ?? 0);

            $order = Order::query()->create([
                'user_id' => $request->user()->id,
                'first_name' => $billing['first_name'],
                'last_name' => $billing['last_name'],
                'address' => $billing['address'],
                'city' => $billing['city'],
                'zip' => $billing['zip'],
                'phone' => $billing['phone'],
                'email' => $billing['email'],
                'total' => $subtotal,
                'payment_method' => 'razorpay',
                'payment_status' => 'paid',
                'razorpay_order_id' => $validated['razorpay_order_id'],
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_signature' => $validated['razorpay_signature'],
                'paid_at' => now(),
                'status' => 'placed',
                'ordered_at' => now(),
            ]);

            foreach ($items as $item) {
                $product = $lockedProducts->get($item['product_id']);

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'price' => $item['price'],
                ]);

                Product::query()
                    ->where('id', $product->id)
                    ->where('stock', '>=', $item['quantity'])
                    ->decrement('stock', $item['quantity']);
            }

            $order->update([
                'invoice_number' => $this->generateInvoiceNumber($order),
            ]);

            $request->user()->cartItems()->whereIn('product_id', $productIds)->delete();

            return $order;
        });

        session()->forget('checkout.razorpay');

        return redirect()
            ->route('orders.thankyou', $order)
            ->with('status', 'Payment received successfully. Your invoice is ready.');
    }

    protected function generateInvoiceNumber(Order $order): string
    {
        return 'INV-' . now()->format('Ymd') . '-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    }
}
