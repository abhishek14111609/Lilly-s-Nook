@extends('layouts.app')

@section('title', 'Contact Us - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">GET IN TOUCH</span>
            <h1 class="display-5 fw-bold mb-3 font-playfair">{{ $contactHeading ?? "We'd Love to Hear From You" }}</h1>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                {{ $contactDescription ?? 'Whether you have a question about our collections, need help with an order, or just want to say hello, our team is here for you.' }}
            </p>
        </div>

        <div class="row g-5 justify-content-center">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Send us a message</h3>

                    @if (session('status'))
                        <div class="alert alert-success border-0 rounded-3 mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Your Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Jane Doe"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Email Address</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="jane@example.com"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase">Subject</label>
                                <input type="text" name="subject" class="form-control"
                                    placeholder="What is this regarding?" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase">Message</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
                                    placeholder="Share your thoughts with us..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-dark btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm mt-2">Send
                                    Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="d-flex flex-column gap-4">


                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-soft-success text-success">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white p-2 rounded-3 shadow-sm">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Email Us</h6>
                                <p class="mb-0 text-dark">
                                    {{ $contactEmail ?? config('mail.from.address', 'lilysnook05@gmail.com') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-soft-warning text-warning">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white p-2 rounded-3 shadow-sm">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Visit Us</h6>
                                <p class="mb-0 text-dark small">
                                    {{ $contactAddress ?? 'Boutique #404, Fashion Square, Mumbai' }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    <h6 class="fw-bold text-uppercase small text-muted letter-spacing-1 mb-3 text-center">Follow our journey
                    </h6>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ $contactInstagram ?? 'https://instagram.com/lillysnook' }}" target="_blank"
                            rel="noopener"
                            class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 44px; height: 44px;" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="{{ $contactFacebook ?? 'https://facebook.com/lillysnook' }}" target="_blank"
                            rel="noopener"
                            class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 44px; height: 44px;" aria-label="Facebook">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
