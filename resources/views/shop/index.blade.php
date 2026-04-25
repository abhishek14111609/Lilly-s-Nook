@extends('layouts.app')

@section('title', 'Shop - Lilly\'s Nook')

@section('content')
    <!-- Hero Header -->
    <section class="py-5 bg-light mb-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shop</li>
                        </ol>
                    </nav>
                    <h1 class="display-4 fw-bold mb-3">Shop the Collection</h1>
                    <p class="lead text-muted mb-0">Browse our thoughtfully curated selection of outfits designed for everyday magic.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Sidebar Filters (Desktop) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="card border border-light-subtle shadow-sm p-4 rounded-4 sticky-top" style="top: 100px;">
                    <form action="{{ route('shop.index') }}" method="get">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small letter-spacing-1 mb-3">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 pe-0">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </span>
                                <input type="text" name="s" class="form-control border-start-0 ps-2" placeholder="Find a product..." value="{{ $filters['search'] }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small letter-spacing-1 mb-3">Categories</label>
                            <select name="category_id" class="form-select mb-2">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>{{ $category->name }}</option>
                                    @foreach ($category->children as $child)
                                        <option value="{{ $child->id }}" @selected($filters['category_id'] == $child->id)>&nbsp;&nbsp;— {{ $child->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small letter-spacing-1 mb-3">Price Range</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="" id="priceAll" @checked(!$filters['priceRange'])>
                                    <label class="form-check-label" for="priceAll">All Prices</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="lt100" id="price1" @checked($filters['priceRange'] === 'lt100')>
                                    <label class="form-check-label" for="price1">Under ₹100</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="100-200" id="price2" @checked($filters['priceRange'] === '100-200')>
                                    <label class="form-check-label" for="price2">₹100 - ₹200</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="200-400" id="price3" @checked($filters['priceRange'] === '200-400')>
                                    <label class="form-check-label" for="price3">₹200 - ₹400</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill">Apply Filters</button>
                            <a href="{{ route('shop.index') }}" class="btn btn-light rounded-pill border">Clear All</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Mobile Filter Trigger & Sort -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small fw-medium">Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results</span>
                    </div>
                    
                    <div class="d-flex gap-3 align-items-center">
                        <button class="btn btn-outline-dark d-lg-none rounded-pill px-4 shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                            Filters
                        </button>
                        
                        <form action="{{ route('shop.index') }}" method="get" class="d-flex align-items-center gap-2">
                            @if($filters['search']) <input type="hidden" name="s" value="{{ $filters['search'] }}"> @endif
                            @if($filters['category_id']) <input type="hidden" name="category_id" value="{{ $filters['category_id'] }}"> @endif
                            @if($filters['priceRange']) <input type="hidden" name="price" value="{{ $filters['priceRange'] }}"> @endif
                            
                            <label class="d-none d-sm-block small fw-bold text-muted text-uppercase">Sort:</label>
                            <select name="sort" class="form-select form-select-sm border-0 bg-light rounded-pill px-3" onchange="this.form.submit()">
                                <option value="newest" @selected($filters['sort'] === 'newest')>Newest</option>
                                <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Price: Low to High</option>
                                <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Price: High to Low</option>
                                <option value="name_asc" @selected($filters['sort'] === 'name_asc')>Name: A-Z</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="row g-4 mb-5">
                    @forelse ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card h-100 group border-0 bg-transparent">
                                <div class="position-relative overflow-hidden rounded-4 mb-3 border shadow-sm" style="aspect-ratio: 3/4;">
                                    <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}" class="card-img-top h-100 object-fit-cover transition-all group-hover-scale" alt="{{ $product->name }}">
                                    
                                    <div class="position-absolute top-0 end-0 p-3">
                                        @auth
                                            <form method="post" action="{{ route('products.wishlist.store', $product) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-white rounded-circle p-2 shadow-sm border" title="Add to wishlist">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-white rounded-circle p-2 shadow-sm border">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                                            </a>
                                        @endauth
                                    </div>
                                    
                                    <div class="position-absolute bottom-0 start-0 w-100 p-3 translate-x-0 translate-y-100 group-hover-translate-y-0 transition-all">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-white w-100 rounded-pill shadow-sm py-2 fw-bold border">View Details</a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <h5 class="card-title text-dark fw-bold mb-1 h6">
                                        <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none transition-all hover-primary">{{ $product->name }}</a>
                                    </h5>
                                    @if($product->category)
                                        <p class="text-muted small mb-2">{{ $product->category->name }}</p>
                                    @endif
                                    <p class="card-text text-primary fw-bold fs-5">&#8377;{{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <div class="py-5">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1" class="mb-3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                <h3 class="fw-bold">No products found</h3>
                                <p class="text-muted">We couldn't find any products matching your current filters.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-5 mt-3">Reset All Filters</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center border-top pt-4">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Filters Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">Filter Catalog</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('shop.index') }}" method="get">
                <!-- Search -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-uppercase small letter-spacing-1">Search</label>
                    <input type="text" name="s" class="form-control rounded-4" placeholder="Search keywords..." value="{{ $filters['search'] }}">
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-uppercase small letter-spacing-1">Category</label>
                    <select name="category_id" class="form-select rounded-4">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>{{ $category->name }}</option>
                            @foreach ($category->children as $child)
                                <option value="{{ $child->id }}" @selected($filters['category_id'] == $child->id)>&nbsp;&nbsp;— {{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-uppercase small letter-spacing-1">Price Range</label>
                    <div class="row g-2">
                        <div class="col-12">
                            <input class="btn-check" type="radio" name="price" value="" id="mPriceAll" @checked(!$filters['priceRange'])>
                            <label class="btn btn-outline-light text-dark border w-100 rounded-pill" for="mPriceAll">All Prices</label>
                        </div>
                        <div class="col-12">
                            <input class="btn-check" type="radio" name="price" value="lt100" id="mPrice1" @checked($filters['priceRange'] === 'lt100')>
                            <label class="btn btn-outline-light text-dark border w-100 rounded-pill" for="mPrice1">Under ₹100</label>
                        </div>
                        <!-- Add other price options if needed... -->
                    </div>
                </div>

                <div class="d-grid gap-2 mt-auto">
                    <button type="submit" class="btn btn-dark rounded-pill py-3">View Results</button>
                    <a href="{{ route('shop.index') }}" class="btn btn-link text-muted">Clear Filters</a>
                </div>
            </form>
        </div>
    </div>
@endsection
