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
                        <div class="image-holder">
                            @if (!empty($product->video))
                                <video src="{{ asset($product->video) }}" class="product-image" autoplay muted loop
                                    playsinline preload="metadata" poster="{{ asset('images/' . $product->image) }}">
                                </video>
                            @else
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="product-image" loading="lazy">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-detail-card">
                        <div class="product-detail">
                            <h2 class="product-title">{{ $product->name }}</h2>
                            <p class="product-price">&#8377;{{ number_format($product->price, 2) }}</p>
                            <div class="product-rating-summary mb-3">
                                @php
                                    $averageRating = (float) ($ratingAggregate->average_rating ?? 0);
                                    $totalReviews = (int) ($ratingAggregate->total_reviews ?? 0);
                                    $filledStars = (int) round($averageRating);
                                @endphp
                                <div class="rating-stars"
                                    aria-label="Average rating {{ number_format($averageRating, 1) }} out of 5">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <span
                                            class="rating-star {{ $star <= $filledStars ? 'filled' : '' }}">&#9733;</span>
                                    @endfor
                                </div>
                                <div class="rating-meta">
                                    <strong>{{ number_format($averageRating, 1) }}</strong>
                                    <span>({{ $totalReviews }}
                                        {{ \Illuminate\Support\Str::plural('review', $totalReviews) }})</span>
                                </div>
                            </div>
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

    <section class="padding-large product-review-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="review-panel">
                        <h3 class="mb-3">Customer Reviews</h3>

                        @forelse ($productReviews as $review)
                            <article class="review-card">
                                <div class="review-card-head">
                                    <div>
                                        <h4 class="review-author">
                                            {{ $review->name ?: $review->user?->name ?? 'Customer' }}</h4>
                                        <p class="review-date mb-0">{{ $review->created_at?->format('d M Y') }}</p>
                                    </div>
                                    <div class="rating-stars" aria-label="{{ $review->rating }} out of 5">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <span
                                                class="rating-star {{ $star <= (int) $review->rating ? 'filled' : '' }}">&#9733;</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="review-body mb-0">{{ $review->quote }}</p>
                            </article>
                        @empty
                            <p class="text-muted mb-0">No approved reviews yet. Be the first to review this product.</p>
                        @endforelse

                        @if ($productReviews->hasPages())
                            <div class="mt-3">
                                {{ $productReviews->links('vendor.pagination.shop') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="review-panel">
                        <h3 class="mb-3">Write a Review</h3>

                        @auth
                            @if ($canReviewProduct || $userReviewForProduct)
                                <form action="{{ route('products.reviews.store', $product) }}" method="POST"
                                    class="review-form">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Your Rating</label>
                                        <input type="hidden" id="rating" name="rating"
                                            value="{{ old('rating', $userReviewForProduct?->rating) }}"
                                            @error('rating') aria-invalid="true" @enderror required>
                                        <div class="star-rating-input" role="radiogroup" aria-label="Select rating">
                                            @for ($value = 1; $value <= 5; $value++)
                                                <button type="button" class="star-rating-btn"
                                                    data-rating="{{ $value }}"
                                                    aria-label="{{ $value }} star{{ $value > 1 ? 's' : '' }}"
                                                    {{ (string) old('rating', $userReviewForProduct?->rating) === (string) $value ? 'aria-pressed="true"' : '' }}>
                                                    <span class="rating-star">&#9733;</span>
                                                </button>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="quote" class="form-label">Your Review</label>
                                        <textarea id="quote" name="quote" rows="5" class="form-control @error('quote') is-invalid @enderror"
                                            placeholder="Share your experience with this product" required>{{ old('quote', $userReviewForProduct?->quote) }}</textarea>
                                        @error('quote')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-dark w-100">
                                        {{ $userReviewForProduct ? 'Update My Review' : 'Submit Review' }}
                                    </button>
                                    <p class="text-muted small mt-2 mb-0">Your review will be published instantly.</p>
                                </form>
                            @else
                                <p class="text-muted mb-0">You can review this product after purchasing it from your account.
                                </p>
                            @endif
                        @else
                            <p class="text-muted mb-2">Please login to rate and review this product.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-dark">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/product-show.css') }}">
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInput = document.getElementById('rating');
            const starButtons = document.querySelectorAll('.star-rating-btn');

            starButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const rating = this.dataset.rating;

                    // Update hidden input
                    ratingInput.value = rating;

                    // Update button states
                    starButtons.forEach(btn => {
                        if (btn.dataset.rating <= rating) {
                            btn.setAttribute('aria-pressed', 'true');
                        } else {
                            btn.removeAttribute('aria-pressed');
                        }
                    });
                });
            });
        });
    </script>
@endpush
