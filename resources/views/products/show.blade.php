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
                                        <button type="submit" class="btn btn-dark">Add to Cart</button>
                                        <button type="submit" name="buy_now" value="1" class="btn btn-primary">Buy
                                            Now</button>
                                    </div>
                                </form>
                                <form method="post" action="{{ route('products.wishlist.store', $product) }}"
                                    class="wishlist-form-row">
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
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .product-page-section .product-page-grid {
            row-gap: 1.25rem;
            align-items: stretch;
        }

        .product-media-card,
        .product-detail-card {
            background: #fff;
            border: 1px solid #eceff2;
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(23, 31, 56, 0.06);
            height: 100%;
        }

        .product-media-card {
            padding: 1rem;
        }

        .product-media-card .image-holder {
            border-radius: 14px;
            overflow: hidden;
        }

        .product-media-card .product-image {
            width: 100%;
            height: clamp(320px, 58vw, 560px);
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .product-detail-card {
            padding: clamp(1rem, 2.3vw, 2rem);
        }

        .product-detail-card .product-title {
            margin-bottom: 0.4rem;
            font-size: clamp(1.65rem, 3.2vw, 3rem);
            line-height: 1.15;
        }

        .product-detail-card .product-price {
            font-size: clamp(1.2rem, 2.2vw, 1.65rem);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .size-selector-wrap {
            margin-top: 1rem;
        }

        .size-selector-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
            margin-bottom: 0.75rem;
        }

        .size-label {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #232733;
        }

        .size-chart-link {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2f5be8;
            text-decoration: none;
        }

        .size-pill-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
        }

        .size-pill-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .size-pill {
            min-width: 64px;
            height: 56px;
            padding: 0 1rem;
            border: 1px solid #cfd4dc;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            font-weight: 600;
            color: #3a3f4a;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .size-pill:hover {
            border-color: #9098a5;
            transform: translateY(-1px);
        }

        .size-pill-input:checked+.size-pill {
            border-color: #2f5be8;
            color: #2f5be8;
            background: #f3f7ff;
            box-shadow: inset 0 0 0 1px #2f5be8;
        }

        .product-actions-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin-top: 1rem;
        }

        .wishlist-form-row {
            margin-top: 0.7rem;
        }

        @media (max-width: 767.98px) {
            .product-detail-card .product-title {
                font-size: 2rem;
            }

            .size-pill {
                min-width: 58px;
                height: 52px;
                border-radius: 14px;
                font-size: 0.95rem;
            }

            .product-actions-row .btn,
            .wishlist-form-row .btn {
                width: 100%;
            }
        }
    </style>
@endpush
