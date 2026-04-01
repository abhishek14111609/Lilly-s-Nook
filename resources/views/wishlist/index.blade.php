@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')
    <section class="site-banner jarallax min-height300 padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: top;">
        <div class="container"><h1 class="page-title">Wishlist</h1></div>
    </section>

    <section class="padding-large">
        <div class="container">
            <table class="table">
                <thead>
                    <tr><th>Product</th><th>Price</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($wishlistItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/'.$item->product->image) }}" alt="{{ $item->product->name }}" style="width:50px;height:50px;margin-right:10px;">
                                    <a href="{{ route('products.show', $item->product) }}">{{ $item->product->name }}</a>
                                </div>
                            </td>
                            <td>&#8377;{{ number_format($item->product->price, 2) }}</td>
                            <td class="d-flex" style="gap:10px;">
                                <form method="post" action="{{ route('wishlist.cart.store', $item->product) }}">@csrf<button class="btn btn-dark btn-sm" type="submit">Add to Cart</button></form>
                                <form method="post" action="{{ route('wishlist.destroy', $item) }}">@csrf @method('DELETE')<button class="btn btn-danger btn-sm" type="submit">Remove</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Your wishlist is empty. <a href="{{ route('shop.index') }}">Browse products</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
