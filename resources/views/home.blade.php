@extends('layouts.app')

@section('title', "Lilly's Nook - Timeless Boutique for Little Stars")

@section('content')
    @php
        $defaultSliders = [
            [
                'title' => 'Curated with love, for the little ones',
                'subtitle' => 'A sweet collection designed to celebrate childhood with comfort and charm.',
                'button_text' => 'Shop now',
                'button_url' => route('shop.index'),
                'image' => 'banner1.jpg',
            ],
            [
                'title' => 'Timeless charm for tiny trendsetters',
                'subtitle' => 'Classic silhouettes and playful details for girls who shine bright.',
                'button_text' => 'Shop now',
                'button_url' => route('shop.index'),
                'image' => 'banner2.jpg',
            ],
        ];

        $testimonialItems = isset($testimonials) && $testimonials->isNotEmpty() ? $testimonials : collect([
            ['name' => 'Ananya Mehta', 'role' => 'Fashion Blogger', 'quote' => "Lilly's Nook always gets my style right. Premium quality and beautiful stitching.", 'rating' => 5],
            ['name' => 'Rhea Sharma', 'role' => 'Repeat Customer', 'quote' => "The fit and fabric quality are amazing. Every order feels thoughtfully curated.", 'rating' => 5],
            ['name' => 'Nisha Arora', 'role' => 'Stylist', 'quote' => "I recommend Lilly's Nook to my clients for statement pieces that are wearable and elegant.", 'rating' => 5],
        ]);

        $sliderItems = isset($sliders) && $sliders->isNotEmpty() ? $sliders : collect($defaultSliders);
    @endphp

    <!-- Hero Carousel -->
    <section id="hero" class="mb-5">
        <div id="heroCarousel" class="carousel slide carousel-fade vh-75" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
                @foreach ($sliderItems as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100">
                        <div class="h-100 velvet-bg d-flex align-items-center" style="background-image: url('{{ asset('images/' . data_get($slide, 'image')) }}'); background-size: cover; background-position: center;">
                            <div class="container py-5">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 hero-content text-white">
                                        <h1 class="display-2 fw-bold mb-3 hero-glow">{{ data_get($slide, 'title') }}</h1>
                                        <p class="lead mb-4 opacity-90">{{ data_get($slide, 'subtitle') }}</p>
                                        <div class="d-flex gap-3">
                                            <a href="{{ data_get($slide, 'button_url') ?: route('shop.index') }}" class="btn btn-primary px-5 py-3 rounded-pill shadow-lg fw-bold">
                                                {{ data_get($slide, 'button_text') ?: 'Explore Collection' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 reveal-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="display-5 fw-bold mb-0">Shop by Category</h2>
                    <p class="text-muted fs-5 mb-0">A world of whimsy for every age</p>
                </div>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">View All</a>
            </div>

            <div class="row g-4">
                @foreach ($categories as $category)
                    <div class="col-12 col-md-6 col-lg-{{ $loop->first ? '8' : ($loop->iteration == 2 ? '4' : '3') }}">
                        <a href="{{ route('shop.index', ['category_id' => $category->id]) }}" class="card text-white border-0 h-100 overflow-hidden shadow-sm" style="min-height: 300px;">
                            <div class="position-absolute inset-0 bg-dark opacity-20 z-1"></div>
                            <img src="{{ asset('images/' . ($category->image ?: 'collection-item.jpg')) }}" class="card-img h-100 object-fit-cover transition-all" alt="{{ $category->name }}">
                            <div class="card-img-overlay d-flex flex-column justify-content-end p-4 z-2">
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill mb-2 w-fit px-3 py-2 fw-bold small text-uppercase letter-spacing-1">Collection</span>
                                <h3 class="card-title fw-bold display-6 mb-1">{{ $category->name }}</h3>
                                <p class="card-text opacity-90 small">{{ $category->products_count }} Products Available</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Intro Banner -->
    <section class="py-5 bg-light reveal-section">
        <div class="container text-center py-4">
            <h3 class="playfair fs-2 mb-4 mx-auto" style="max-width: 800px;">"Inspired by whispers of the past, Lilly's Nook curates enchanting outfits that spark wonder in the hearts of curious girls."</h3>
            <div class="d-flex justify-content-center flex-wrap gap-2">
                @foreach (['Baby girl', '2-3 Years', '3-4 Years', '4-5 Years', '5-6 Years', '6-7 Years'] as $age)
                    <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 border fw-medium">{{ $age }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-5 reveal-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-0">Featured Pieces</h2>
                <p class="text-muted fs-5">Handpicked highlights from our latest collection</p>
            </div>

            <div class="row g-4">
                @foreach ($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 group border-0 bg-transparent">
                            <div class="position-relative overflow-hidden rounded-4 mb-3 border shadow-sm">
                                <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}" class="card-img-top object-fit-cover vh-40 transition-all group-hover-scale" alt="{{ $product->name }}">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-white text-primary border-primary-subtle rounded-pill small px-3 py-2 text-uppercase fw-bold shadow-sm">New</span>
                                </div>
                                <div class="position-absolute bottom-0 start-0 w-100 p-3 translate-y-100 group-hover-translate-y-0 transition-all">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-white w-100 rounded-pill shadow-sm py-2 fw-bold border">Quick View</a>
                                </div>
                            </div>
                            <div class="card-body p-0 text-center">
                                <h5 class="card-title text-dark fw-bold mb-1 h6 text-truncate mx-auto" style="max-width: 90%;">
                                    <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none transition-all hover-primary">{{ $product->name }}</a>
                                </h5>
                                <p class="card-text text-primary fw-bold h5">&#8377;{{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 velvet-bg reveal-section overflow-hidden">
        <img src="{{ asset('images/flower-1.svg') }}" alt="" class="flower flower-1" style="width: 100px;">
        <img src="{{ asset('images/flower-2.svg') }}" alt="" class="flower flower-2" style="width: 80px;">
        
        <div class="container position-relative z-2">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-white mb-2">Loved by Mothers</h2>
                <p class="opacity-75 fs-5">Real words from our wonderful community</p>
            </div>

            <div class="testimonial-row-mask">
                <div class="testimonial-row-track">
                    @foreach ($testimonialItems->concat($testimonialItems) as $testimonial)
                        <div class="bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-20 rounded-4 p-4 shadow-sm" style="width: 350px;">
                            <div class="text-warning mb-3">
                                @for($i=0; $i<$testimonial['rating']; $i++)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                @endfor
                            </div>
                            <p class="text-white font-italic fs-5 mb-4">"{{ $testimonial['quote'] }}"</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                    {{ substr($testimonial['name'], 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-0">{{ $testimonial['name'] }}</h6>
                                    <small class="text-white opacity-60 text-uppercase letter-spacing-1">{{ $testimonial['role'] }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us -->
    <section class="py-5 reveal-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <h2 class="display-4 fw-bold mb-4">Why choose Lilly's Nook?</h2>
                    <p class="text-muted fs-5 mb-4">We believe dressing up should be as delightful as childhood itself.</p>
                    <a href="{{ route('about') }}" class="btn btn-primary rounded-pill px-5 py-3 shadow">Our Full Story</a>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-primary rounded-4">
                                <h4 class="fw-bold mb-2">Handpicked Design</h4>
                                <p class="text-muted small mb-0">Curated pieces that celebrate wonder, playfulness, and individual personality.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-success rounded-4">
                                <h4 class="fw-bold mb-2">Timeless Style</h4>
                                <p class="text-muted small mb-0">Vintage-inspired silhouettes reimagined for modern little trendsetters.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-warning rounded-4">
                                <h4 class="fw-bold mb-2">Artisan Quality</h4>
                                <p class="text-muted small mb-0">Soft, premium fabrics and thoughtful finishes built for comfort and durability.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-danger rounded-4">
                                <h4 class="fw-bold mb-2">Made with Love</h4>
                                <p class="text-muted small mb-0">Every collection is selected to keep childhood style magical and effortless.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function() {
            // Re-initialize intersection observer for reveal sections
            const sections = document.querySelectorAll('.reveal-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.15 });
            sections.forEach(s => observer.observe(s));
            
            // Scrolled navbar effect
            window.addEventListener('scroll', () => {
                const nav = document.querySelector('.sticky-top');
                if (window.scrollY > 50) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }
            });
        })();
    </script>
@endpush
