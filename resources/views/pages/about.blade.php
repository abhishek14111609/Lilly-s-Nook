@extends('layouts.app')

@section('title', 'About')

@section('content')
    <section class="page-intro">
        <div class="container">
            <div class="page-intro-card">
                <span class="page-eyebrow">Our story</span>
                <h1 class="page-title mb-2">About Lilly's Nook</h1>
                <p class="page-intro-text mb-0">A closer look at the inspiration, craftsmanship, and promise behind every collection.</p>
            </div>
        </div>
    </section>

    <section class="padding-large">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-6"><img src="{{ asset('images/' . $aboutImage) }}" alt="About Lilly's Nook"
                        class="image-rounded about-feature-image"></div>
                <div class="col-md-6">
                    <h2 class="section-title">{{ $aboutTitle }}</h2>
                    <p>{{ $aboutBodyOne }}</p>
                    @if ($aboutBodyTwo)
                        <p>{{ $aboutBodyTwo }}</p>
                    @endif

                    @if (!empty($aboutPromiseItems ?? []))
                        <h3 class="mt-4">{{ $aboutPromiseTitle ?? 'Our Promise' }}</h3>
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
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/about.css') }}">
@endpush
