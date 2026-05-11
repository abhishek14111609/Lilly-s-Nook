@php
    $wishlistProductIds = $wishlistProductIds ?? [];
    $isWishlisted = in_array($product->id, $wishlistProductIds, true);
@endphp

<div class="card h-100 border-0 bg-transparent product-card-shell group">
    <div
        class="position-relative overflow-hidden rounded-5 mb-3 shadow-sm border border-light-subtle bg-light product-card-media-shell">
        @if ($product->video)
            <video autoplay loop muted playsinline
                class="card-img-top object-fit-cover w-100 h-100 position-absolute inset-0 product-card-media">
                <source src="{{ asset(ltrim($product->video, '/')) }}" type="video/mp4">
            </video>
        @else
            <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}"
                class="card-img-top object-fit-cover w-100 h-100 product-card-media" alt="{{ $product->name }}">
        @endif

        <div class="product-card-overlay"></div>

        <div
            class="position-absolute top-0 inset-s-0 w-100 p-3 z-3 d-flex justify-content-between align-items-start product-card-topbar">
            @if ($product->is_new ?? false)
                <span class="product-card-pill">New</span>
            @endif

            <div class="ms-auto d-flex gap-2">
                @auth
                    <form method="post" action="{{ route('products.wishlist.store', $product) }}" class="m-0">
                        @csrf
                        <button type="submit" class="product-card-favorite {{ $isWishlisted ? 'is-active' : '' }}"
                            aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M20.8 4.6c-1.5-1.6-4-1.6-5.5 0L12 8l-3.3-3.4c-1.5-1.6-4-1.6-5.5 0-1.7 1.8-1.7 4.6 0 6.4L12 19l8.8-7.4c1.7-1.8 1.7-4.6 0-6.4Z" />
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="product-card-favorite" aria-label="Login to add to wishlist">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M20.8 4.6c-1.5-1.6-4-1.6-5.5 0L12 8l-3.3-3.4c-1.5-1.6-4-1.6-5.5 0-1.7 1.8-1.7 4.6 0 6.4L12 19l8.8-7.4c1.7-1.8 1.7-4.6 0-6.4Z" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>

        @if ($product->stock <= 0)
            <span class="product-card-stock-badge">Sold out</span>
        @endif

        <div class="position-absolute bottom-0 inset-s-0 w-100 p-3 p-lg-4 z-3 product-card-action">
            <a href="{{ route('products.show', $product) }}"
                class="btn btn-light w-100 rounded-pill shadow-sm py-3 fw-bold d-flex justify-content-center align-items-center gap-2 product-card-action-btn">
                <span>View Details</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    <div class="card-body px-1 px-lg-2 pt-3 d-flex flex-column text-center">
        <h5 class="card-title fw-semibold mb-1 h6 text-truncate mx-auto product-card-title" style="max-width: 95%;">
            <a href="{{ route('products.show', $product) }}"
                class="text-dark text-decoration-none">{{ $product->name }}</a>
        </h5>
        @if ($product->category)
            <span class="text-muted small mb-2 d-block product-card-category">{{ $product->category->name }}</span>
        @endif
        <div class="mt-auto d-flex justify-content-center align-items-center gap-2 product-card-price-row">
            <span
                class="fw-bold fs-5 text-dark product-card-price">&#8377;{{ number_format($product->price, 2) }}</span>
        </div>
    </div>
</div>

<style>
    .product-card-shell {
        transition: transform 0.35s ease, filter 0.35s ease;
    }

    .product-card-media-shell {
        aspect-ratio: 3 / 4;
        background: linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        isolation: isolate;
    }

    .product-card-media {
        transition: transform 0.7s ease, filter 0.7s ease;
    }

    .product-card-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.03) 0%, rgba(15, 23, 42, 0.18) 55%, rgba(15, 23, 42, 0.65) 100%);
        opacity: 0.65;
        transition: opacity 0.35s ease, background 0.35s ease;
    }

    .product-card-topbar {
        pointer-events: none;
    }

    .product-card-topbar>* {
        pointer-events: auto;
    }

    .product-card-pill,
    .product-card-stock-badge,
    .product-card-favorite {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        border-radius: 999px;
        padding: 0.55rem 0.9rem;
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border: 1px solid rgba(255, 255, 255, 0.6);
        background: rgba(255, 255, 255, 0.94);
        color: #111827;
        box-shadow: 0 0.6rem 1.25rem rgba(15, 23, 42, 0.12);
    }

    .product-card-favorite {
        width: 40px;
        height: 40px;
        padding: 0;
        border: none;
        color: #6b7280;
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card-favorite:hover {
        transform: translateY(-1px) scale(1.03);
        color: var(--primary-color);
    }

    .product-card-favorite.is-active {
        background: #fff0f5;
        color: #e11d48;
        box-shadow: 0 0.8rem 1.5rem rgba(225, 29, 72, 0.16);
    }

    .product-card-stock-badge {
        position: absolute;
        left: 1rem;
        bottom: 5.2rem;
        z-index: 3;
        background: rgba(220, 38, 38, 0.92);
        color: #fff;
        border-color: transparent;
    }

    .product-card-action {
        opacity: 0;
        transform: translateY(12px);
        transition: opacity 0.35s ease, transform 0.35s ease;
    }

    .product-card-action-btn {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(15, 23, 42, 0.08);
        color: #111827;
    }

    .product-card-shell:hover {
        transform: translateY(-6px);
    }

    .product-card-shell:hover .product-card-media {
        transform: scale(1.08);
        filter: saturate(1.02) contrast(1.02);
    }

    .product-card-shell:hover .product-card-overlay {
        opacity: 0.88;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.01) 0%, rgba(15, 23, 42, 0.12) 55%, rgba(15, 23, 42, 0.52) 100%);
    }

    .product-card-shell:hover .product-card-action {
        opacity: 1;
        transform: translateY(0);
    }

    .product-card-title a:hover {
        color: var(--primary-color) !important;
    }

    .product-card-category,
    .product-card-price {
        transition: color 0.2s ease;
    }

    .product-card-shell:hover .product-card-category {
        color: #374151 !important;
    }

    .product-card-shell:hover .product-card-price {
        color: #111827;
    }

    @media (max-width: 575.98px) {
        .product-card-media-shell {
            aspect-ratio: 4 / 5;
        }

        .product-card-action {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card-stock-badge {
            left: 0.75rem;
            bottom: 4.8rem;
        }
    }
</style>
