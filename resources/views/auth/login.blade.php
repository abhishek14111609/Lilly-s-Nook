@extends('layouts.app')

@section('title', $title ?? 'Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <section class="auth-section">
        <div class="auth-background">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
        </div>

        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-card-inner">
                    <!-- Left Side - Welcome Panel -->
                    <div class="auth-welcome">
                        <div class="welcome-content">
                            <div class="welcome-logo">
                                <div class="logo-circle">
                                    <span class="logo-text">LN</span>
                                </div>
                            </div>
                            <h1 class="welcome-title">Welcome Back</h1>
                            <p class="welcome-subtitle">Sign in to manage your orders, profile, and wishlist in one place
                            </p>

                            <div class="welcome-features">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span>Secure Shopping</span>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M9 2l6 6-6 6"></path>
                                        </svg>
                                    </div>
                                    <span>Fast Checkout</span>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span>Save Favorites</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="auth-form">
                        <div class="form-content">
                            <div class="form-header">
                                <h2 class="form-title">{{ $title ?? 'Login' }}</h2>
                                <p class="form-subtitle">Enter your credentials to access your account</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert">
                                    <div class="alert-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                        </svg>
                                    </div>
                                    <div class="alert-content">
                                        @foreach ($errors->all() as $error)
                                            <span>{{ $error }}</span><br>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <form method="post"
                                action="{{ $adminMode ?? false ? route('admin.login.attempt') : route('login.attempt') }}"
                                class="login-form" novalidate>
                                @csrf

                                <!-- Username/Email Input -->
                                <div class="form-group">
                                    <label for="login" class="form-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        Username or Email
                                    </label>
                                    <div class="input-group">
                                        <input type="text" name="login" id="login"
                                            class="form-control @if ($errors->has('login')) is-invalid @endif"
                                            value="{{ old('login') }}" required placeholder="Enter your username or email"
                                            autocomplete="username">
                                        <div class="input-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Input -->
                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2"
                                                ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                        Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password"
                                            class="form-control @if ($errors->has('password')) is-invalid @endif"
                                            required placeholder="Enter your password" autocomplete="current-password">
                                        <div class="input-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <rect x="3" y="11" width="18" height="11" rx="2"
                                                    ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                        </div>
                                        <button type="button" class="password-toggle"
                                            onclick="togglePassword('password')" aria-label="Toggle password visibility">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Form Options (Remember & Forgot) -->
                                <div class="form-options">
                                    <div class="remember-me">
                                        <input type="checkbox" name="remember" value="1" id="remember"
                                            class="form-check-input">
                                        <label for="remember" class="form-check-label">Remember me</label>
                                    </div>
                                    <a href="#" class="forgot-password">Forgot password?</a>
                                </div>

                                <!-- Login Button -->
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <span class="btn-text">Sign In</span>
                                    <div class="btn-loader" style="display: none;">
                                        <div class="spinner"></div>
                                    </div>
                                </button>
                            </form>

                            <!-- Footer Links -->
                            @if (!($adminMode ?? false))
                                <div class="form-footer">
                                    <p>Don't have an account? <a href="{{ route('register') }}" class="auth-link">Create
                                            one</a></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const isPassword = field.type === 'password';
            field.type = isPassword ? 'text' : 'password';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.login-form');
            if (form) {
                form.addEventListener('submit', function() {
                    const btn = this.querySelector('.btn-primary');
                    const loader = btn.querySelector('.btn-loader');
                    const text = btn.querySelector('.btn-text');
                    if (loader && text) {
                        text.style.display = 'none';
                        loader.style.display = 'block';
                        btn.disabled = true;
                    }
                });
            }
        });
    </script>
@endsection
