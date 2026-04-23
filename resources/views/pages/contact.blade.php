@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <section class="page-intro">
        <div class="container">
            <div class="page-intro-card">
                <span class="page-eyebrow">Get in touch</span>
                <h1 class="page-title mb-2">Contact Lilly's Nook</h1>
                <p class="page-intro-text mb-0">Questions, custom requests, or wholesale conversations are all welcome here.</p>
            </div>
        </div>
    </section>

    <section class="contact-information padding-large">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-md-6">
                    <div class="content-panel contact-details-card h-100">
                        <h2 class="section-title">{{ $contactHeading }}</h2>
                        <p>{{ $contactDescription }}</p>
                        <ul class="list-unstyled list-icon mb-0">
                        <li><i class="icon icon-phone"></i> {{ $contactPhone }}</li>
                        <li><i class="icon icon-mail"></i> {{ $contactEmail }}</li>
                        <li><i class="icon icon-map-pin"></i> {{ $contactAddress }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="content-panel contact-form-card h-100">
                        <h2 class="section-title">Send us a message</h2>
                        <form method="post" action="{{ route('contact.store') }}" class="contact-form-grid">
                            @csrf
                            <div class="form-group">
                                <label for="contact-name">Name</label>
                                <input id="contact-name" type="text" name="name"
                                    placeholder="Your name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact-email">Email</label>
                                <input id="contact-email" type="email" name="email"
                                    placeholder="you@example.com" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact-message">Message</label>
                                <textarea id="contact-message" class="form-control @error('message') is-invalid @enderror" name="message"
                                    placeholder="How can we help?" rows="7" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-dark btn-medium">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
