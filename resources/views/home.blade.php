@extends('layouts.app')

@section('title', "Lilly's Nook - Boutique Clothing")

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
            [
                'title' => 'Dressing dreams in vintage flair',
                'subtitle' => 'Dreamy looks inspired by vintage elegance, made for modern little stars.',
                'button_text' => 'Shop now',
                'button_url' => route('shop.index'),
                'image' => 'banner3.jpg',
            ],
        ];

        $defaultTestimonials = collect([
            [
                'name' => 'Ananya Mehta',
                'role' => 'Fashion Blogger',
                'quote' =>
                    "Lilly's Nook always gets my style right. Premium quality, beautiful stitching, and delivery that never disappoints.",
                'rating' => 5,
            ],
            [
                'name' => 'Rhea Sharma',
                'role' => 'Repeat Customer',
                'quote' =>
                    'The fit, the colors, and the fabric quality are amazing. Every order feels thoughtfully curated.',
                'rating' => 5,
            ],
            [
                'name' => 'Nisha Arora',
                'role' => 'Stylist',
                'quote' =>
                    "I recommend Lilly's Nook to my clients for statement pieces that still feel wearable and elegant every day.",
                'rating' => 5,
            ],
        ]);

        $sliderItems = isset($sliders) && $sliders->isNotEmpty() ? $sliders : collect($defaultSliders);
        $testimonialItems = isset($testimonials) && $testimonials->isNotEmpty() ? $testimonials : $defaultTestimonials;

        $aboutContent = $aboutContent ?? [
            'kicker' => "Welcome to Lilly's Nook",
            'title' => "Where yesterday's charm meets today's little star",
            'description' =>
                "Inspired by whispers of the past, Lilly's Nook curates enchanting outfits that spark wonder in the hearts of curious, stylish girls.",
            'story_title' => 'Our Story',
            'collections_title' => 'Shop Our Timeless Collections',
            'collections_items' => [
                'Whimsical New Arrivals',
                'Bestselling Classics',
                'Occasion Dresses with a Vintage Twist',
            ],
        ];

        $homeIntroText =
            $homeIntroText ??
            "Step into the enchanting world of Lily's Nook, where delicate lace, soft pastels, and timeless silhouettes come together in a celebration of childhood whimsy. Our carefully crafted collections evoke the elegance of a bygone era, with a playful twist that perfectly captures the spirit of little girls who light up the world.";

        $homeAgeGroups = !empty($homeAgeGroups)
            ? $homeAgeGroups
            : ['2-3 years', '3-4 years', '4-5 years', '5-6 years', '6-7 years'];

        $whyChooseUs = !empty($whyChooseUs)
            ? $whyChooseUs
            : [
                [
                    'title' => 'Handpicked designs that spark joy',
                    'description' => 'Curated pieces that celebrate wonder, playfulness, and personality.',
                    'icon' => 'icon icon-check-circle',
                ],
                [
                    'title' => 'Timeless elegance with a whimsical twist',
                    'description' => 'Vintage-inspired silhouettes made for modern little trendsetters.',
                    'icon' => 'icon icon-star',
                ],
                [
                    'title' => 'Quality craftsmanship for little treasures',
                    'description' => 'Soft fabrics and thoughtful finishing built for comfort and durability.',
                    'icon' => 'icon icon-user',
                ],
                [
                    'title' => 'Curated with love, for the little ones',
                    'description' => 'Every collection is selected to keep childhood style magical and effortless.',
                    'icon' => 'icon icon-heart',
                ],
            ];
    @endphp

    <section id="billboard" class="overflow-hidden homepage-hero-wrap">
        <button class="button-prev"><i class="icon icon-chevron-left"></i></button>
        <button class="button-next"><i class="icon icon-chevron-right"></i></button>
        <div class="swiper main-swiper">
            <div class="swiper-wrapper">
                @foreach ($sliderItems as $slide)
                    <div class="swiper-slide"
                        style="background-image: url('{{ asset('images/' . data_get($slide, 'image')) }}'); background-repeat:no-repeat; background-size:cover; background-position:center;">
                        <div class="banner-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2 class="banner-title">{{ data_get($slide, 'title') }}</h2>
                                        <p>{{ data_get($slide, 'subtitle') }}</p>
                                        <div class="btn-wrap">
                                            <a href="{{ data_get($slide, 'button_url') ?: route('shop.index') }}"
                                                class="btn btn-light btn-medium d-flex align-items-center">{{ data_get($slide, 'button_text') ?: 'Explore' }}
                                                <i class="icon icon-arrow-io"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>





    <section id="home-categories" class="home-categories reveal-section">
        <img src="{{ asset('images/floral-corner-soft.svg') }}" alt="" aria-hidden="true"
            class="section-flower section-flower-categories">
        <div class="container">
            <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                <h2 class="section-title">Shop by Category</h2>
                <div class="btn-wrap"><a href="{{ route('shop.index') }}" class="d-flex align-items-center">Explore all
                        categories <i class="icon icon-arrow-io"></i></a></div>
            </div>
            <div class="home-categories-grid">
                @forelse ($categories as $category)
                    @php
                        $categoryLayout = match ($loop->index) {
                            0 => 'layout-hero-left',
                            1 => 'layout-hero-right',
                            2 => 'layout-small-a',
                            3 => 'layout-small-b',
                            4 => 'layout-small-c',
                            default => 'layout-small-d',
                        };
                        $bgImage = !empty($category->image) ? $category->image : 'collection-item.jpg';
                        $subcategories = $category->children;
                        $totalProducts = (int) $category->products_count + (int) $subcategories->sum('products_count');
                    @endphp
                    <article class="home-category-card {{ $categoryLayout }}"
                        data-category-url="{{ route('shop.index', ['category_id' => $category->id]) }}" role="link"
                        tabindex="0" style="--card-bg-image: url('{{ asset('images/' . $bgImage) }}');">
                        <div class="home-category-badge">Collection
                            {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <div>
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $totalProducts }}
                                {{ \Illuminate\Support\Str::plural('product', $totalProducts) }}</p>
                        </div>
                        @if ($subcategories->isNotEmpty())
                            <div class="home-subcategories">
                                @foreach ($subcategories as $child)
                                    <a href="{{ route('shop.index', ['category_id' => $child->id]) }}"
                                        class="home-subcategory-pill">
                                        {{ $child->name }}
                                        <span>{{ $child->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        <span class="home-category-link">Explore Collection <i class="icon icon-arrow-io"></i></span>
                    </article>
                @empty
                    <div class="home-empty-state">No categories found yet. Add categories from admin to feature them here.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <section class="home-intro-strip reveal-section">
        <div class="container">
            <p>{{ $homeIntroText }}</p>
            <div class="home-age-groups" aria-label="Age groups">
                @foreach ($homeAgeGroups as $ageGroup)
                    <span class="home-age-pill">{{ $ageGroup }}</span>
                @endforeach
            </div>
        </div>
    </section>
    <section class="home-about-mini reveal-section">
        <div class="container">
            <div class="home-about-grid">
                <div class="home-about-copy">
                    <span class="home-kicker">{{ $aboutContent['kicker'] }}</span>
                    <h2>{{ $aboutContent['title'] }}</h2>
                    <h3 class="home-story-title">{{ $aboutContent['story_title'] ?? 'Our Story' }}</h3>
                    <p>{{ $aboutContent['description'] }}</p>

                    <div class="home-collections-block">
                        <h4>{{ $aboutContent['collections_title'] ?? 'Shop Our Timeless Collections' }}</h4>
                        <ul>
                            @foreach ($aboutContent['collections_items'] ?? [] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="home-about-highlight">
                    <span class="highlight-label">Why Choose Us</span>
                    <ul>
                        @foreach ($whyChooseUs as $point)
                            <li>
                                <i class="{{ $point['icon'] }}"></i>
                                <div>
                                    <h4>{{ $point['title'] }}</h4>
                                    <p>{{ $point['description'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="featured-products" class="product-store padding-large reveal-section">
        <div class="container">
            <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                <h2 class="section-title">Featured Products</h2>
                <div class="btn-wrap"><a href="{{ route('shop.index') }}" class="d-flex align-items-center">View all
                        products <i class="icon icon-arrow-io"></i></a></div>
            </div>
            <div class="row d-flex flex-wrap">
                @foreach ($featuredProducts as $product)
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
                @endforeach
            </div>
        </div>
    </section>

    <section id="home-testimonials" class="home-testimonials reveal-section">
        <img src="{{ asset('images/floral-corner-cream.svg') }}" alt="" aria-hidden="true"
            class="section-flower section-flower-testimonials">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Loved by Our Clients</h2>
                <p class="section-subtitle">Real words from women who shop with Lilly's Nook</p>
            </div>

            <div class="testimonial-row-mask">
                <div class="testimonial-row-track">
                    @foreach ($testimonialItems->concat($testimonialItems) as $testimonial)
                        <article class="testimonial-card">
                            <div class="testimonial-stars">
                                @for ($i = 0; $i < (int) data_get($testimonial, 'rating', 5); $i++)
                                    <i class="icon icon-star"></i>
                                @endfor
                            </div>
                            <blockquote>{{ data_get($testimonial, 'quote') }}</blockquote>
                            <div class="testimonial-author">
                                <h4>{{ data_get($testimonial, 'name') }}</h4>
                                <span>{{ data_get($testimonial, 'role') }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="testimonial-row-mask testimonial-row-mask-reverse">
                <div class="testimonial-row-track testimonial-row-track-reverse">
                    @foreach ($testimonialItems->reverse()->values()->concat($testimonialItems->reverse()->values()) as $testimonial)
                        <article class="testimonial-card">
                            <div class="testimonial-stars">
                                @for ($i = 0; $i < (int) data_get($testimonial, 'rating', 5); $i++)
                                    <i class="icon icon-star"></i>
                                @endfor
                            </div>
                            <blockquote>{{ data_get($testimonial, 'quote') }}</blockquote>
                            <div class="testimonial-author">
                                <h4>{{ data_get($testimonial, 'name') }}</h4>
                                <span>{{ data_get($testimonial, 'role') }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/home.css') }}">
@endpush

@push('scripts')
    <script>
        (function() {
            const sections = document.querySelectorAll('.reveal-section');

            if (!sections.length || !('IntersectionObserver' in window)) {
                sections.forEach((section) => section.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2,
                rootMargin: '0px 0px -40px 0px'
            });

            sections.forEach((section) => observer.observe(section));
        })();

        (function() {
            const cards = document.querySelectorAll('.home-category-card');

            cards.forEach((card) => {
                card.addEventListener('click', (event) => {
                    if (event.target.closest('a')) {
                        return;
                    }

                    const url = card.getAttribute('data-category-url');
                    if (url) {
                        window.location.href = url;
                    }
                });

                card.addEventListener('keydown', (event) => {
                    if (event.key !== 'Enter' && event.key !== ' ') {
                        return;
                    }

                    event.preventDefault();

                    const url = card.getAttribute('data-category-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        })();
    </script>
@endpush
