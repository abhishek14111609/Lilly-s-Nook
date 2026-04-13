@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <!-- <section class="site-banner jarallax min-height300 padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: top;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="page-title">{{ $product->name }}</h1>
                                <div class="breadcrumbs">
                                    <span class="item"><a href="{{ route('home') }}">Home /</a></span>
                                    <span class="item"><a href="{{ route('shop.index') }}">Shop /</a></span>
                                    <span class="item">{{ $product->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->

    <section id="single-product" class="padding-large product-page-section">
        <div class="container">
            <div class="row product-page-grid">
                <div class="col-lg-6 col-md-12">
                    <div class="product-media-card">
                        <div class="image-holder"><img src="{{ asset('images/' . $product->image) }}"
                                alt="{{ $product->name }}" class="product-image" loading="lazy"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-detail-card">
                        <div class="product-detail">
                            <h2 class="product-title">{{ $product->name }}</h2>
                            <p class="product-price">&#8377;{{ number_format($product->price, 2) }}</p>
                            <p>{{ $product->description ?: 'No description available.' }}</p>
                            <p><strong>Category:</strong> {{ optional($product->category)->name ?? 'General' }}</p>
                            <p class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                                <strong>Availability:</strong>
                                {{ $product->stock > 0 ? $product->stock . ' In Stock' : 'Out of Stock' }}
                            </p>

                            @auth
                                <form method="post" action="{{ route('products.cart.store', $product) }}">
                                    @csrf

                                    <div class="size-selector-wrap">
                                        <div class="size-selector-head">
                                            <label class="size-label">Select Size</label>
                                            <a href="#" class="size-chart-link" onclick="return false;">Size Chart</a>
                                        </div>
                                        <div class="size-pill-grid" role="radiogroup" aria-label="Select size">
                                            @foreach ($sizeOptions as $size)
                                                <input type="radio" class="size-pill-input" name="size"
                                                    id="size-{{ strtolower($size) }}" value="{{ $size }}"
                                                    {{ old('size') === $size ? 'checked' : '' }} required>
                                                <label class="size-pill"
                                                    for="size-{{ strtolower($size) }}">{{ $size }}</label>
                                            @endforeach
                                        </div>
                                        @error('size')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="product-actions-row">
                                        <button type="submit" class="btn btn-dark product-action-btn">Add to cart</button>
                                        <button type="submit" name="buy_now" value="1"
                                            class="btn btn-primary product-action-btn">Buy
                                            Now</button>
                                    </div>
                                </form>
                                <form method="post" action="{{ route('products.wishlist.store', $product) }}"
                                    class="wishlist-form-row">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-outline-dark product-action-btn product-action-btn-wish">Add to
                                        wishlist</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-dark">Login to purchase</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/product-show.css') }}">
@endpush
