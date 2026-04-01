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

    <section id="single-product" class="padding-large">
        <div class="container">
            <div class="row">
                <div class="col-md-6"><div class="image-holder"><img src="{{ asset('images/'.$product->image) }}" alt="{{ $product->name }}" class="product-image" loading="lazy"></div></div>
                <div class="col-md-6">
                    <div class="product-detail">
                        <h2 class="product-title">{{ $product->name }}</h2>
                        <p class="product-price">&#8377;{{ number_format($product->price, 2) }}</p>
                        <p>{{ $product->description ?: 'No description available.' }}</p>
                        <p><strong>Category:</strong> {{ optional($product->category)->name ?? 'General' }}</p>
                        <p class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                            <strong>Availability:</strong> {{ $product->stock > 0 ? $product->stock . ' In Stock' : 'Out of Stock' }}
                        </p>

                        @auth
                            <form method="post" action="{{ route('products.cart.store', $product) }}">
                                @csrf
                                <div class="form-group">
                                    <label for="size">Size *</label>
                                    <select class="form-control" name="size" id="size" required>
                                        <option value="">Select Size</option>
                                        @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                            <option value="{{ $size }}">{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <button type="submit" class="btn btn-dark">Add to Cart</button>
                                    <button type="submit" name="buy_now" value="1" class="btn btn-primary">Buy Now</button>
                                </div>
                            </form>
                            <form method="post" action="{{ route('products.wishlist.store', $product) }}" style="margin-top: 1rem;">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Add to Wishlist</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-dark">Login to purchase</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
