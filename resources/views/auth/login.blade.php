@extends('layouts.app')

@section('title', 'Login - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-5 col-md-8">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                    <div class="text-center mb-5">
                        <h1 class="display-6 fw-bold mb-2">Welcome Back</h1>
                        <p class="text-muted">Sign in to your account to continue your magical shopping journey.</p>
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

                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase letter-spacing-1">Email or
                                Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 px-3">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </span>
                                <input type="text" name="login" class="form-control border-start-0 ps-0 bg-light"
                                    required placeholder="your.name@email.com" value="{{ old('login') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label small fw-bold text-uppercase letter-spacing-1">Password</label>
                                <a href="#" class="text-xs text-decoration-none fw-bold text-primary">Forgot
                                    Password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 px-3">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2">
                                        </rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0 bg-light"
                                    required placeholder="••••••••">
                            </div>
                        </div>

                        <div class="mb-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-muted" for="remember">Keep me signed in</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm mb-4">
                            Sign In
                        </button>

                        <div class="text-center">
                            <p class="text-muted small mb-0">Don't have an account? <a href="{{ route('register') }}"
                                    class="text-primary fw-bold text-decoration-none">Create one for free</a></p>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-5">
                    <p class="text-xs text-muted mb-0">&copy; {{ date('Y') }} Lily's Nook Boutique. All rights
                        reserved.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
