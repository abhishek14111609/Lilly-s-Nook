@extends('layouts.app')

@section('title', 'Wishlist')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/cart-wishlist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    <section class="padding-large wishlist-page">
        <div class="container">
            <div class="account-page-header mb-4 mb-lg-5">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Saved picks</p>
                    <h1 class="h2 mb-2">My wishlist</h1>
                    <p class="text-muted mb-0">Keep favorites here and move them to cart when you are ready to buy.</p>
                </div>
                <div class="account-page-actions">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Browse products</a>
                    <a href="{{ route('cart.index') }}" class="btn btn-dark">Go to cart</a>
                </div>
            </div>

            <div class="account-panel wishlist-panel">
                @if ($wishlistItems->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlistItems as $item)
                                    <tr>
                                        <td>
                                            <div class="cart-item-media">
                                                @if (!empty($item->product->video))
                                                    <video autoplay muted loop playsinline preload="metadata"
                                                        poster="{{ asset('images/' . $item->product->image) }}"
                                                        style="width:64px; height:64px; object-fit:cover; border-radius:12px; flex-shrink:0;">
                                                        <source src="{{ asset($item->product->video) }}" type="video/mp4">
                                                    </video>
                                                @else
                                                    <img src="{{ asset('images/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}">
                                                @endif
                                                <div>
                                                    <a href="{{ route('products.show', $item->product) }}"
                                                        class="cart-item-title">{{ $item->product->name }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold">&#8377;{{ number_format($item->product->price, 2) }}</td>
                                        <td class="text-end">
                                            <div class="wishlist-actions">
                                                <form method="post"
                                                    action="{{ route('wishlist.cart.store', $item->product) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-dark" type="submit">Add to cart</button>
                                                </form>
                                                <form method="post" action="{{ route('wishlist.destroy', $item) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        type="submit">Remove</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="account-empty-state">
                        <p class="text-muted mb-3">Your wishlist is empty.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-dark">Browse products</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
