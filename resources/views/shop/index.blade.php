@extends('layouts.app')

@section('title', 'Shop - Lilly\'s Nook')

@push('styles')
    <style>
        .category-filter-dropdown .category-filter-button {
            min-height: 56px;
            padding-inline: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            border-color: rgba(15, 23, 42, 0.14);
            background: #fff;
            box-shadow: 0 0.5rem 1.25rem rgba(15, 23, 42, 0.04);
        }

        .category-filter-dropdown .category-filter-button::after {
            margin-left: auto;
        }

        .category-filter-dropdown .category-filter-label {
            max-width: calc(100% - 1.25rem);
        }

        .category-filter-dropdown .category-filter-menu {
            max-height: 280px;
            overflow-y: auto;
            border-color: rgba(15, 23, 42, 0.08);
        }

        .category-filter-dropdown .category-filter-item {
            font-weight: 500;
            padding-top: 0.7rem;
            padding-bottom: 0.7rem;
        }

        .category-filter-dropdown .category-filter-item.active {
            background: rgba(244, 143, 177, 0.12);
            color: #111827;
        }

        .category-filter-dropdown .category-filter-item:hover {
            background: rgba(244, 143, 177, 0.08);
        }
    </style>
@endpush

@section('content')
    @php
        $selectedCategory =
            collect($categories ?? [])
                ->flatMap(function ($category) {
                    return collect([$category])->merge($category->children ?? []);
                })
                ->firstWhere('id', $filters['category_id']) ?? null;
        $selectedCategoryLabel = $selectedCategory?->name ?: 'All Categories';
    @endphp

    <!-- Hero Header -->
    <section class="py-5 bg-light mb-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Shop</li>
                        </ol>
                    </nav>
                    <h1 class="display-4 fw-bold mb-3">Shop the Collection</h1>
                    <p class="lead text-muted mb-0">Browse our thoughtfully curated selection of outfits designed for
                        everyday magic.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Sidebar Filters (Desktop) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="card border border-light-subtle shadow-sm p-4 rounded-4"
                    style="position: sticky; top: calc(var(--site-header-height, 112px) + 1rem); z-index: 1;">
                    <form action="{{ route('shop.index') }}" method="get">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small letter-spacing-1 mb-3">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 pe-0">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </span>
                                <input type="text" name="s" class="form-control border-start-0 ps-2"
                                    placeholder="Find a product..." value="{{ $filters['search'] }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small letter-spacing-1 mb-3">Categories</label>
                            <div class="dropdown category-filter-dropdown mb-2">
                                <button class="btn btn-outline-dark dropdown-toggle w-100 rounded-4 category-filter-button"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span
                                        class="text-truncate d-inline-block category-filter-label">{{ $selectedCategoryLabel }}</span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow-sm rounded-4 p-2 category-filter-menu">
                                    <li>
                                        <button type="button"
                                            class="dropdown-item rounded-3 {{ !$filters['category_id'] ? 'active' : '' }} category-filter-item"
                                            data-category-id="">
                                            All Categories
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider my-2">
                                    </li>
                                    @foreach ($categories as $category)
                                        <li>
                                            <button type="button"
                                                class="dropdown-item rounded-3 category-filter-item {{ $filters['category_id'] == $category->id ? 'active' : '' }}"
                                                data-category-id="{{ $category->id }}">
                                                {{ $category->name }}
                                            </button>
                                        </li>
                                        @foreach ($category->children as $child)
                                            <li>
                                                <button type="button"
                                                    class="dropdown-item rounded-3 ps-4 category-filter-item {{ $filters['category_id'] == $child->id ? 'active' : '' }}"
                                                    data-category-id="{{ $child->id }}">
                                                    — {{ $child->name }}
                                                </button>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                                <input type="hidden" name="category_id" value="{{ $filters['category_id'] }}"
                                    class="category-filter-input">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small letter-spacing-1 mb-3">Price Range</label>
                            <div class="d-flex flex-column gap-2">
                                @foreach ($priceRanges as $range)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="price"
                                            value="{{ $range['value'] }}" id="{{ $range['id'] }}"
                                            @checked($filters['priceRange'] === $range['value'] || (!$filters['priceRange'] && $range['value'] === ''))>
                                        <label class="form-check-label"
                                            for="{{ $range['id'] }}">{{ $range['label'] }}</label>
                                    </div>
                                @endforeach
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
                        <span class="text-muted small fw-medium">Showing {{ $products->firstItem() ?? 0 }} -
                            {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results</span>
                    </div>

                    <div class="d-flex gap-3 align-items-center">
                        <button class="btn btn-outline-dark d-lg-none rounded-pill px-4 shadow-sm" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" class="me-1">
                                <line x1="4" y1="21" x2="4" y2="14"></line>
                                <line x1="4" y1="10" x2="4" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12" y2="3"></line>
                                <line x1="20" y1="21" x2="20" y2="16"></line>
                                <line x1="20" y1="12" x2="20" y2="3"></line>
                                <line x1="1" y1="14" x2="7" y2="14"></line>
                                <line x1="9" y1="8" x2="15" y2="8"></line>
                                <line x1="17" y1="16" x2="23" y2="16"></line>
                            </svg>
                            Filters
                        </button>

                        <form action="{{ route('shop.index') }}" method="get" class="d-flex align-items-center gap-2">
                            @if ($filters['search'])
                                <input type="hidden" name="s" value="{{ $filters['search'] }}">
                            @endif
                            @if ($filters['category_id'])
                                <input type="hidden" name="category_id" value="{{ $filters['category_id'] }}">
                            @endif
                            @if ($filters['priceRange'])
                                <input type="hidden" name="price" value="{{ $filters['priceRange'] }}">
                            @endif

                            <label class="d-none d-sm-block small fw-bold text-muted text-uppercase">Sort:</label>
                            <select name="sort" class="form-select form-select-sm border-0 bg-light rounded-pill px-3"
                                onchange="this.form.submit()">
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
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <div class="py-5">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc"
                                    stroke-width="1" class="mb-3">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    <line x1="11" y1="8" x2="11" y2="14"></line>
                                    <line x1="8" y1="11" x2="14" y2="11"></line>
                                </svg>
                                <h3 class="fw-bold">No products found</h3>
                                <p class="text-muted">We couldn't find any products matching your current filters.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-5 mt-3">Reset All
                                    Filters</a>
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
                    <input type="text" name="s" class="form-control rounded-4" placeholder="Search keywords..."
                        value="{{ $filters['search'] }}">
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-uppercase small letter-spacing-1">Category</label>
                    <div class="dropdown category-filter-dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle w-100 rounded-4 category-filter-button"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span
                                class="text-truncate d-inline-block category-filter-label">{{ $selectedCategoryLabel }}</span>
                        </button>
                        <ul class="dropdown-menu w-100 shadow-sm rounded-4 p-2 category-filter-menu">
                            <li>
                                <button type="button"
                                    class="dropdown-item rounded-3 {{ !$filters['category_id'] ? 'active' : '' }} category-filter-item"
                                    data-category-id="">
                                    All Categories
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-2">
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <button type="button"
                                        class="dropdown-item rounded-3 category-filter-item {{ $filters['category_id'] == $category->id ? 'active' : '' }}"
                                        data-category-id="{{ $category->id }}">
                                        {{ $category->name }}
                                    </button>
                                </li>
                                @foreach ($category->children as $child)
                                    <li>
                                        <button type="button"
                                            class="dropdown-item rounded-3 ps-4 category-filter-item {{ $filters['category_id'] == $child->id ? 'active' : '' }}"
                                            data-category-id="{{ $child->id }}">
                                            — {{ $child->name }}
                                        </button>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                        <input type="hidden" name="category_id" value="{{ $filters['category_id'] }}"
                            class="category-filter-input">
                    </div>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-uppercase small letter-spacing-1">Price Range</label>
                    <div class="row g-2">
                        @foreach ($priceRanges as $range)
                            <div class="col-12">
                                <input class="btn-check" type="radio" name="price" value="{{ $range['value'] }}"
                                    id="m{{ $range['id'] }}" @checked($filters['priceRange'] === $range['value'] || (!$filters['priceRange'] && $range['value'] === ''))>
                                <label class="btn btn-outline-light text-dark border w-100 rounded-pill"
                                    for="m{{ $range['id'] }}">{{ $range['label'] }}</label>
                            </div>
                        @endforeach
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.category-filter-dropdown').forEach(function(dropdown) {
                const input = dropdown.querySelector('.category-filter-input');
                const label = dropdown.querySelector('.category-filter-label');
                const form = dropdown.closest('form');

                dropdown.querySelectorAll('.category-filter-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        const categoryId = this.dataset.categoryId ?? '';
                        input.value = categoryId;
                        label.textContent = this.textContent.trim().replace(/^—\s*/, '');

                        if (form) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
