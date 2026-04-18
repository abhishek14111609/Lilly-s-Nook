@extends('layouts.app')

@section('title', 'Shop')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/shop.css') }}">
@endpush

@section('content')
    <!-- <section class="site-banner jarallax min-height300 mb-4" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat center center; background-size: cover;">
                                    <div class="container h-100 d-flex align-items-center">
                                        <div class="row w-100">
                                            <div class="col-md-4">
                                                <h1 class="page-title">Shop</h1>
                                                <div class="breadcrumbs"><span class="item"><a href="{{ route('home') }}">Home /</a></span><span class="item">Shop</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </section> -->

    <div class="shop-container padding-large">
        <div class="container">
            <div class="filter-section">
                <form action="{{ route('shop.index') }}" method="get" class="row g-3">
                    <div class="col-md-4"><input type="text" name="s" class="form-control"
                            placeholder="Search products..." value="{{ $filters['search'] }}"></div>
                    <div class="col-md-3">
                        <select name="category_id" class="form-control">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>
                                    {{ $category->name }} (All)
                                </option>
                                @foreach ($category->children as $child)
                                    <option value="{{ $child->id }}" @selected($filters['category_id'] == $child->id)>&nbsp;&nbsp;-
                                        {{ $child->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="price" class="form-control">
                            <option value="">Price Range</option>
                            <option value="lt100" @selected($filters['priceRange'] === 'lt100')>Under 100</option>
                            <option value="100-200" @selected($filters['priceRange'] === '100-200')>100 - 200</option>
                            <option value="200-400" @selected($filters['priceRange'] === '200-400')>200 - 400</option>
                            <option value="400-800" @selected($filters['priceRange'] === '400-800')>400 - 800</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="sort" class="form-control">
                            <option value="newest" @selected($filters['sort'] === 'newest')>Newest</option>
                            <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Price low-high</option>
                            <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Price high-low</option>
                            <option value="name_asc" @selected($filters['sort'] === 'name_asc')>Name A-Z</option>
                            <option value="name_desc" @selected($filters['sort'] === 'name_desc')>Name Z-A</option>
                        </select>
                    </div>
                    <div class="col-12"><button type="submit" class="btn btn-dark">Apply Filters</button> <a
                            href="{{ route('shop.index') }}" class="btn btn-secondary">Clear</a></div>
                </form>
            </div>

            <div class="row d-flex flex-wrap">
                @forelse ($products as $product)
                    <div class="product-item col-lg-3 col-md-6 col-sm-6 col-12 shop-product-col">
                        <div class="shop-product-card">
                            <div class="image-holder">
                                @if (!empty($product->video))
                                    <video class="product-image" autoplay muted loop playsinline preload="metadata"
                                        poster="{{ asset('images/' . $product->image) }}">
                                        <source src="{{ asset($product->video) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="product-image" loading="lazy">
                                @endif

                                <div class="shop-product-corner-action">
                                    @auth
                                        <form method="post" action="{{ route('products.wishlist.store', $product) }}">
                                            @csrf
                                            {{-- <button type="submit" class="wishlist-corner-btn"
                                                aria-label="Add {{ $product->name }} to wishlist" title="Add to wishlist">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                                                    </path>
                                                </svg>
                                            </button> --}}
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="wishlist-corner-btn"
                                            aria-label="Login to add {{ $product->name }} to wishlist"
                                            title="Login to add to wishlist">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                                                </path>
                                            </svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>

                            <div class="shop-card-action">
                                <div class="shop-card-action-inner">
                                    <a href="{{ route('products.show', $product) }}" class="shop-card-link">
                                        View product
                                        <i class="icon icon-arrow-io"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="product-detail">
                            <h3 class="product-title"><a
                                    href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="item-price text-primary">&#8377;{{ number_format($product->price, 2) }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state text-center padding-large">
                            <h3>No products found</h3>
                            <p>Try adjusting your search or filters.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="shop-pagination mt-4">{{ $products->onEachSide(1)->links('vendor.pagination.shop') }}</div>
        </div>
    </div>
@endsection
