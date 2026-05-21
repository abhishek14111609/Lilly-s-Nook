@extends('layouts.app')

@section('title', "{$product->name} - Lily's Nook")

@push('styles')
    <style>
        .product-page {
            padding-top: 1rem;
            padding-bottom: 3rem;
        }

        .product-page-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            color: #b6bcc6;
        }

        .product-gallery-panel,
        .product-info-panel,
        .product-card-surface,
        .product-review-surface,
        .product-related-surface {
            background: #fff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.5rem;
            box-shadow: 0 1rem 2.5rem rgba(15, 23, 42, 0.06);
        }

        .product-gallery-panel {
            padding: 1rem;
        }

        .product-main-media {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            min-height: clamp(360px, 50vw, 520px);
            border-radius: 1.25rem;
            overflow: hidden;
            background: #fff;
        }

        .product-main-media img,
        .product-main-media video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.45s ease;
        }

        .product-main-media:hover img,
        .product-main-media:hover video {
            transform: scale(1.03);
        }

        .product-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .product-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid rgba(15, 23, 42, 0.08);
            color: #334155;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .product-meta-title {
            font-family: 'Playfair Display', serif;
            letter-spacing: -0.03em;
            line-height: 1.04;
        }

        .product-rating-stars svg {
            margin-right: 2px;
        }

        .product-price-box {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 0.75rem;
            padding: 1rem 1.15rem;
            border-radius: 1.15rem;
            background: linear-gradient(135deg, rgba(244, 143, 177, 0.08), rgba(244, 143, 177, 0.02));
            border: 1px solid rgba(244, 143, 177, 0.2);
        }

        .product-price-value {
            color: #111827;
            letter-spacing: -0.02em;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .product-size-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .product-size-option .btn {
            min-height: 74px;
            border-radius: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .product-size-option .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.8rem 1.6rem rgba(15, 23, 42, 0.08);
        }

        .product-size-option .btn-check:checked+.btn {
            border-color: var(--primary-color);
            background: rgba(244, 143, 177, 0.08);
            color: #111827;
        }

        .product-actions {
            display: grid;
            gap: 0.9rem;
        }

        .product-action-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 0.75rem;
        }

        .product-favorite-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            min-height: 54px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #fff;
            color: #111827;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        .product-favorite-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 0.8rem 1.5rem rgba(15, 23, 42, 0.08);
            border-color: rgba(244, 143, 177, 0.45);
            color: var(--primary-color);
        }

        .product-favorite-btn.is-active {
            background: #fff0f5;
            border-color: rgba(244, 143, 177, 0.4);
            color: #e11d48;
        }

        .product-gallery-thumbs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(68px, 1fr));
            gap: 0.75rem;
        }

        .product-gallery-thumb {
            aspect-ratio: 3 / 4;
            width: 100%;
            border-radius: 0.9rem;
            border: 2px solid transparent;
            overflow: hidden;
            background: #f8fafc;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .product-gallery-thumb:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.75rem 1.5rem rgba(15, 23, 42, 0.08);
        }

        .product-gallery-thumb.active {
            border-color: var(--primary-color) !important;
        }

        .product-review-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 0.8rem 1.8rem rgba(15, 23, 42, 0.05);
        }

        .product-review-avatar {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            background: var(--primary-color);
        }

        .product-related-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .product-related-surface {
            padding: 1.25rem;
        }

        @media (max-width: 1199.98px) {
            .product-related-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .product-info-panel {
                margin-top: 1.25rem;
            }

            .product-info-panel {
                z-index: 1;
                /* sit beneath any fixed header/nav */
            }

            .product-size-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .product-page {
                padding-top: 0.5rem;
            }

            .product-gallery-panel,
            .product-info-panel,
            .product-review-surface,
            .product-related-surface {
                border-radius: 1.1rem;
            }

            .product-action-grid,
            .product-related-grid {
                grid-template-columns: 1fr;
            }

            .product-size-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
@endpush

@section('content')
    @php
        $galleryImages = collect($product->gallery_images ?? [])
            ->filter()
            ->values();
        $galleryThumbs = collect([$product->image])
            ->merge($galleryImages)
            ->filter()
            ->values();
        $defaultMainImage = $galleryImages->first() ?: $product->image;
        $mainImageSrc = $defaultMainImage ? asset('images/' . ltrim($defaultMainImage, '/')) : null;
        $mainVideoSrc = !empty($product->video) ? asset(ltrim($product->video, '/')) : null;
        $isWishlisted = $isWishlisted ?? false;
    @endphp

    <div class="container py-4 py-lg-5 product-page">
        <nav aria-label="breadcrumb" class="product-page-breadcrumb mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Shop</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 240px;">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5 align-items-start">
            <div class="col-lg-7">
                <div class="product-gallery-panel">
                    <div class="position-relative product-main-media" style="aspect-ratio: 3 / 4;">
                        @if (!empty($mainVideoSrc) && empty($defaultMainImage))
                            <img id="product-main-image" src="{{ $mainImageSrc ?? '' }}" alt="{{ $product->name }}"
                                class="w-100 h-100 object-fit-cover d-none">
                            <video id="product-main-video" src="{{ $mainVideoSrc }}" class="w-100 h-100 object-fit-cover"
                                autoplay muted loop playsinline preload="metadata"></video>
                        @else
                            <img id="product-main-image" src="{{ $mainImageSrc }}" alt="{{ $product->name }}"
                                class="w-100 h-100 object-fit-cover">
                            @if (!empty($mainVideoSrc))
                                <video id="product-main-video" src="{{ $mainVideoSrc }}"
                                    class="w-100 h-100 object-fit-cover d-none" autoplay muted loop playsinline
                                    preload="metadata" poster="{{ $mainImageSrc }}"></video>
                            @endif
                        @endif

                        <div class="position-absolute top-0 inset-s-0 p-3">
                            <div class="product-badges">
                                <span class="product-badge">New Arrival</span>
                                <span class="product-badge">{{ $canPurchase ? 'In Stock' : 'Sold Out' }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($galleryThumbs->isNotEmpty() || !empty($mainVideoSrc))
                        <div class="product-gallery-thumbs mt-3">
                            @if (!empty($mainVideoSrc))
                                <button type="button"
                                    class="product-gallery-thumb btn p-0 {{ empty($defaultMainImage) ? 'active' : '' }}"
                                    data-media-type="video" data-media-src="{{ $mainVideoSrc }}"
                                    data-media-poster="{{ $mainImageSrc }}">
                                    @if ($defaultMainImage)
                                        <img src="{{ $mainImageSrc }}" alt="{{ $product->name }}"
                                            class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 bg-secondary"></div>
                                    @endif
                                </button>
                            @endif

                            @foreach ($galleryThumbs as $index => $imagePath)
                                <button type="button"
                                    class="product-gallery-thumb btn p-0 {{ $index === 0 && empty($mainVideoSrc) ? 'active' : '' }}"
                                    data-media-type="image"
                                    data-media-src="{{ asset('images/' . ltrim($imagePath, '/')) }}">
                                    <img src="{{ asset('images/' . ltrim($imagePath, '/')) }}" alt="{{ $product->name }}"
                                        class="w-100 h-100 object-fit-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-5">
                <div class="product-info-panel p-4 p-lg-5 sticky-lg-top"
                    style="top: calc(var(--site-header-height, 80px) + 0.75rem); z-index:1;">
                    <div class="product-badges mb-3">
                        @if ($product->category)
                            <span class="product-badge">{{ $product->category->name }}</span>
                        @endif
                        <span class="product-badge">{{ $availableStock }} total stock</span>
                        <span class="product-badge">{{ $canReviewProduct ? 'Reviewable' : 'Login to review' }}</span>
                    </div>

                    <h1 class="display-5 fw-bold product-meta-title mb-3">{{ $product->name }}</h1>

                    <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                        @php $avg = (float) ($ratingAggregate->average_rating ?? 0); @endphp
                        <div class="d-inline-flex align-items-center gap-1 text-warning product-rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg width="18" height="18" viewBox="0 0 24 24"
                                    fill="{{ $i <= round($avg) ? 'currentColor' : 'none' }}" stroke="currentColor">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <span class="fw-bold text-dark">{{ number_format($avg, 1) }}</span>
                        <span class="text-muted small">({{ $ratingAggregate->total_reviews ?? 0 }} reviews)</span>
                    </div>

                    <div class="product-price-box mb-4">
                        <h2 class="display-6 fw-bold mb-0 product-price-value">₹<span
                                id="product-price-value">{{ number_format($selectedPrice, 2) }}</span></h2>
                        <input type="hidden" id="base_price" value="{{ $product->price }}">
                    </div>

                    <p class="text-muted fs-5 mb-4 lh-base">
                        {{ $product->description ?: 'This beautiful piece is carefully chosen to bring enchantment to your little one\'s wardrobe.' }}
                    </p>

                    @auth
                        <div class="product-card-surface p-3 p-lg-4 mb-4">
                            <form method="post" action="{{ route('products.cart.store', $product) }}" id="product-form">
                                @csrf

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="fw-bold text-uppercase small letter-spacing-1 mb-0">Select Size</label>
                                    <a href="#" class="text-decoration-none small fw-bold text-primary"
                                        data-bs-toggle="modal" data-bs-target="#sizeChartModal">Size Guide</a>
                                </div>

                                @if (!empty($sizeOptions))
                                    <div class="product-size-grid mb-4">
                                        @foreach ($sizeOptions as $opt)
                                            <div class="product-size-option">
                                                <input type="radio" class="btn-check size-option-input" name="size"
                                                    id="size_{{ $loop->index }}" value="{{ $opt['value'] }}"
                                                    data-price="{{ $opt['price'] }}"
                                                    {{ $selectedSize === $opt['value'] ? 'checked' : '' }}
                                                    {{ $opt['available'] ? '' : 'disabled' }} required>
                                                <label class="btn btn-outline-dark w-100 py-3" for="size_{{ $loop->index }}">
                                                    <span class="fw-bold d-block">{{ $opt['label'] }}</span>
                                                    <small class="opacity-60">
                                                        {{ $opt['available'] ? '₹' . number_format($opt['price'], 0) : 'Sold Out' }}
                                                    </small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small mb-3">Automatic one-size selection.</p>
                                    <input type="hidden" name="size" value="ONE SIZE">
                                @endif

                                @error('size')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                                <div class="product-action-grid mt-4">
                                    <button type="submit" class="btn btn-dark btn-lg rounded-pill py-3 fw-bold shadow-sm"
                                        @disabled(!$canPurchase)>
                                        Add to Cart
                                    </button>
                                    <button type="submit" name="buy_now" value="1"
                                        class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow-sm"
                                        @disabled(!$canPurchase)>
                                        Buy Now
                                    </button>
                                </div>
                            </form>

                            <form method="post" action="{{ route('products.wishlist.store', $product) }}" class="mt-3">
                                @csrf
                                <button type="submit" class="product-favorite-btn {{ $isWishlisted ? 'is-active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                                        </path>
                                    </svg>
                                    {{ $isWishlisted ? 'Saved to Wishlist' : 'Add to Wishlist' }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="product-card-surface p-4 text-center mb-4">
                            <p class="mb-3">Ready to sparkle? Log in to your account to place an order or save this to your
                                wishlist.</p>
                            <a href="{{ route('login') }}" class="btn btn-dark px-5 rounded-pill shadow-sm">Login to
                                Purchase</a>
                        </div>
                    @endauth

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3 product-card-surface p-3 h-100">
                                <div class="bg-soft-primary p-2 rounded-3 text-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Quality Guaranteed</h6>
                                    <small class="text-muted">Premium craftsmanship</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3 product-card-surface p-3 h-100">
                                <div class="bg-soft-success p-2 rounded-3 text-success">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Fast Shipping</h6>
                                    <small class="text-muted">Delivery in 3-5 days</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="product-review-surface mt-5 p-4 p-lg-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <h3 class="display-6 fw-bold mb-4">Verified Reviews</h3>

                    <div class="d-flex flex-column gap-4">
                        @forelse ($productReviews as $review)
                            <div class="product-review-card p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 44px; height: 44px;">
                                            {{ substr($review->name ?: $review->user?->name ?? 'C', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">
                                                {{ $review->name ?: $review->user?->name ?? 'Customer' }}</h6>
                                            <small class="text-muted">{{ $review->created_at?->format('d M, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg width="14" height="14" viewBox="0 0 24 24"
                                                fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}"
                                                stroke="currentColor">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                                </path>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-0 text-muted fs-5 lh-base italic">"{{ $review->quote }}"</p>
                            </div>
                        @empty
                            <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                                <p class="text-muted mb-0">No reviews yet for this product. Be the first to share your
                                    experience!</p>
                            </div>
                        @endforelse

                        @if ($productReviews->hasPages())
                            <div class="mt-2">{{ $productReviews->links() }}</div>
                        @endif
                    </div>
                </div>

                <!-- Review Form -->
                <div class="col-lg-5">
                    <div class="product-card-surface p-4">
                        <h4 class="fw-bold mb-4">Share your thoughts</h4>

                        @auth
                            @if ($canReviewProduct || $userReviewForProduct)
                                <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-uppercase letter-spacing-1">Rating</label>
                                        <div class="d-flex gap-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" class="btn-check" name="rating"
                                                    id="rate_{{ $i }}" value="{{ $i }}"
                                                    {{ (int) old('rating', $userReviewForProduct?->rating) === $i ? 'checked' : '' }}
                                                    required>
                                                <label
                                                    class="btn btn-outline-warning border rounded-circle p-2 d-flex align-items-center justify-content-center"
                                                    style="width: 44px; height: 44px;" for="rate_{{ $i }}">
                                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                                        fill="currentColor">
                                                        <path
                                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-uppercase letter-spacing-1">Your
                                            Review</label>
                                        <textarea name="quote" class="form-control rounded-4 p-3" rows="4"
                                            placeholder="What did you like about the fit and design?" required>{{ old('quote', $userReviewForProduct?->quote) }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-3 shadow fw-bold">
                                        {{ $userReviewForProduct ? 'Update My Review' : 'Submit Review' }}
                                    </button>
                                </form>
                            @else
                                <div class="bg-light-subtle border p-3 rounded-3">
                                    <p class="small text-muted mb-0">Share your thoughts and experiences with this product.
                                        Your review helps other customers make informed decisions!</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted small">Please sign in to leave a product review.</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-4">Login Now</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="product-related-surface mt-5">
                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                    <div>
                        <p class="text-uppercase small fw-bold text-primary mb-1 letter-spacing-1">More to explore</p>
                        <h3 class="display-6 fw-bold mb-0">Related Products</h3>
                    </div>
                    <a href="{{ route('shop.index') }}" class="text-decoration-none fw-bold text-dark">View all
                        products</a>
                </div>

                <div class="product-related-grid">
                    @foreach ($relatedProducts as $relatedProduct)
                        @include('partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeInputs = document.querySelectorAll('.size-option-input');
            const priceValueElement = document.getElementById('product-price-value');
            const mainImage = document.getElementById('product-main-image');
            const mainVideo = document.getElementById('product-main-video');
            const galleryThumbs = document.querySelectorAll('.product-gallery-thumb');
            const basePrice = Number(document.getElementById('base_price')?.value || 0);
            const gstRate = Number(@json((float) $product->gstRate()));
            const gstInclusive = @json((bool) $product->is_gst_inclusive);

            const formatPrice = (val) => new Intl.NumberFormat('en-IN', {
                minimumFractionDigits: 2
            }).format(Number(val));

            const calculatePrice = (price) => {
                if (!gstRate) {
                    return {
                        final: price,
                    };
                }

                if (gstInclusive) {
                    return {
                        final: price,
                    };
                }

                const gst = price * (gstRate / 100);
                return {
                    final: price + gst,
                };
            };

            const syncPriceDisplay = (price) => {
                const breakdown = calculatePrice(Number(price));

                priceValueElement.classList.add('transition-all', 'opacity-0');
                setTimeout(() => {
                    priceValueElement.textContent = formatPrice(breakdown.final);
                    priceValueElement.classList.remove('opacity-0');
                }, 100);
            };

            const initiallySelectedSize = document.querySelector('.size-option-input:checked');
            syncPriceDisplay(initiallySelectedSize?.dataset.price || basePrice);

            sizeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const price = this.dataset.price;
                    if (price) {
                        syncPriceDisplay(price);
                    }
                });
            });

            // Ensure a visible video plays on load (muted to satisfy autoplay policies)
            if (mainVideo && !mainVideo.classList.contains('d-none')) {
                try {
                    mainVideo.muted = true;
                    mainVideo.play().catch(() => {});
                } catch (e) {}
            }

            galleryThumbs.forEach((thumb) => {
                thumb.addEventListener('click', function() {
                    const mediaType = this.dataset.mediaType;
                    const mediaSrc = this.dataset.mediaSrc;
                    const mediaPoster = this.dataset.mediaPoster || '';

                    galleryThumbs.forEach((item) => {
                        item.classList.remove('active', 'border-primary');
                        if (item.dataset.mediaType === 'image') {
                            item.classList.add('border-transparent');
                        }
                    });
                    this.classList.add('active');
                    if (this.dataset.mediaType === 'image') {
                        this.classList.remove('border-transparent');
                        this.classList.add('border-primary');
                    }

                    if (mediaType === 'video') {
                        if (mainImage) {
                            mainImage.classList.add('d-none');
                        }
                        if (mainVideo) {
                            // set src/poster, ensure muted, then load & play
                            mainVideo.src = mediaSrc;
                            if (mediaPoster) {
                                mainVideo.poster = mediaPoster;
                            }
                            mainVideo.classList.remove('d-none');
                            try {
                                mainVideo.muted = true;
                                mainVideo.load();
                                mainVideo.play().catch(() => {});
                            } catch (e) {}
                        }
                        return;
                    }

                    // switching to image: pause and clear video
                    if (mainVideo) {
                        try {
                            mainVideo.pause();
                        } catch (e) {}
                        mainVideo.classList.add('d-none');
                        try {
                            mainVideo.src = '';
                        } catch (e) {}
                    }

                    if (mainImage) {
                        mainImage.src = mediaSrc;
                        mainImage.classList.remove('d-none');
                    }
                });
            });
        });
    </script>
@endpush
