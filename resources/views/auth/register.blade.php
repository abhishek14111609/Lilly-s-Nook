@extends('layouts.app')

@section('title', 'Create Account - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-6 col-md-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5 bg-dark text-white p-5 d-none d-md-flex flex-column justify-content-center text-center">
                            <h2 class="display-6 fw-bold mb-4">Join the Nook</h2>
                            <p class="opacity-75 mb-5">Create an account to save your favorites, track orders, and experience personalized shopping.</p>
                            
                            <div class="d-flex flex-column gap-3 text-start">
                                <div class="d-flex align-items-center gap-2 small">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-primary"><path d="M20 6L9 17l-5-5"></path></svg>
                                    Fast & Secure Checkout
                                </div>
                                <div class="d-flex align-items-center gap-2 small">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-primary"><path d="M20 6L9 17l-5-5"></path></svg>
                                    Order Tracking
                                </div>
                                <div class="d-flex align-items-center gap-2 small">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-primary"><path d="M20 6L9 17l-5-5"></path></svg>
                                    Member-only Offers
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 p-4 p-md-5 bg-white">
                            <div class="mb-5">
                                <h1 class="h3 fw-bold mb-2">Create Account</h1>
                                <p class="text-muted small">It only takes a minute to join our community.</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger border-0 rounded-3 mb-4 small">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-uppercase">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Choose a unique name" value="{{ old('username') }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-uppercase">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}" required>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase">Confirm</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label text-muted text-xs" for="terms">
                                            I agree to the <a href="#" class="text-primary text-decoration-none">Terms of Service</a> & <a href="#" class="text-primary text-decoration-none">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm mb-4">
                                    Create My Account
                                </button>

                                <div class="text-center">
                                    <p class="text-muted text-xs mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Sign in instead</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection