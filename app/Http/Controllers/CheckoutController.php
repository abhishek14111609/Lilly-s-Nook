<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with(['product.variants'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $pricing = $this->buildPricingSummary($cartItems);
        $addresses = $request->user()->addresses()->orderByDesc('is_default')->get();

        return view('checkout.show', array_merge(compact('cartItems', 'addresses'), $pricing));
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
        $cartItems = $user->cartItems()->with(['product.variants'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->sizeStockFor($cartItem->size)) {
                return redirect()->route('cart.index')->withErrors(['cart' => 'Not enough stock for ' . $cartItem->product->name]);
            }
        }

        $pricing = $this->buildPricingSummary($cartItems);
        $subtotal = $pricing['subtotal'];
        $taxIncludedTotal = $pricing['tax_included_total'];
        $taxAddedTotal = $pricing['tax_added_total'];
        $shippingFee = $pricing['shipping_fee'];
        $grandTotal = $pricing['grand_total'];

        $amount = (int) round($grandTotal * 100);
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

        $checkoutItems = $cartItems->map(function ($item) {
            $breakdown = $item->product->priceBreakdownForSize($item->size, $item->quantity);

            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'size' => $item->size,
                'price' => $breakdown['net_unit_price'],
                'net_price' => $breakdown['net_unit_price'],
                'tax_amount' => $breakdown['tax_unit_price'],
                'gross_price' => $breakdown['gross_unit_price'],
                'line_net_total' => $breakdown['net_total'],
                'line_tax_total' => $breakdown['tax_total'],
                'line_gross_total' => $breakdown['gross_total'],
                'is_gst_inclusive' => $breakdown['is_gst_inclusive'],
                'gst_rate' => $breakdown['gst_rate'],
            ];
        })->values()->all();

        session()->put('checkout.razorpay', [
            'user_id' => $user->id,
            'billing' => $validated,
            'address_id' => $request->input('address_id'),
            'items' => $checkoutItems,
            'subtotal' => $subtotal,
            'tax_included_total' => $taxIncludedTotal,
            'tax_added_total' => $taxAddedTotal,
            'shipping_fee' => $shippingFee,
            'tax_amount' => $taxIncludedTotal + $taxAddedTotal,
            'total' => $grandTotal,
            'amount' => $amount,
            'currency' => $currency,
            'receipt' => $receipt,
            'razorpay_order_id' => $response->json('id'),
        ]);

        return view('checkout.payment', [
            'billing' => $validated,
            'items' => $checkoutItems,
            'subtotal' => $subtotal,
            'tax_included_total' => $taxIncludedTotal,
            'tax_added_total' => $taxAddedTotal,
            'shipping_fee' => $shippingFee,
            'tax_amount' => $taxIncludedTotal + $taxAddedTotal,
            'total' => $grandTotal,
            'grand_total' => $grandTotal,
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
                ->with('variants')
                ->whereIn('id', $productIds->all())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($items as $item) {
                $product = $lockedProducts->get($item['product_id']);
                if (! $product || $product->sizeStockFor($item['size']) < $item['quantity']) {
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
                'total' => $checkout['total'] ?? $subtotal,
                'shipping_fee' => $checkout['shipping_fee'] ?? 0,
                'tax_amount' => $checkout['tax_amount'] ?? 0,
                'shipping_address_id' => $checkout['address_id'] ?? null,
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

                $product->reduceStockForSize($item['size'], (int) $item['quantity']);
            }

            $order->update([
                'invoice_number' => $this->generateInvoiceNumber($order),
            ]);

            $request->user()->cartItems()->whereIn('product_id', $productIds->all())->delete();

            return $order;
        });

        session()->forget('checkout.razorpay');

        return redirect()
            ->route('orders.thankyou', $order)
            ->with('status', 'Payment received successfully. Your invoice is ready.');
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

            $subtotal += $breakdown['gross_total'];

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
            'grand_total' => round($subtotal + $shippingFee, 2),
        ];
    }

    protected function generateInvoiceNumber(Order $order): string
    {
        return 'INV-' . now()->format('Ymd') . '-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    }
}
