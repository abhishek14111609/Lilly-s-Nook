@extends('layouts.app')

@section('title', 'Your Shopping Cart - Lilly\'s Nook')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
            <div>
                <h1 class="display-5 fw-bold mb-1">Shopping Bag</h1>
                <p class="text-muted mb-0">You have {{ $cartItems->sum('quantity') }} items in your cart.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">Continue Shopping</a>
        </div>

        @if ($cartItems->isNotEmpty())
            <div class="row g-4">
                <!-- Cart Items Table -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 table-mobile-stack">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 border-0 py-3">Product</th>
                                        <th class="border-0 py-3">Price</th>
                                        <th class="border-0 py-3" style="width: 150px;">Quantity</th>
                                        <th class="border-0 py-3 text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        @php $itemPrice = $item->product->grossAmountForPrice($item->product->priceForSize($item->size)); @endphp
                                        <tr>
                                            <td class="ps-4" data-label="Product">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-3 border overflow-hidden bg-light"
                                                        style="width: 80px; height: 100px; flex-shrink: 0;">
                                                        @if ($item->product->image)
                                                            <img src="{{ asset('images/' . $item->product->image) }}"
                                                                class="w-100 h-100 object-fit-cover" alt="">
                                                        @elseif ($item->product->video)
                                                            <video src="{{ asset(ltrim($item->product->video, '/')) }}"
                                                                class="w-100 h-100 object-fit-cover" autoplay loop muted
                                                                playsinline></video>
                                                        @else
                                                            <img src="{{ asset('images/default-product.jpg') }}"
                                                                class="w-100 h-100 object-fit-cover" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="text-start">
                                                        <a href="{{ route('products.show', $item->product) }}"
                                                            class="fw-bold text-dark text-decoration-none mb-1 d-block">{{ $item->product->name }}</a>
                                                        <span
                                                            class="badge bg-light text-dark border rounded-pill fw-medium small">Size:
                                                            {{ $item->size }}</span>

                                                        <form method="post" action="{{ route('cart.destroy', $item) }}"
                                                            class="mt-2">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-link text-danger p-0 small text-decoration-none fw-bold">
                                                                <svg width="14" height="14" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                                    class="me-1">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                                Remove
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Price">
                                                <span class="text-dark fw-medium">₹{{ number_format($itemPrice, 2) }}</span>
                                            </td>
                                            <td data-label="Quantity">
                                                <form method="post" action="{{ route('cart.update', $item) }}"
                                                    class="d-flex gap-2 align-items-center">
                                                    @csrf @method('PATCH')
                                                    <input type="number" name="quantity" min="1" max="99"
                                                        value="{{ $item->quantity }}"
                                                        class="form-control form-control-sm rounded-pill text-center px-3"
                                                        style="width: 70px;" onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="text-end pe-4" data-label="Subtotal">
                                                <span
                                                    class="fw-bold text-primary fs-5">₹{{ number_format($itemPrice * $item->quantity, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                        <h3 class="h4 fw-bold mb-4">Order Summary</h3>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal (incl. GST)</span>
                            <span class="fw-bold">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        @php $taxAmount = round(($tax_included_total ?? 0) + ($tax_added_total ?? 0), 2); @endphp
                        @if ($taxAmount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tax (GST)</span>
                                <span class="fw-bold">₹{{ number_format($taxAmount, 2) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success fw-bold">FREE</span>
                        </div>

                        <hr class="mb-4">

                        <div class="d-flex justify-content-between mb-5">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-4 fw-bold text-primary">₹{{ number_format($grand_total, 2) }}</span>
                        </div>

                        <a href="{{ route('checkout.show') }}"
                            class="btn btn-dark btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm mb-3">
                            Proceed to Checkout
                        </a>

                        <div class="text-center">
                            <img src="{{ asset('images/secure-payment.png') }}" alt="Secure Payment" class="opacity-50"
                                style="height: 30px; filter: grayscale(1);">
                            <p class="text-muted text-xs mt-2 mb-0">Secure SSL Encrypted Checkout</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="py-5 text-center bg-light rounded-4 border border-dashed mt-4">
                <div class="py-5">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1"
                        class="mb-3">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <h3 class="fw-bold">Your bag is empty</h3>
                    <p class="text-muted mb-4">Items added to your bag will appear here.</p>
                    <a href="{{ route('shop.index') }}"
                        class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow">Explore Catalog</a>
                </div>
            </div>
        @endif
    </div>
@endsection
