@extends('layouts.app')

@section('title', "{$product->name} - Lilly's Nook")

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Shop</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 200px;">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Media -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                    <div class="position-relative">
                        @if (!empty($product->video))
                            <video src="{{ asset($product->video) }}" class="w-100 vh-60 object-fit-cover" autoplay muted loop playsinline preload="metadata" poster="{{ asset('images/' . $product->image) }}"></video>
                        @else
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="w-100 vh-60 object-fit-cover shadow-sm">
                        @endif
                        
                        <div class="position-absolute top-0 start-0 p-3">
                            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold shadow-sm border border-primary-subtle">NEW ARRIVAL</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-5">
                <div class="ps-lg-4">
                    <h1 class="display-5 fw-bold mb-2">{{ $product->name }}</h1>
                    
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="text-warning">
                            @php $avg = (float)($ratingAggregate->average_rating ?? 0); @endphp
                            @for($i=1; $i<=5; $i++)
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $i <= round($avg) ? 'currentColor' : 'none' }}" stroke="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                            @endfor
                        </div>
                        <span class="fw-bold text-dark">{{ number_format($avg, 1) }}</span>
                        <span class="text-muted small">({{ $ratingAggregate->total_reviews ?? 0 }} Reviews)</span>
                    </div>

                    <div class="mb-4">
                        <h2 class="display-6 fw-bold text-primary mb-1">₹<span id="product-price-value">{{ number_format($selectedPrice, 2) }}</span></h2>
                        <input type="hidden" id="base_price" value="{{ $product->price }}">
                        <p class="text-success small fw-medium mb-0">Inclusive of all taxes</p>
                    </div>

                    <p class="text-muted fs-5 mb-4">{{ $product->description ?: 'This beautiful piece is carefully chosen to bring enchantment to your little one\'s wardrobe.' }}</p>

                    @auth
                        <form method="post" action="{{ route('products.cart.store', $product) }}" id="product-form">
                            @csrf
                            
                            <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="fw-bold text-uppercase small letter-spacing-1">Select Size</label>
                                    <a href="#" class="text-decoration-none small fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#sizeChartModal">Size Guide</a>
                                </div>
                                
                                @if (!empty($sizeOptions))
                                    <div class="row g-2">
                                        @foreach ($sizeOptions as $opt)
                                            <div class="col-4 col-sm-3 col-lg-4">
                                                <input type="radio" class="btn-check size-option-input" name="size" id="size_{{ $loop->index }}" 
                                                    value="{{ $opt['value'] }}" data-price="{{ $opt['price'] }}" 
                                                    {{ $selectedSize === $opt['value'] ? 'checked' : '' }} 
                                                    {{ $opt['available'] ? '' : 'disabled' }} required>
                                                <label class="btn btn-outline-dark w-100 rounded-3 py-3 border border-light-subtle shadow-sm" for="size_{{ $loop->index }}">
                                                    <span class="fw-bold d-block">{{ $opt['label'] }}</span>
                                                    <small class="opacity-60">{{ $opt['available'] ? '₹' . number_format($opt['price'], 0) : 'Sold Out' }}</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small">Automatic one-size selection.</p>
                                    <input type="hidden" name="size" value="ONE SIZE">
                                @endif
                                
                                @error('size') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-grid gap-3 mb-4">
                                <div class="row g-2">
                                    <div class="col-8">
                                        <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill py-3 fw-bold shadow {{ $canPurchase ? '' : 'disabled' }}">
                                            Add to Cart
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" name="buy_now" value="1" class="btn btn-primary btn-lg w-100 rounded-pill py-3 fw-bold shadow {{ $canPurchase ? '' : 'disabled' }}">
                                            Buy Now
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-link text-dark text-decoration-none fw-bold" onclick="this.closest('form').action='{{ route('products.wishlist.store', $product) }}'; this.closest('form').submit();">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                                    Add to Wishlist
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-4 bg-light border rounded-4 text-center mb-4">
                            <p class="mb-3">Ready to sparkle? Log in to your account to place an order or save this to your wishlist.</p>
                            <a href="{{ route('login') }}" class="btn btn-dark px-5 rounded-pill shadow-sm">Login to Purchase</a>
                        </div>
                    @endauth

                    <hr class="my-5">

                    <!-- Product Benefits -->
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-soft-primary p-2 rounded-3 text-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Quality Guaranteed</h6>
                                    <small class="text-muted">Premium craftsmanship</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-soft-success p-2 rounded-3 text-success">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
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
        <div class="mt-5 pt-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <h3 class="display-6 fw-bold mb-4">Verified Reviews</h3>
                    
                    <div class="d-flex flex-column gap-4">
                        @forelse ($productReviews as $review)
                            <div class="card border border-light-subtle shadow-sm p-4 rounded-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px;">
                                            {{ substr($review->name ?: $review->user?->name ?? 'C', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $review->name ?: $review->user?->name ?? 'Customer' }}</h6>
                                            <small class="text-muted">{{ $review->created_at?->format('d M, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="text-warning">
                                        @for($i=1; $i<=5; $i++)
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-0 text-muted fs-5 lh-base italic">"{{ $review->quote }}"</p>
                            </div>
                        @empty
                            <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                                <p class="text-muted mb-0">No reviews yet for this product. Be the first to share your experience!</p>
                            </div>
                        @endforelse

                        @if ($productReviews->hasPages())
                            <div class="mt-2">{{ $productReviews->links() }}</div>
                        @endif
                    </div>
                </div>

                <!-- Review Form -->
                <div class="col-lg-5">
                    <div class="card bg-white shadow-sm border border-light-subtle p-4 rounded-4 sticky-top" style="top: 100px;">
                        <h4 class="fw-bold mb-4">Share your thoughts</h4>
                        
                        @auth
                            @if ($canReviewProduct || $userReviewForProduct)
                                <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-uppercase letter-spacing-1">Rating</label>
                                        <div class="d-flex gap-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" class="btn-check" name="rating" id="rate_{{ $i }}" value="{{ $i }}" {{ (int)old('rating', $userReviewForProduct?->rating) === $i ? 'checked' : '' }} required>
                                                <label class="btn btn-outline-warning border rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" for="rate_{{ $i }}">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-uppercase letter-spacing-1">Your Review</label>
                                        <textarea name="quote" class="form-control rounded-4 p-3" rows="4" placeholder="What did you like about the fit and design?" required>{{ old('quote', $userReviewForProduct?->quote) }}</textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-3 shadow fw-bold">
                                        {{ $userReviewForProduct ? 'Update My Review' : 'Submit Review' }}
                                    </button>
                                </form>
                            @else
                                <div class="bg-light-subtle border p-3 rounded-3">
                                    <p class="small text-muted mb-0">Purchased this item? You can leave your honest review after the order is delivered.</p>
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
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeInputs = document.querySelectorAll('.size-option-input');
            const priceValueElement = document.getElementById('product-price-value');
            
            const formatPrice = (val) => new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2 }).format(Number(val));

            sizeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const price = this.dataset.price;
                    if (price) {
                        priceValueElement.classList.add('transition-all', 'opacity-0');
                        setTimeout(() => {
                            priceValueElement.textContent = formatPrice(price);
                            priceValueElement.classList.remove('opacity-0');
                        }, 100);
                    }
                });
            });
        });
    </script>
@endpush
