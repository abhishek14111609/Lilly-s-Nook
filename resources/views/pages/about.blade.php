@extends('layouts.app')

@section('title', 'About Us - Lilly\'s Nook')

@section('content')
    <section class="about-hero py-5 py-lg-6">
        <div class="container">
            <div class="about-hero-card">
                <span class="about-eyebrow">Our Story</span>
                <h1 class="about-title mb-3">{{ $aboutTitle ?? "About Lilly's Nook" }}</h1>
                <p class="about-subtitle mb-0">
                    A closer look at the inspiration, craftsmanship, and promise behind every collection.
                </p>
            </div>
        </div>
    </section>

    <section class="pb-5 pb-lg-6">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <img src="{{ asset('images/' . $aboutImage) }}" alt="About Lilly's Nook"
                        class="image-rounded about-feature-image">
                </div>
                <div class="col-lg-6">
                    <span class="about-section-tag">Who We Are</span>
                    <h2 class="section-title about-section-title">Designed for magical, everyday moments.</h2>
                    <p class="about-copy">{{ $aboutBodyOne }}</p>
                    @if ($aboutBodyTwo)
                        <p class="about-copy">{{ $aboutBodyTwo }}</p>
                    @endif

                    @if (!empty($aboutPromiseItems ?? []))
                        <h3 class="about-promise-title mt-4">{{ $aboutPromiseTitle ?? 'Our Promise' }}</h3>
                        <ul class="about-promise-list">
                            @foreach ($aboutPromiseItems as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="about-values pb-5 pb-lg-6">
        <div class="container">
            <div class="row g-3 g-lg-4">
                <div class="col-md-4">
                    <article class="about-value-card">
                        <h3>Thoughtful Curation</h3>
                        <p>Each piece is handpicked to balance comfort, durability, and timeless style for growing little wardrobes.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="about-value-card">
                        <h3>Crafted with Care</h3>
                        <p>From fabrics to finishing, we prioritize quality details that feel soft, wear well, and stay beautiful.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="about-value-card">
                        <h3>Made for Real Life</h3>
                        <p>Our collections are designed for birthdays, playdates, family outings, and all the tiny memories in between.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="about-cta pb-5 pb-lg-6">
        <div class="container">
            <div class="about-cta-card text-center">
                <h2 class="mb-3">Ready to explore our latest collection?</h2>
                <p class="mb-4 text-muted">Find outfits that feel special and practical, made for little ones who light up every room.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-4 py-2">Shop Now</a>
                    <a href="{{ route('contact.show') }}" class="btn btn-outline-dark rounded-pill px-4 py-2">Talk to Us</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/about.css') }}">
@endpush
