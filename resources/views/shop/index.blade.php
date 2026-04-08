@extends('layouts.app')

@section('title', 'Shop')

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
                                <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>{{ $category->name }} (All)
                                </option>
                                @foreach ($category->children as $child)
                                    <option value="{{ $child->id }}" @selected($filters['category_id'] == $child->id)>&nbsp;&nbsp;-
                                        {{ $child->name }}</option>
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
                    <div class="product-item col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="image-holder"><img src="{{ asset('images/' . $product->image) }}"
                                alt="{{ $product->name }}" class="product-image" loading="lazy"></div>
                        <div class="cart-concern">
                            <div class="cart-button d-flex justify-content-between align-items-center"><a
                                    href="{{ route('products.show', $product) }}"
                                    class="btn-wrap cart-link d-flex align-items-center">View Product <i
                                        class="icon icon-arrow-io"></i></a></div>
                        </div>
                        <div class="product-detail">
                            <h3 class="product-title"><a
                                    href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h3>
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
