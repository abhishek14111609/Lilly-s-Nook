@extends('layouts.app')

@section('title', 'About')

@section('content')
    <!-- <section class="site-banner jarallax padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: center;">
                <div class="container"><h1 class="page-title">About Lilly's Nook</h1></div>
            </section> -->

    <section class="padding-large">
        <div class="container">
            <div class="row">
                <div class="col-md-6"><img src="{{ asset('images/' . $aboutImage) }}" alt="About Lilly's Nook"
                        class="image-rounded"></div>
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
    <style>
        .about-promise-list {
            margin: 12px 0 0;
            padding-left: 18px;
            display: grid;
            gap: 8px;
            color: #5f4c42;
        }
    </style>
@endpush
