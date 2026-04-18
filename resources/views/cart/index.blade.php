@extends('layouts.app')

@section('title', 'Cart')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/cart-wishlist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    <section id="cart" class="padding-large cart-page">
        <div class="container">
            <div class="account-page-header mb-4 mb-lg-5">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Shopping cart</p>
                    <h1 class="h2 mb-2">Review your items</h1>
                    <p class="text-muted mb-0">Update quantities and continue to secure checkout when ready.</p>
                </div>
                <div class="account-page-actions">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Continue shopping</a>
                    @if ($cartItems->isNotEmpty())
                        <a href="{{ route('checkout.show') }}" class="btn btn-dark">Proceed to checkout</a>
                    @endif
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="account-panel cart-panel">
                        @if ($cartItems->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="cart-item-media">
                                                        @if (!empty($item->product->video))
                                                            <video autoplay muted loop playsinline preload="metadata"
                                                                poster="{{ asset('images/' . $item->product->image) }}"
                                                                style="width:64px; height:64px; object-fit:cover; border-radius:12px; flex-shrink:0;">
                                                                <source src="{{ asset($item->product->video) }}"
                                                                    type="video/mp4">
                                                            </video>
                                                        @else
                                                            <img src="{{ asset('images/' . $item->product->image) }}"
                                                                alt="{{ $item->product->name }}">
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('products.show', $item->product) }}"
                                                                class="cart-item-title">{{ $item->product->name }}</a>
                                                            <div class="text-muted small">Size: {{ $item->size }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-semibold">
                                                    &#8377;{{ number_format($item->product->price, 2) }}
                                                </td>
                                                <td>
                                                    <form method="post" action="{{ route('cart.update', $item) }}"
                                                        class="cart-qty-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="number" name="quantity" min="1" max="99"
                                                            value="{{ $item->quantity }}"
                                                            class="form-control cart-qty-input">
                                                        <button class="btn btn-sm btn-outline-dark"
                                                            type="submit">Update</button>
                                                    </form>
                                                </td>
                                                <td class="fw-semibold">
                                                    &#8377;{{ number_format($item->product->price * $item->quantity, 2) }}
                                                </td>
                                                <td class="text-end">
                                                    <form method="post" action="{{ route('cart.destroy', $item) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            type="submit">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="account-empty-state">
                                <p class="text-muted mb-3">Your cart is empty.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-dark">Start shopping</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-totals cart-summary-card">
                        <h3 class="h5 mb-3">Order summary</h3>
                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <strong>&#8377;{{ number_format($subtotal, 2) }}</strong>
                        </div>
                        <div class="cart-summary-row">
                            <span>Shipping</span>
                            <strong>Calculated at checkout</strong>
                        </div>
                        <div class="cart-summary-row total">
                            <span>Total</span>
                            <strong>&#8377;{{ number_format($subtotal, 2) }}</strong>
                        </div>
                        @if ($cartItems->isNotEmpty())
                            <a href="{{ route('checkout.show') }}" class="btn btn-dark w-100 mt-3">Proceed to checkout</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
