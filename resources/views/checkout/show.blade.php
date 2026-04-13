@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <section id="checkout" class="padding-large bg-light-grey">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-lg-5">
                            <p class="text-uppercase text-muted small mb-1">Billing details</p>
                            <h2 class="mb-4">Complete your order</h2>
                            <form method="post" action="{{ route('checkout.store') }}">
                                @csrf
                                <div class="form-group mb-3"><label>First Name *</label><input type="text"
                                        name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                </div>
                                <div class="form-group mb-3"><label>Last Name *</label><input type="text"
                                        name="last_name" class="form-control" value="{{ old('last_name') }}" required></div>
                                <div class="form-group mb-3"><label>Address *</label><input type="text" name="address"
                                        class="form-control" value="{{ old('address') }}" required></div>
                                <div class="form-group mb-3"><label>City *</label><input type="text" name="city"
                                        class="form-control" value="{{ old('city') }}" required></div>
                                <div class="form-group mb-3"><label>ZIP *</label><input type="text" name="zip"
                                        class="form-control" value="{{ old('zip') }}" required></div>
                                <div class="form-group mb-3"><label>Phone *</label><input type="text" name="phone"
                                        class="form-control" value="{{ old('phone') }}" required></div>
                                <div class="form-group mb-4"><label>Email *</label><input type="email" name="email"
                                        class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                                </div>
                                <div class="alert alert-info">
                                    Cash on delivery is not available. You will complete this order securely through
                                    Razorpay.
                                </div>
                                <button class="btn btn-dark" type="submit">Continue to payment</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-lg-5">
                            <p class="text-uppercase text-muted small mb-1">Order summary</p>
                            <h2 class="mb-4">Your cart</h2>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name }} x {{ $item->quantity }}
                                                    ({{ $item->size }})</td>
                                                <td class="text-end">
                                                    &#8377;{{ number_format($item->product->price * $item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th class="text-end">&#8377;{{ number_format($subtotal, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-4 p-3 bg-white border rounded-3">
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
