@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <!-- <section class="site-banner jarallax min-height300 padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: top;">
        <div class="container"><h1 class="page-title">Checkout</h1></div>
    </section> -->

    <section id="checkout" class="padding-large">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3>Billing Details</h3>
                    <form method="post" action="{{ route('checkout.store') }}">
                        @csrf
                        <div class="form-group"><label>First Name *</label><input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required></div>
                        <div class="form-group"><label>Last Name *</label><input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required></div>
                        <div class="form-group"><label>Address *</label><input type="text" name="address" class="form-control" value="{{ old('address') }}" required></div>
                        <div class="form-group"><label>City *</label><input type="text" name="city" class="form-control" value="{{ old('city') }}" required></div>
                        <div class="form-group"><label>ZIP *</label><input type="text" name="zip" class="form-control" value="{{ old('zip') }}" required></div>
                        <div class="form-group"><label>Phone *</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required></div>
                        <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required></div>
                        <button class="btn btn-dark" type="submit">Place Order</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3>Your Order</h3>
                    <table class="table">
                        <thead><tr><th>Product</th><th>Total</th></tr></thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr><td>{{ $item->product->name }} x {{ $item->quantity }} ({{ $item->size }})</td><td>&#8377;{{ number_format($item->product->price * $item->quantity, 2) }}</td></tr>
                            @endforeach
                            <tr><td><strong>Total</strong></td><td><strong>&#8377;{{ number_format($subtotal, 2) }}</strong></td></tr>
                        </tbody>
                    </table>
                    <div class="payment-method"><h3>Payment Method</h3><p>Cash on delivery</p></div>
                </div>
            </div>
        </div>
    </section>
@endsection
