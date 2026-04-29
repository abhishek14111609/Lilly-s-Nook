<div class="card h-100 border-0 bg-transparent product-card-hover group">
    <div class="position-relative overflow-hidden rounded-4 mb-3 shadow-sm border border-light-subtle bg-light" style="aspect-ratio: 3/4;">
        @if ($product->video)
            <video autoplay loop muted playsinline class="card-img-top object-fit-cover w-100 h-100 transition-all position-absolute inset-0" style="transition: transform 0.5s ease;">
                <source src="{{ asset(ltrim($product->video, '/')) }}" type="video/mp4">
            </video>
        @else
            <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}"
                class="card-img-top object-fit-cover w-100 h-100 transition-all"
                alt="{{ $product->name }}" style="transition: transform 0.5s ease;">
        @endif
        
        <!-- Badges -->
        <div class="position-absolute top-0 end-0 p-3 z-2 d-flex flex-column gap-2">
            @if($product->is_new ?? false)
                <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 fw-bold letter-spacing-1" style="font-size: 0.7rem;">NEW</span>
            @endif
            @if($product->stock <= 0)
                <span class="badge bg-danger text-white shadow-sm rounded-pill px-3 py-2 fw-bold letter-spacing-1" style="font-size: 0.7rem;">SOLD OUT</span>
            @endif
        </div>

        <!-- Hover Quick Action -->
        <div class="position-absolute bottom-0 start-0 w-100 p-3 z-2 opacity-0 translate-y-100 product-card-action transition-all">
            <a href="{{ route('products.show', $product) }}" class="btn btn-white w-100 rounded-pill shadow-sm py-2 fw-bold d-flex justify-content-center align-items-center gap-2">
                <span>View Details</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        <!-- Dark Gradient Overlay for hover effect -->
        <div class="position-absolute inset-0 bg-dark opacity-0 transition-all product-card-overlay z-1" style="transition: opacity 0.3s ease;"></div>
    </div>
    
    <div class="card-body p-0 d-flex flex-column text-center">
        <h5 class="card-title fw-bold mb-1 h6 text-truncate mx-auto" style="max-width: 90%;">
            <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none hover-primary transition-all">{{ $product->name }}</a>
        </h5>
        @if($product->category)
            <span class="text-muted small mb-2 d-block">{{ $product->category->name }}</span>
        @endif
        <div class="mt-auto d-flex justify-content-center align-items-center gap-2">
            <span class="fw-bold fs-5 text-dark">&#8377;{{ number_format($product->price, 2) }}</span>
        </div>
    </div>
</div>

<style>
.product-card-hover .card-img-top { transform: scale(1); }
.product-card-hover:hover .card-img-top { transform: scale(1.08); }
.product-card-hover .product-card-action { opacity: 0; transform: translateY(10px); }
.product-card-hover:hover .product-card-action { opacity: 1 !important; transform: translateY(0) !important; }
.product-card-hover:hover .product-card-overlay { opacity: 0.1 !important; }
</style>
