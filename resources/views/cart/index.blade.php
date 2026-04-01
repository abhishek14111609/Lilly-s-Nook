@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <!-- <section class="site-banner jarallax min-height300 padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: top;">
        <div class="container"><h1 class="page-title">Cart</h1></div>
    </section> -->

    <section id="cart" class="padding-large">
        <div class="container">
            <table class="table">
                <thead>
                    <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/'.$item->product->image) }}" alt="{{ $item->product->name }}" style="width:50px;height:50px;margin-right:10px;">
                                    <div><a href="{{ route('products.show', $item->product) }}">{{ $item->product->name }}</a><br><small>Size: {{ $item->size }}</small></div>
                                </div>
                            </td>
                            <td>&#8377;{{ number_format($item->product->price, 2) }}</td>
                            <td>
                                <form method="post" action="{{ route('cart.update', $item) }}" class="d-flex align-items-center" style="gap:8px;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" min="1" max="99" value="{{ $item->quantity }}" class="form-control" style="width:90px;">
                                    <button class="btn btn-secondary btn-sm" type="submit">Update</button>
                                </form>
                            </td>
                            <td>&#8377;{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <form method="post" action="{{ route('cart.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Your cart is empty. <a href="{{ route('shop.index') }}">Start shopping</a></td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="cart-totals">
                <h3>Cart totals</h3>
                <table class="table">
                    <tbody>
                        <tr><td>Subtotal</td><td>&#8377;{{ number_format($subtotal, 2) }}</td></tr>
                        <tr><td>Total</td><td>&#8377;{{ number_format($subtotal, 2) }}</td></tr>
                    </tbody>
                </table>
                @if ($cartItems->isNotEmpty())
                    <a href="{{ route('checkout.show') }}" class="btn btn-dark">Proceed to checkout</a>
                @endif
            </div>
        </div>
    </section>
@endsection
