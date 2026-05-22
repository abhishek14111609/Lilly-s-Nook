@extends('layouts.app')

@section('title', "Lily's Nook - Timeless Boutique for Little Stars")

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        .hero-slide {
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        .hero-slide::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(7, 10, 19, 0.36) 0%, rgba(7, 10, 19, 0.18) 40%, rgba(7, 10, 19, 0.03) 100%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.06) 0%, rgba(7, 10, 19, 0.08) 100%);
            z-index: 1;
        }

        .hero-slide.video-slide::before {
            background:
                linear-gradient(90deg, rgba(7, 10, 19, 0.4) 0%, rgba(7, 10, 19, 0.2) 40%, rgba(7, 10, 19, 0.04) 100%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.04) 0%, rgba(7, 10, 19, 0.1) 100%);
        }

        .hero-slide-media {
            filter: brightness(0.92) saturate(0.98);
            transform: scale(1.02);
        }

        .hero-slide-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .hero-slide-panel {
            display: inline-block;
            padding: 1.4rem 1.55rem;
            border-radius: 1.75rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.78));
            border: 1px solid rgba(255, 255, 255, 0.45);
            box-shadow: 0 18px 55px rgba(15, 23, 42, 0.12);
            backdrop-filter: blur(8px);
        }

        .hero-slide-kicker {
            color: #7a3f57;
            letter-spacing: 0.16em;
            font-size: 0.72rem;
        }

        .hero-slide-title {
            color: #18212f;
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.04em;
            text-shadow: none;
            margin-bottom: 1rem;
        }

        .hero-slide-subtitle {
            color: #3f4b5b;
            font-size: 1.15rem;
            line-height: 1.65;
            text-shadow: none;
        }

        .hero-slide .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
            box-shadow: 0 0.85rem 1.8rem rgba(244, 143, 177, 0.28);
        }

        .hero-slide .btn-primary:hover {
            background: #ef79a5;
            border-color: #ef79a5;
            color: #fff;
        }

        @media (max-width: 991.98px) {
            .hero-slide::before {
                background:
                    linear-gradient(180deg, rgba(7, 10, 19, 0.22) 0%, rgba(7, 10, 19, 0.1) 100%),
                    linear-gradient(180deg, rgba(255, 255, 255, 0.04) 0%, rgba(7, 10, 19, 0.08) 100%);
            }

            .hero-slide-content {
                max-width: 100%;
            }

            .hero-slide-panel {
                padding: 1.1rem 1.15rem;
                border-radius: 1.5rem;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.94), rgba(255, 255, 255, 0.86));
            }

            .hero-slide-title {
                font-size: clamp(2.2rem, 7vw, 3.4rem);
            }

            .hero-slide-subtitle {
                font-size: 1rem;
            }

            .hero-slide .btn,
            .hero-slide .btn-primary {
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {
            .hero-slide-panel {
                padding: 1rem;
                border-radius: 1.25rem;
            }

            .hero-slide-kicker {
                letter-spacing: 0.12em;
                font-size: 0.68rem;
            }

            .hero-slide-title {
                font-size: clamp(1.9rem, 10vw, 2.7rem);
            }

            .hero-slide-subtitle {
                font-size: 0.95rem;
                line-height: 1.55;
            }
        }

        .showcase-video-section {
            position: relative;
            isolation: isolate;
            background: #ffffff;
        }

        .showcase-video-section::before {
            display: none;
        }

        .showcase-stage {
            position: relative;
            z-index: 1;
            border-radius: 2.25rem;
            padding: 1.75rem;
            border: 1px solid rgba(255, 214, 226, 0.2);
            background: linear-gradient(180deg, rgba(32, 22, 38, 0.9), rgba(24, 17, 31, 0.84));
            box-shadow:
                0 40px 90px rgba(15, 8, 20, 0.42),
                inset 0 1px 0 rgba(255, 240, 247, 0.08);
            overflow: hidden;
        }

        .showcase-stage::before {
            content: '';
            position: absolute;
            inset: 1rem;
            border-radius: 1.8rem;
            border: 1px solid rgba(255, 221, 232, 0.08);
            pointer-events: none;
        }

        .showcase-stage-cards {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            padding: 0.5rem 0 0;
        }

        .showcase-stage-caption {
            text-align: center;
            color: #fff;
        }

        .showcase-stage-controls {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            margin-top: 0.85rem;
        }

        .showcase-stage-control {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 1px solid rgba(255, 226, 236, 0.35);
            background: linear-gradient(180deg, rgba(255, 231, 240, 0.16), rgba(255, 231, 240, 0.08));
            color: #fff7fa;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        }

        .showcase-stage-control:hover {
            transform: translateY(-1px);
            background: linear-gradient(180deg, rgba(255, 233, 241, 0.24), rgba(255, 233, 241, 0.13));
            border-color: rgba(255, 231, 240, 0.55);
        }

        .showcase-stage-control:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
        }

        .showcase-stage-caption .showcase-video-chip {
            background: rgba(255, 232, 240, 0.12);
            border-color: rgba(255, 226, 236, 0.22);
            color: #fff3f8;
            box-shadow: inset 0 1px 0 rgba(255, 240, 246, 0.12);
        }

        .showcase-stage-dots {
            display: inline-flex;
            align-items: center;
            min-width: 96px;
            justify-content: center;
        }

        .showcase-stage-dots .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background: rgba(255, 229, 238, 0.45);
            opacity: 1;
            transition: all 0.45s ease;
        }

        .showcase-stage-dots .swiper-pagination-bullet-active {
            width: 24px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(244, 143, 177, 0.95), rgba(255, 219, 190, 0.95));
            box-shadow: 0 0 16px rgba(244, 143, 177, 0.55);
        }

        .showcase-swiper {
            width: 100%;
            padding: 0.4rem 0 1.2rem;
            overflow: visible;
        }

        .showcase-swiper .swiper-wrapper {
            align-items: center;
            transition-timing-function: cubic-bezier(0.22, 0.65, 0.2, 1);
            will-change: transform;
        }

        .showcase-swiper .swiper-slide {
            width: clamp(260px, 56vw, 420px);
            opacity: 0.48;
            transition: opacity 0.7s ease;
        }

        .showcase-swiper .swiper-slide .showcase-card {
            transform: scale(0.86);
            filter: blur(0.8px);
            opacity: 0.75;
            transition: transform 0.95s cubic-bezier(0.22, 0.65, 0.2, 1), filter 0.95s ease,
                opacity 0.95s ease, box-shadow 0.95s ease;
        }

        .showcase-swiper .swiper-slide .showcase-card:hover {
            transform: scale(0.84) rotateX(1.2deg) rotateY(-1.2deg);
        }

        .showcase-swiper .swiper-slide-prev .showcase-card,
        .showcase-swiper .swiper-slide-next .showcase-card {
            transform: scale(0.93);
            filter: blur(0.35px);
            opacity: 0.9;
        }

        .showcase-swiper .swiper-slide-active {
            opacity: 1;
        }

        .showcase-swiper .swiper-slide-active .showcase-card {
            transform: scale(1);
            filter: none;
            opacity: 1;
            box-shadow:
                0 35px 90px rgba(20, 10, 25, 0.48),
                0 0 0 1px rgba(244, 143, 177, 0.3),
                0 0 74px rgba(244, 143, 177, 0.36);
        }

        .showcase-swiper .swiper-slide-active .showcase-card:hover {
            transform: scale(1.02) rotateX(1deg) rotateY(-1deg);
        }

        .showcase-swiper .swiper-slide-active .showcase-card-media {
            animation: showcaseFloat 6.5s ease-in-out infinite;
        }

        @keyframes showcaseFloat {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-6px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .showcase-card {
            position: relative;
            border-radius: 1.9rem;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(31, 21, 38, 0.96), rgba(23, 17, 30, 0.96));
            border: 1px solid rgba(16, 24, 32, 0.06);
            box-shadow: 0 14px 30px rgba(18, 25, 30, 0.08), 0 4px 12px rgba(18, 25, 30, 0.06);
            transition: box-shadow 0.28s ease, transform 0.28s ease;
            will-change: transform, opacity, filter;
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        .showcase-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(0, 0, 0, 0.26));
            z-index: 1;
            pointer-events: none;
        }

        .showcase-card-media {
            position: relative;
            aspect-ratio: 9 / 16;
            min-height: 360px;
            overflow: hidden;
            background: linear-gradient(180deg, #2d1f37 0%, #1c1424 100%);
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        .showcase-card-media video,
        .showcase-card-media img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            display: block;
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        @media (prefers-reduced-motion: reduce) {
            .showcase-swiper .swiper-slide-active .showcase-card-media {
                animation: none !important;
            }
        }

        .showcase-card-badge {
            position: absolute;
            left: 1rem;
            top: 1rem;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            color: #effcff;
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
        }

        .showcase-card-glow {
            position: absolute;
            inset: auto 10% 1rem 10%;
            z-index: 2;
            padding: 0.95rem 1rem;
            border-radius: 1.15rem;
            color: #fff;
            background: linear-gradient(180deg, rgba(10, 20, 24, 0.08), rgba(8, 16, 19, 0.92));
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .showcase-card-glow .showcase-video-chip {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.08);
            color: #f3fbfc;
        }

        .showcase-card-footer {
            position: relative;
            z-index: 2;
            padding: 0.95rem 1rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0));
            color: rgba(255, 255, 255, 0.88);
        }

        .showcase-card-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: #f4c9a0;
            box-shadow: 0 0 0 7px rgba(244, 201, 160, 0.2);
            flex-shrink: 0;
        }

        .showcase-card-empty {
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            text-align: center;
            background:
                radial-gradient(circle at 50% 35%, rgba(244, 143, 177, 0.22), transparent 30%),
                rgba(29, 18, 33, 0.9);
        }

        .showcase-card-empty-inner {
            max-width: 240px;
            padding: 1.15rem;
            border-radius: 1.15rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px dashed rgba(255, 255, 255, 0.14);
            color: #f7fbfc;
        }

        .showcase-video-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 0.85rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(17, 24, 39, 0.08);
            color: #1f2937;
            font-size: 0.84rem;
            font-weight: 600;
        }

        @media (max-width: 991.98px) {
            .showcase-stage {
                padding: 1.35rem;
                border-radius: 1.75rem;
            }

            .showcase-card-media,
            .showcase-card-featured .showcase-card-media {
                min-height: 380px;
                aspect-ratio: 9 / 16;
            }

            .showcase-swiper .swiper-slide {
                width: clamp(240px, 72vw, 380px);
            }
        }

        @media (max-width: 575.98px) {
            .showcase-stage {
                padding: 1rem;
            }

            .showcase-stage-controls {
                gap: 0.45rem;
            }

            .showcase-stage-dots {
                min-width: 76px;
            }

            .showcase-swiper {
                padding-bottom: 1.9rem;
            }

            .showcase-swiper .swiper-slide {
                width: 84vw;
            }

            .showcase-video-chip {
                font-size: 0.78rem;
            }

            .showcase-card-media,
            .showcase-card-featured .showcase-card-media {
                min-height: 330px;
            }

            .showcase-card-glow {
                inset: auto 0.85rem 0.85rem 0.85rem;
                padding: 0.85rem;
            }
        }
    </style>
@endpush

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

        $testimonialItems =
            isset($testimonials) && $testimonials->isNotEmpty()
                ? $testimonials
                : collect([
                    [
                        'name' => 'Ananya Mehta',
                        'role' => 'Fashion Blogger',
                        'quote' => "Lily's Nook always gets my style right. Premium quality and beautiful stitching.",
                        'rating' => 5,
                    ],
                    [
                        'name' => 'Rhea Sharma',
                        'role' => 'Repeat Customer',
                        'quote' => 'The fit and fabric quality are amazing. Every order feels thoughtfully curated.',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'Nisha Arora',
                        'role' => 'Stylist',
                        'quote' =>
                            "I recommend Lily's Nook to my clients for statement pieces that are wearable and elegant.",
                        'rating' => 5,
                    ],
                ]);

        $sliderItems = isset($sliders) && $sliders->isNotEmpty() ? $sliders : collect($defaultSliders);
    @endphp

    <!-- Hero Carousel -->
    <section id="hero" class="mb-5">
        <div id="heroCarousel" class="carousel slide carousel-fade vh-75" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
                @foreach ($sliderItems as $index => $slide)
                    <div
                        class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100 hero-slide {{ data_get($slide, 'video') ? 'video-slide' : 'image-slide' }}">
                        @if (data_get($slide, 'video'))
                            <div class="h-100 w-100 position-relative velvet-bg overflow-hidden">
                                <video autoplay loop muted playsinline
                                    class="position-absolute w-100 h-100 hero-slide-media" style="object-fit: cover;">
                                    <source src="{{ asset(ltrim(data_get($slide, 'video'), '/')) }}" type="video/mp4">
                                </video>
                                <div class="container py-4 py-lg-5 position-relative z-2 h-100 d-flex align-items-center">
                                    <div class="row align-items-center w-100">
                                        <div class="col-lg-7 hero-slide-content text-white">
                                            <div class="hero-slide-panel">
                                                <div class="hero-slide-kicker text-uppercase fw-semibold mb-3"></div>
                                                <h1 class="display-2 hero-slide-title mb-3">{{ data_get($slide, 'title') }}
                                                </h1>
                                                <p class="hero-slide-subtitle mb-4">{{ data_get($slide, 'subtitle') }}</p>
                                                <div class="d-flex gap-3 flex-wrap">
                                                    <a href="{{ data_get($slide, 'button_url') ?: route('shop.index') }}"
                                                        class="btn btn-primary px-5 py-3 rounded-pill fw-bold">
                                                        {{ data_get($slide, 'button_text') ?: 'Explore Collection' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="h-100 velvet-bg d-flex align-items-center overflow-hidden"
                                style="background-image: url('{{ asset('images/' . data_get($slide, 'image')) }}'); background-size: cover; background-position: center;">
                                <div class="container py-4 py-lg-5 position-relative z-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-7 hero-slide-content text-white">
                                            <div class="hero-slide-panel">
                                                <div class="hero-slide-kicker text-uppercase fw-semibold mb-3"></div>
                                                <h1 class="display-2 hero-slide-title mb-3">{{ data_get($slide, 'title') }}
                                                </h1>
                                                <p class="hero-slide-subtitle mb-4">{{ data_get($slide, 'subtitle') }}</p>
                                                <div class="d-flex gap-3 flex-wrap">
                                                    <a href="{{ data_get($slide, 'button_url') ?: route('shop.index') }}"
                                                        class="btn btn-primary px-5 py-3 rounded-pill fw-bold">
                                                        {{ data_get($slide, 'button_text') ?: 'Explore Collection' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
            <div class="d-flex justify-content-between align-items-end mb-4 mb-lg-5 flex-wrap gap-3">
                <div class="pe-lg-5" style="max-width: 760px;">
                    <p class="text-uppercase small fw-bold text-muted letter-spacing-1 mb-2">Collections</p>
                    <h2 class="display-5 fw-bold mb-2">Shop The Nook</h2>
                    <p class="text-muted fs-5 mb-0">Explore our curated collections through a clean, editorial-style layout
                        that stays readable on every screen.</p>
                </div>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 px-lg-5 fw-bold">View
                    All</a>
            </div>

            <div class="category-scroll-shell">
                <div class="category-scroll-viewport" id="categoryScrollViewport">
                    <div class="category-scroll-track" id="categoryScrollTrack">
                        @foreach ($categories as $category)
                            <a href="{{ route('shop.index', ['category_id' => $category->id]) }}"
                                class="category-card card border-0 h-100 text-decoration-none overflow-hidden shadow-sm">
                                <div class="category-card-media">
                                    @if ($category->video)
                                        <video autoplay loop muted playsinline class="category-card-media-item">
                                            <source src="{{ asset(ltrim($category->video, '/')) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <img src="{{ asset('images/' . ($category->image ?: 'collection-item.jpg')) }}"
                                            class="category-card-media-item" alt="{{ $category->name }}">
                                    @endif
                                </div>

                                <div class="category-card-overlay"></div>

                                <div class="category-card-content d-flex flex-column justify-content-end p-4 p-lg-5">
                                    <span
                                        class="badge bg-white text-dark rounded-pill mb-3 px-3 py-2 fw-bold small text-uppercase letter-spacing-1 shadow-sm category-chip">Collection</span>
                                    <div class="category-card-copy">
                                        <h3 class="category-card-title mb-2">{{ $category->name }}</h3>
                                        <p class="category-card-meta mb-0">
                                            <span>Explore {{ $category->products_count }} items</span>
                                            <span class="category-card-dot"></span>
                                            <span>Shop now</span>
                                        </p>
                                    </div>

                                    <div class="category-card-action mt-4">
                                        <span class="category-card-button">
                                            View collection
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14"></path>
                                                <path d="M12 5l7 7-7 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                @if ($categories->count() > 1)
                    <button type="button" class="category-scroll-btn category-scroll-btn-prev" data-category-scroll="prev"
                        aria-label="Scroll categories left">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.4">
                            <path d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button type="button" class="category-scroll-btn category-scroll-btn-next" data-category-scroll="next"
                        aria-label="Scroll categories right">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.4">
                            <path d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </section>

    <!-- Intro Banner -->
    <section class="py-5 bg-light reveal-section">
        <div class="container py-4 py-lg-5">
            <div class="mx-auto text-center" style="max-width: 920px;">
                <p class="text-uppercase small fw-bold text-muted letter-spacing-1 mb-3">Timeless childhood style</p>
                <h3 class="playfair display-6 mb-4 mx-auto lh-sm" style="max-width: 860px;">
                    {{ $homeIntroText }}
                </h3>
                <p class="text-muted fs-5 mb-4 mx-auto" style="max-width: 720px;">
                    Explore curated pieces designed for playful days, special moments, and everything in between.
                </p>

                <div class="d-flex justify-content-center flex-wrap gap-2 gap-lg-3 mb-4">
                    @foreach (collect($homeAgeGroups)->filter()->values() as $age)
                        <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 px-lg-4 py-2 border fw-semibold">
                            {{ \Illuminate\Support\Str::of($age)->lower()->replace('-', ' - ')->title() }}
                        </span>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="{{ route('shop.index') }}"
                        class="btn btn-dark rounded-pill px-4 px-lg-5 py-3 fw-bold shadow-sm">Shop Collection</a>
                    <a href="{{ route('about') }}"
                        class="btn btn-outline-dark rounded-pill px-4 px-lg-5 py-3 fw-bold">Our
                        Story</a>
                </div>
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
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .category-scroll-shell {
            position: relative;
            margin-top: 0.5rem;
        }

        .category-scroll-viewport {
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 0.25rem 3.25rem;
            margin: 0 -3.25rem;
            overscroll-behavior-x: contain;
        }

        .category-scroll-viewport::-webkit-scrollbar {
            display: none;
        }

        .category-scroll-track {
            display: flex;
            gap: 1rem;
            width: max-content;
            padding: 0.25rem 0.15rem 0.75rem;
        }

        .category-card {
            position: relative;
            flex: 0 0 clamp(240px, 24vw, 360px);
            min-width: clamp(240px, 24vw, 360px);
            min-height: clamp(320px, 36vw, 440px);
            border-radius: 28px;
            background: #111827;
            isolation: isolate;
            scroll-snap-align: start;
            transition: transform 0.35s ease, box-shadow 0.35s ease;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1.25rem 2.5rem rgba(15, 23, 42, 0.14) !important;
        }

        .category-card-media,
        .category-card-overlay,
        .category-card-content {
            position: absolute;
            inset: 0;
        }

        .category-card-media-item {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.7s ease, filter 0.7s ease;
            filter: saturate(0.95) contrast(0.98);
        }

        .category-card:hover .category-card-media-item {
            transform: scale(1.06);
        }

        .category-card-overlay {
            background: linear-gradient(180deg, rgba(8, 12, 22, 0.02) 0%, rgba(8, 12, 22, 0.18) 28%, rgba(8, 12, 22, 0.78) 100%);
            z-index: 1;
        }

        .category-card-content {
            z-index: 2;
            color: #fff;
        }

        .category-chip {
            width: fit-content;
        }

        .category-card-title {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: clamp(1.5rem, 2.2vw, 2rem);
            line-height: 1.08;
            letter-spacing: -0.03em;
            text-shadow: 0 2px 14px rgba(0, 0, 0, 0.28);
        }

        .category-card-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.92rem;
        }

        .category-card-dot {
            width: 4px;
            height: 4px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.65);
        }

        .category-card-button {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            color: #111827;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 999px;
            padding: 0.8rem 1rem;
            font-weight: 700;
            width: fit-content;
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12);
            transition: transform 0.25s ease, background 0.25s ease;
        }

        .category-card:hover .category-card-button {
            transform: translateY(-2px);
            background: #fff;
        }

        .category-scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 46px;
            height: 46px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 0.9rem 2rem rgba(15, 23, 42, 0.14);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: transform 0.2s ease, opacity 0.2s ease, background 0.2s ease;
        }

        .category-scroll-btn:hover {
            transform: translateY(-50%) scale(1.04);
            background: #fff;
        }

        .category-scroll-btn:disabled {
            opacity: 0.35;
            pointer-events: none;
        }

        .category-scroll-btn-prev {
            left: -4px;
        }

        .category-scroll-btn-next {
            right: -4px;
        }

        @media (max-width: 991.98px) {
            .category-scroll-viewport {
                padding-inline: 0;
                margin-inline: 0;
            }

            .category-scroll-btn {
                width: 40px;
                height: 40px;
            }

            .category-card {
                flex-basis: clamp(220px, 70vw, 320px);
                min-width: clamp(220px, 70vw, 320px);
                min-height: 360px;
            }
        }

        @media (max-width: 767.98px) {
            .category-card {
                min-height: 340px;
            }

            .category-card-content {
                padding: 1.25rem !important;
            }
        }

        @media (max-width: 575.98px) {
            .category-scroll-shell {
                margin-top: 0.25rem;
            }

            .category-scroll-btn {
                display: none;
            }

            .category-card {
                min-height: 320px;
                flex-basis: 82vw;
                min-width: 82vw;
                border-radius: 22px;
            }

            .category-card-button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <!-- Testimonials -->
    <section class="py-5 velvet-bg reveal-section overflow-hidden">

        <!-- Decorative flowers (inline SVG for reliability) -->
        <svg class="flower flower-1" aria-hidden="true"
            style="position:absolute;left:1.5rem;top:0.5rem;width:84px;opacity:0.85;" viewBox="0 0 64 64" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="32" cy="32" r="12" fill="#FFE1EC" />
            <path d="M32 6c4 10 18 10 18 18s-8 14-18 18-18-6-18-18S28 6 32 6z" fill="#FFD9E6" />
        </svg>
        <svg class="flower flower-2" aria-hidden="true"
            style="position:absolute;right:2rem;top:1rem;width:68px;opacity:0.7;transform:rotate(12deg);"
            viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="32" cy="32" r="10" fill="#FFF1E0" />
            <path d="M32 4c3 8 14 8 14 14s-6 10-14 14S18 34 18 18 29 4 32 4z" fill="#FFE7D1" />
        </svg>

        <div class="container position-relative z-2">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-white mb-2">Loved by Mothers</h2>
                <p class="opacity-75 fs-5">Real words from our wonderful community</p>
            </div>

            <div class="testimonial-row-mask">
                <div class="testimonial-row-track">
                    @foreach ($testimonialItems->concat($testimonialItems) as $testimonial)
                        <div class="bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-20 rounded-4 p-4 shadow-sm"
                            style="width: 350px;">
                            <div class="text-warning mb-3">
                                @for ($i = 0; $i < $testimonial['rating']; $i++)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-white font-italic fs-5 mb-4">"{{ $testimonial['quote'] }}"</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 40px; height: 40px;">
                                    {{ substr($testimonial['name'], 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-0">{{ $testimonial['name'] }}</h6>
                                    <small
                                        class="text-white opacity-60 text-uppercase letter-spacing-1">{{ $testimonial['role'] }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @php
        $showcaseVideoCount = $showcaseVideos->count();
        // Ensure videos are displayed in explicit sort order (lowest `order` first),
        // then by most recent id when orders match.
        $orderedVideos = $showcaseVideos->sortBy([['order', 'asc'], ['id', 'desc']]);
        $showcaseLoopItems = $orderedVideos
            ->map(
                fn($video) => [
                    'title' => $video->title ?: 'Studio spotlight',
                    'description' => $video->description ?: 'A portrait showcase clip from the latest collection.',
                    'video_url' => $video->video_path ? asset($video->video_path) : null,
                    'thumb_url' => $video->thumbnail_path ? asset('images/' . $video->thumbnail_path) : null,
                ],
            )
            ->values()
            ->all();
    @endphp

    <!-- Showcase Video -->
    <section class="py-5 showcase-video-section reveal-section overflow-hidden">
        <div class="container py-lg-2">
            @if ($showcaseVideoCount > 0)
                <div class="showcase-swiper swiper mx-auto" id="showcaseSwiper"
                    data-showcase-total="{{ $showcaseVideoCount }}">
                    <div class="swiper-wrapper">
                        @foreach ($showcaseLoopItems as $item)
                            <div class="swiper-slide">
                                <article class="showcase-card">
                                    <div class="showcase-card-media">
                                        @if ($item['video_url'])
                                            <video loop muted playsinline preload="metadata"
                                                poster="{{ $item['thumb_url'] }}">
                                                <source src="{{ $item['video_url'] }}" type="video/mp4">
                                            </video>
                                        @elseif ($item['thumb_url'])
                                            <img src="{{ $item['thumb_url'] }}" alt="{{ $item['title'] }}">
                                        @else
                                            <div class="showcase-card-empty">
                                                <div class="showcase-card-empty-inner">
                                                    <span class="showcase-video-chip mb-3">No media</span>
                                                    <h5 class="fw-bold text-white mb-2">Upload video</h5>
                                                    <p class="mb-0 text-white-50 small">Add video or thumbnail from
                                                        admin showcase videos.</p>
                                                </div>
                                            </div>
                                        @endif
                                        <span class="badge rounded-pill showcase-card-badge px-3 py-2">Showcase
                                            card</span>
                                        <div class="showcase-card-glow">
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                                <span class="showcase-video-chip py-1 px-2">
                                                    <i class="icon icon-play"></i>
                                                    Highlight
                                                </span>
                                                <small class="text-white-50 text-uppercase fw-semibold">Slide</small>
                                            </div>
                                            <h4 class="fw-bold mb-1">{{ $item['title'] }}</h4>
                                            <p class="mb-0 small text-white-50">{{ $item['description'] }}</p>
                                        </div>
                                    </div>
                                    <div class="showcase-card-footer">
                                        <span class="showcase-card-dot"></span>
                                        <div class="small fw-semibold" data-showcase-meta-counter>
                                            1/{{ $showcaseVideoCount }}</div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="showcase-card showcase-card-featured mx-auto" style="max-width: 420px;">
                    <div class="showcase-card-empty">
                        <div class="showcase-card-empty-inner">
                            <span class="showcase-video-chip mb-3">No active video yet</span>
                            <h4 class="fw-bold text-white mb-2">Upload a portrait clip in the admin panel</h4>
                            <p class="mb-0 text-white-50">Once active showcase videos exist, this section becomes a
                                layered card slider.</p>
                        </div>
                    </div>
                    <div class="showcase-card-footer">
                        <span class="showcase-card-dot"></span>
                        <div class="small fw-semibold">Ready for dynamic content</div>
                    </div>
                </div>
            @endif
        </div>
        </div>
        </div>
    </section>

    <!-- Why Us -->
    <section class="py-5 reveal-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <h2 class="display-4 fw-bold mb-4">Why choose Lily's Nook?</h2>
                    <p class="text-muted fs-5 mb-4">We believe dressing up should be as delightful as childhood itself.</p>
                    <a href="{{ route('about') }}" class="btn btn-primary rounded-pill px-5 py-3 shadow">Our Full
                        Story</a>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-primary rounded-4">
                                <h4 class="fw-bold mb-2">Handpicked Design</h4>
                                <p class="text-muted small mb-0">Curated pieces that celebrate wonder, playfulness, and
                                    individual personality.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-success rounded-4">
                                <h4 class="fw-bold mb-2">Timeless Style</h4>
                                <p class="text-muted small mb-0">Vintage-inspired silhouettes reimagined for modern little
                                    trendsetters.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-warning rounded-4">
                                <h4 class="fw-bold mb-2">Artisan Quality</h4>
                                <p class="text-muted small mb-0">Soft, premium fabrics and thoughtful finishes built for
                                    comfort and durability.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card h-100 p-4 border bg-soft-danger rounded-4">
                                <h4 class="fw-bold mb-2">Made with Love</h4>
                                <p class="text-muted small mb-0">Every collection is selected to keep childhood style
                                    magical and effortless.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
            }, {
                threshold: 0.15
            });
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

            const viewport = document.getElementById('categoryScrollViewport');
            const track = document.getElementById('categoryScrollTrack');
            const prevButton = document.querySelector('[data-category-scroll="prev"]');
            const nextButton = document.querySelector('[data-category-scroll="next"]');

            function updateCategoryScrollButtons() {
                if (!viewport || !track) return;

                const maxScrollLeft = Math.max(0, track.scrollWidth - viewport.clientWidth);
                const currentScrollLeft = Math.max(0, viewport.scrollLeft);

                if (prevButton) {
                    prevButton.disabled = currentScrollLeft <= 4;
                }

                if (nextButton) {
                    nextButton.disabled = currentScrollLeft >= (maxScrollLeft - 4);
                }
            }

            function scrollCategoryRail(direction) {
                if (!viewport) return;

                const card = viewport.querySelector('.category-card');
                const cardWidth = card ? card.getBoundingClientRect().width : viewport.clientWidth * 0.8;
                const gap = 16;
                viewport.scrollBy({
                    left: direction * (cardWidth + gap),
                    behavior: 'smooth',
                });
            }

            prevButton?.addEventListener('click', () => scrollCategoryRail(-1));
            nextButton?.addEventListener('click', () => scrollCategoryRail(1));
            viewport?.addEventListener('scroll', updateCategoryScrollButtons, {
                passive: true
            });
            window.addEventListener('resize', updateCategoryScrollButtons);
            document.addEventListener('DOMContentLoaded', updateCategoryScrollButtons);
            updateCategoryScrollButtons();

            const showcaseRoot = document.getElementById('showcaseSwiper');
            const showcasePrev = document.querySelector('[data-showcase-control="prev"]');
            const showcaseNext = document.querySelector('[data-showcase-control="next"]');
            const showcasePagination = document.getElementById('showcasePagination');

            if (showcaseRoot && window.Swiper) {
                const totalSlides = Number(showcaseRoot.dataset.showcaseTotal || 0);
                const counterNodes = showcaseRoot.querySelectorAll('[data-showcase-meta-counter]');

                function syncActiveVideoPlayback(swiper) {
                    const allVideos = showcaseRoot.querySelectorAll('video');
                    const activeSlideVideo = swiper.slides[swiper.activeIndex]?.querySelector('video');

                    allVideos.forEach((video) => {
                        if (video !== activeSlideVideo) {
                            video.pause();
                        }
                    });

                    if (activeSlideVideo) {
                        if (activeSlideVideo.paused) {
                            activeSlideVideo.play().catch(() => {
                                // ignore autoplay rejections from strict browser policies
                            });
                        }
                    }
                }

                let showcaseSwiper = null;

                const swiperOptions = {
                    centeredSlides: true,
                    loop: totalSlides > 1,
                    effect: 'coverflow',
                    coverflowEffect: {
                        rotate: 0,
                        stretch: 0,
                        depth: 245,
                        modifier: 1,
                        slideShadows: false,
                    },
                    slidesPerView: 'auto',
                    spaceBetween: 24,
                    speed: 1600,
                    grabCursor: true,
                    roundLengths: true,
                    watchSlidesProgress: true,
                    loopAdditionalSlides: totalSlides,
                    loopedSlides: totalSlides,
                    loopPreventsSliding: true,
                    slideToClickedSlide: true,
                    centeredSlidesBounds: false,
                    autoplay: totalSlides > 1 ? {
                        delay: 3000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    } : false,
                    breakpoints: {
                        576: {
                            spaceBetween: 20,
                        },
                        992: {
                            spaceBetween: 24,
                        },
                        1200: {
                            spaceBetween: 28,
                        },
                    },
                    on: {
                        init(swiper) {
                            const current = swiper.realIndex + 1;
                            counterNodes.forEach((node) => {
                                node.textContent = `${current}/${totalSlides}`;
                            });
                            syncActiveVideoPlayback(swiper);
                        },
                        realIndexChange(swiper) {
                            const current = swiper.realIndex + 1;
                            counterNodes.forEach((node) => {
                                node.textContent = `${current}/${totalSlides}`;
                            });
                        },
                        slideChangeTransitionEnd(swiper) {
                            syncActiveVideoPlayback(swiper);
                        },
                    },
                };

                if (showcasePrev && showcaseNext) {
                    swiperOptions.navigation = {
                        nextEl: showcaseNext,
                        prevEl: showcasePrev
                    };
                }

                if (showcasePagination) {
                    swiperOptions.pagination = {
                        el: showcasePagination,
                        clickable: true
                    };
                }

                showcaseSwiper = new Swiper(showcaseRoot, swiperOptions);

                if (totalSlides <= 1) {
                    showcasePrev?.setAttribute('disabled', 'disabled');
                    showcaseNext?.setAttribute('disabled', 'disabled');
                    showcaseSwiper.autoplay?.stop();
                }
            }
        })();
    </script>
@endpush
