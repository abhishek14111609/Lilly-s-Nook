@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    <section id="checkout" class="padding-large account-page checkout-page">
        <div class="container">
            <div class="account-page-header mb-4 mb-lg-5">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Checkout</p>
                    <h1 class="h2 mb-2">Complete your order</h1>
                    <p class="text-muted mb-0">Review your billing details and confirm everything before secure payment.</p>
                </div>
                <div class="account-page-actions">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-dark">Back to cart</a>
                    <a href="{{ route('shop.index') }}" class="btn btn-dark">Continue shopping</a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="account-form-card h-100">
                        <div class="account-form-header">
                            <p class="text-uppercase text-muted small mb-1">Billing details</p>
                            <h2 class="h4 mb-0">Delivery information</h2>
                        </div>
                        <div class="account-form-body">
                            <form method="post" action="{{ route('checkout.store') }}" class="checkout-form-grid">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="checkout-first-name">First Name *</label>
                                        <input id="checkout-first-name" type="text" name="first_name"
                                            class="form-control" value="{{ old('first_name') }}" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="checkout-last-name">Last Name *</label>
                                        <input id="checkout-last-name" type="text" name="last_name" class="form-control"
                                            value="{{ old('last_name') }}" required>
                                    </div>
                                    <div class="col-12 form-group mb-0">
                                        <label for="checkout-address">Address *</label>
                                        <input id="checkout-address" type="text" name="address" class="form-control"
                                            value="{{ old('address') }}" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="checkout-city">City *</label>
                                        <input id="checkout-city" type="text" name="city" class="form-control"
                                            value="{{ old('city') }}" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="checkout-zip">ZIP *</label>
                                        <input id="checkout-zip" type="text" name="zip" class="form-control"
                                            value="{{ old('zip') }}" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="checkout-phone">Phone *</label>
                                        <input id="checkout-phone" type="text" name="phone" class="form-control"
                                            value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="checkout-email">Email *</label>
                                        <input id="checkout-email" type="email" name="email" class="form-control"
                                            value="{{ old('email', auth()->user()->email) }}" required>
                                    </div>
                                </div>
                                <div class="alert alert-info mt-4 mb-0">
                                    Cash on delivery is not available. You will complete this order securely through
                                    Razorpay.
                                </div>
                                <div class="account-form-footer px-0 pb-0">
                                    <div class="text-muted small">Your billing details will be used for the invoice.</div>
                                    <button class="btn btn-dark" type="submit">Continue to payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="account-panel checkout-summary h-100">
                        <div class="account-panel-header">
                            <p class="text-uppercase text-muted small mb-1">Order summary</p>
                            <h2 class="h4 mb-0">Your cart</h2>
                        </div>
                        <div class="account-form-body">
                            <div class="table-responsive checkout-summary-table">
                                <table class="table table-mobile-stack align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            @php
                                                $itemPrice = $item->product->priceForSize($item->size);
                                            @endphp
                                            <tr>
                                                <td>{{ $item->product->name }} x {{ $item->quantity }}
                                                    ({{ $item->size }})
                                                </td>
                                                <td class="text-end">
                                                    &#8377;{{ number_format($itemPrice * $item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th data-label="Summary">Total</th>
                                            <th class="text-end" data-label="Amount">
                                                &#8377;{{ number_format($subtotal, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="checkout-payment-note mt-4">
                                <h5 class="mb-2">Payment method</h5>
                                <p class="mb-0 text-muted">Razorpay secure checkout</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
