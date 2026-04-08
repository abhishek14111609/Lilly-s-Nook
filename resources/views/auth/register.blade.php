@extends('layouts.app')

@section('title', 'Register')

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
                            <h1 class="welcome-title">Join Lilly's Nook</h1>
                            <p class="welcome-subtitle">Create your account and start your beautiful shopping journey</p>

                            <div class="welcome-features">
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
                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span>Order Tracking</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Register Form -->
                    <div class="auth-form">
                        <div class="form-content">
                            <div class="form-header">
                                <h2 class="form-title">Create Account</h2>
                                <p class="form-subtitle">Join our community and start shopping</p>
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

                            <form method="post" action="{{ route('register.store') }}" class="register-form" novalidate>
                                @csrf

                                <!-- Username Input -->
                                <div class="form-group">
                                    <label for="username" class="form-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        Username
                                    </label>
                                    <div class="input-group">
                                        <input type="text" name="username" id="username"
                                            class="form-control @if ($errors->has('username')) is-invalid @endif"
                                            value="{{ old('username') }}" required placeholder="Choose a username"
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

                                <!-- Email Input -->
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                            </path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        Email Address
                                    </label>
                                    <div class="input-group">
                                        <input type="email" name="email" id="email"
                                            class="form-control @if ($errors->has('email')) is-invalid @endif"
                                            value="{{ old('email') }}" required placeholder="Enter your email"
                                            autocomplete="email">
                                        <div class="input-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                </path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Fields Row -->
                                <div class="form-row row-2">
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
                                                required placeholder="Create a password" autocomplete="new-password">
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
                                                onclick="togglePassword('password')"
                                                aria-label="Toggle password visibility">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="password-strength" id="password-strength">
                                            <div class="strength-bar">
                                                <div class="strength-fill"></div>
                                            </div>
                                            <span class="strength-text">Password strength</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <rect x="3" y="11" width="18" height="11" rx="2"
                                                    ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                            Confirm Password
                                        </label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" class="form-control" required
                                                placeholder="Confirm your password" autocomplete="new-password">
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
                                                onclick="togglePassword('password_confirmation')"
                                                aria-label="Toggle password visibility">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms Checkbox -->
                                <div class="form-options">
                                    <div class="terms-checkbox">
                                        <input type="checkbox" name="terms" value="1" id="terms"
                                            class="form-check-input @if ($errors->has('terms')) is-invalid @endif"
                                            required>
                                        <label for="terms" class="form-check-label">
                                            I agree to the <a href="#" class="terms-link">Terms of Service</a> and
                                            <a href="#" class="terms-link">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>

                                <!-- Register Button -->
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <span class="btn-text">Create Account</span>
                                    <div class="btn-loader" style="display: none;">
                                        <div class="spinner"></div>
                                    </div>
                                </button>
                            </form>

                            <!-- Footer Links -->
                            <div class="form-footer">
                                <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Login
                                        here</a></p>
                            </div>

                            <!-- Social Login -->
                            <div class="social-login">
                                <div class="social-divider">
                                    <span>Or continue with</span>
                                </div>
                                <div class="social-buttons">
                                    <button type="button" class="btn btn-google" title="Sign up with Google" disabled>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                            <path
                                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                            <path
                                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                            <path
                                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                        </svg>
                                        Google
                                    </button>
                                    <button type="button" class="btn btn-facebook" title="Sign up with Facebook"
                                        disabled>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                        </svg>
                                        Facebook
                                    </button>
                                </div>
                            </div>
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

        // Password strength checker
        const passwordField = document.getElementById('password');
        const strengthIndicator = document.getElementById('password-strength');
        const strengthFill = strengthIndicator.querySelector('.strength-fill');
        const strengthText = strengthIndicator.querySelector('.strength-text');

        if (passwordField) {
            passwordField.addEventListener('input', function() {
                const strength = calculatePasswordStrength(this.value);
                const percentage = (strength / 4) * 100;
                strengthFill.style.width = percentage + '%';

                const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
                strengthText.textContent = 'Password strength: ' + labels[strength];
            });
        }

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;
            return Math.min(strength, 4);
        }

        // Form submission with loading state
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.register-form');
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
