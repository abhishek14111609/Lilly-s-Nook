@extends('layouts.app')

@section('title', "Lilly's Nook - Boutique Clothing")

@section('content')
    @php
        $defaultSliders = [
            [
                'title' => "Welcome to Lilly's Nook",
                'subtitle' =>
                    'Discover our curated collection of premium clothing, now with a seamless shopping experience.',
                'button_text' => 'Shop now',
                'button_url' => route('shop.index'),
                'image' => 'banner1.jpg',
            ],
            [
                'title' => 'Elevate Your Style',
                'subtitle' => 'Browse our latest arrivals and find the perfect outfit for any occasion.',
                'button_text' => 'Shop now',
                'button_url' => route('shop.index'),
                'image' => 'banner2.jpg',
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
            'kicker' => "About Lilly's Nook",
            'title' => 'Elegant fashion, crafted to make every day feel special',
            'description' =>
                "Lilly's Nook blends modern silhouettes with timeless charm. We design thoughtfully, source quality fabrics, and focus on comfort so every piece looks graceful and feels effortless.",
        ];

        $whyChooseUs = !empty($whyChooseUs)
            ? $whyChooseUs
            : [
                [
                    'title' => 'Premium Fabrics',
                    'description' => 'Soft-touch, long-lasting materials selected for comfort and confidence.',
                    'icon' => 'icon icon-check-circle',
                ],
                [
                    'title' => 'Curated Collections',
                    'description' => 'Timeless silhouettes and modern trends chosen for versatile styling.',
                    'icon' => 'icon icon-star',
                ],
                [
                    'title' => 'Trusted Service',
                    'description' => 'Secure checkout, responsive support, and smooth order tracking.',
                    'icon' => 'icon icon-user',
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

    <section class="home-about-mini reveal-section">
        <div class="container">
            <div class="home-about-grid">
                <div class="home-about-copy">
                    <span class="home-kicker">{{ $aboutContent['kicker'] }}</span>
                    <h2>{{ $aboutContent['title'] }}</h2>
                    <p>
                        {{ $aboutContent['description'] }}
                    </p>
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
                    <div class="product-item col-lg-3 col-md-6 col-sm-6">
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
    <style>
        html,
        body {
            overflow-x: clip;
        }

        :root {
            --lilly-rose: #ba6d7f;
            --lilly-rose-soft: #efd5dc;
            --lilly-mocha: #754c3a;
            --lilly-ivory: #fff8f4;
        }

        .homepage-hero-wrap {
            position: relative;
        }

        .homepage-hero-wrap::after {
            content: '';
            position: absolute;
            inset: auto 0 0;
            height: 120px;
            background: linear-gradient(to top, #fff 5%, transparent 100%);
            pointer-events: none;
            z-index: 2;
        }

        .home-kicker {
            display: inline-block;
            font-size: 13px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: #b57f5f;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .home-about-mini {
            padding: 92px 0 32px;
        }

        .home-about-grid {
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            gap: 28px;
            align-items: stretch;
        }

        .home-about-copy,
        .home-about-highlight {
            background: linear-gradient(145deg, #ffffff, #fffaf6);
            border: 1px solid rgba(181, 127, 95, 0.18);
            border-radius: 22px;
            padding: 36px;
            box-shadow: 0 18px 38px rgba(122, 74, 47, 0.08);
        }

        .home-about-copy h2 {
            font-size: clamp(28px, 3.3vw, 42px);
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .home-about-copy p {
            color: #5f4c42;
            font-size: 16px;
            line-height: 1.75;
        }

        .highlight-label {
            display: inline-block;
            font-weight: 600;
            color: #8a5a3f;
            margin-bottom: 18px;
        }

        .home-about-highlight ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 18px;
        }

        .home-about-highlight li {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .home-about-highlight i {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f7e8dd;
            color: #8f593d;
            margin-top: 2px;
        }

        .home-about-highlight h4 {
            margin-bottom: 4px;
            font-size: 18px;
        }

        .home-about-highlight p {
            margin: 0;
            color: #6c584d;
            line-height: 1.55;
            font-size: 14px;
        }

        .home-categories {
            padding: 48px 0 84px;
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        .home-categories .container {
            padding-left: clamp(16px, 2.2vw, 28px);
            padding-right: clamp(16px, 2.2vw, 28px);
        }

        .home-categories::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: radial-gradient(circle at 10% 10%, rgba(252, 233, 219, 0.55), transparent 50%), radial-gradient(circle at 90% 90%, rgba(251, 242, 232, 0.7), transparent 55%);
            z-index: -1;
        }

        .home-categories::after {
            display: none;
        }

        .section-flower {
            position: absolute;
            right: -26px;
            bottom: -42px;
            width: clamp(170px, 20vw, 290px);
            opacity: 0.9;
            pointer-events: none;
            z-index: -1;
            animation: flowerFloat 7s ease-in-out infinite;
        }

        @keyframes flowerFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .home-categories-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 20px;
        }

        .home-category-card {
            grid-column: span 4;
            border-radius: 20px;
            padding: 26px;
            background: #fff;
            border: 1px solid rgba(173, 120, 88, 0.2);
            box-shadow: 0 8px 22px rgba(125, 80, 56, 0.08);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .home-category-card:focus-visible {
            outline: 3px solid rgba(186, 109, 127, 0.55);
            outline-offset: 2px;
        }

        .home-category-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--card-bg-image) center / cover no-repeat;
            transform: scale(1.02);
            transition: transform .55s ease;
            z-index: 0;
        }

        .home-category-card>* {
            position: relative;
            z-index: 2;
        }

        .home-category-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(150deg, rgba(255, 248, 244, 0.58), rgba(255, 248, 244, 0.3) 32%, rgba(50, 31, 20, 0.7));
            transition: transform .35s ease;
            z-index: 1;
        }

        .home-category-card.layout-hero-left,
        .home-category-card.layout-hero-right {
            min-height: 230px;
            justify-content: flex-end;
            color: #fff;
        }

        .home-category-card.layout-hero-left {
            grid-column: span 7;
            background: linear-gradient(130deg, rgba(58, 37, 33, 0.96), rgba(99, 61, 72, 0.9));
        }

        .home-category-card.layout-hero-right {
            grid-column: span 5;
            background: linear-gradient(130deg, rgba(71, 40, 29, 0.96), rgba(123, 74, 52, 0.92));
        }

        .home-category-card.layout-hero-left::after,
        .home-category-card.layout-hero-right::after {
            background: linear-gradient(140deg, rgba(26, 16, 14, 0.18), rgba(36, 21, 16, 0.74) 58%, rgba(26, 16, 14, 0.88));
        }

        .home-category-card.layout-small-a,
        .home-category-card.layout-small-b,
        .home-category-card.layout-small-c,
        .home-category-card.layout-small-d {
            min-height: 180px;
        }

        .home-category-card.layout-hero-left h3,
        .home-category-card.layout-hero-right h3,
        .home-category-card.layout-hero-left p,
        .home-category-card.layout-hero-right p,
        .home-category-card.layout-hero-left .home-category-link,
        .home-category-card.layout-hero-right .home-category-link {
            color: #fff;
        }

        .home-category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 34px rgba(125, 80, 56, 0.16);
            border-color: rgba(143, 89, 61, 0.48);
        }

        .home-category-card:hover::before {
            transform: scale(1.08);
        }

        .home-category-card:hover::after {
            transform: scale(1.02);
        }

        .home-category-badge {
            min-width: 124px;
            width: fit-content;
            height: 34px;
            border-radius: 999px;
            background: rgba(186, 109, 127, 0.14);
            color: var(--lilly-mocha);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 0 14px;
        }

        .home-category-card.layout-hero-left .home-category-badge,
        .home-category-card.layout-hero-right .home-category-badge {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .home-category-card h3 {
            margin: 0 0 4px;
            color: #20120b;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.32);
        }

        .home-category-card p {
            margin: 0;
            color: #4f372b;
            font-size: 14px;
        }

        .home-category-link {
            color: #7c452f;
            font-weight: 600;
            font-size: 14px;
            margin-top: auto;
        }

        .home-subcategories {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 4px;
        }

        .home-subcategory-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 12px;
            text-decoration: none;
            color: #4f2f21;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(122, 79, 58, 0.18);
            transition: all .25s ease;
        }

        .home-subcategory-pill span {
            min-width: 16px;
            height: 16px;
            line-height: 16px;
            border-radius: 50%;
            text-align: center;
            font-size: 10px;
            background: rgba(124, 69, 47, 0.12);
        }

        .home-subcategory-pill:hover {
            transform: translateY(-2px);
            background: #fff;
            border-color: rgba(122, 79, 58, 0.34);
        }

        .home-category-card.layout-hero-left .home-subcategory-pill,
        .home-category-card.layout-hero-right .home-subcategory-pill {
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.24);
        }

        .home-category-card.layout-hero-left .home-subcategory-pill span,
        .home-category-card.layout-hero-right .home-subcategory-pill span {
            background: rgba(255, 255, 255, 0.18);
        }

        .home-empty-state {
            grid-column: 1/-1;
            background: #fff;
            border: 1px dashed #d7bcaa;
            border-radius: 16px;
            padding: 20px;
            color: #6c574b;
            text-align: center;
        }

        .home-testimonials {
            padding: 88px 0 92px;
            background: linear-gradient(170deg, #2d1f23, #5a3643);
            color: #fff;
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .home-testimonials::before {
            content: '';
            position: absolute;
            inset: -80px;
            background: radial-gradient(circle at 20% 20%, rgba(233, 181, 144, 0.25), transparent 38%), radial-gradient(circle at 75% 80%, rgba(225, 149, 102, 0.2), transparent 34%);
            pointer-events: none;
        }

        .home-testimonials::after {
            display: none;
        }

        .section-flower-testimonials {
            bottom: -28px;
            right: -22px;
            opacity: 0.92;
        }

        .home-testimonials .section-title,
        .home-testimonials .section-subtitle {
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .home-testimonials .section-subtitle {
            margin-top: 8px;
            margin-bottom: 34px;
            color: rgba(255, 255, 255, 0.78);
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 22px;
            width: min(360px, 78vw);
            flex: 0 0 auto;
            text-align: left;
        }

        .testimonial-row-mask {
            overflow: hidden;
            position: relative;
            z-index: 1;
            mask-image: linear-gradient(to right, transparent, #000 8%, #000 92%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, #000 8%, #000 92%, transparent);
        }

        .testimonial-row-mask-reverse {
            margin-top: 12px;
        }

        .testimonial-row-track {
            display: flex;
            gap: 14px;
            width: max-content;
            animation: testimonials-scroll 24s linear infinite;
            padding: 6px 0;
        }

        .testimonial-row-track-reverse {
            animation-direction: reverse;
            animation-duration: 27s;
        }

        .testimonial-row-mask:hover .testimonial-row-track {
            animation-play-state: paused;
        }

        @keyframes testimonials-scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .testimonial-stars {
            color: #ffd69e;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .testimonial-card blockquote {
            margin: 0;
            font-size: clamp(15px, 1.2vw, 18px);
            line-height: 1.55;
            font-style: italic;
        }

        .testimonial-author {
            margin-top: 14px;
        }

        .testimonial-author h4 {
            margin: 0;
            color: #ffe1ca;
            font-size: 17px;
        }

        .testimonial-author span {
            display: block;
            margin-top: 5px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 13px;
            letter-spacing: 0.7px;
            text-transform: uppercase;
        }

        .reveal-section {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 991px) {
            .home-about-grid {
                grid-template-columns: 1fr;
            }

            .home-categories-grid {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }

            .section-flower {
                width: clamp(130px, 26vw, 220px);
                right: -18px;
            }

            .home-category-card,
            .home-category-card.layout-hero-left,
            .home-category-card.layout-hero-right {
                grid-column: span 3;
            }
        }

        @media (max-width: 575px) {

            .home-about-copy,
            .home-about-highlight {
                padding: 26px;
            }

            .home-categories-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .home-category-card,
            .home-category-card.layout-hero-left,
            .home-category-card.layout-hero-right {
                grid-column: span 1;
                min-height: auto;
            }

            .section-flower {
                width: 150px;
                right: -10px;
                bottom: -24px;
            }

            .testimonial-card {
                padding: 24px 18px;
            }

            .testimonial-row-track {
                animation-duration: 20s;
            }
        }
    </style>
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
