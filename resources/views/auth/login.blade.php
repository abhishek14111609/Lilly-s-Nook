@extends('layouts.app')

@section('title', $title ?? 'Login')

@section('content')
    <section class="padding-large">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row g-0 shadow-sm border rounded overflow-hidden bg-white">
                        <div class="col-md-5 p-4 p-md-5"
                            style="background: linear-gradient(140deg, #1f2937, #111827); color: #fff;">
                            <p class="text-uppercase mb-2" style="letter-spacing: 1px; opacity: .8;">Welcome Back</p>
                            <h2 class="mb-3 text-white">{{ $title ?? 'Login' }}</h2>
                            <p class="mb-0" style="opacity: .85;">Sign in to manage your orders, profile, and wishlist in
                                one place.</p>
                        </div>
                        <div class="col-md-7 p-4 p-md-5">
                            <form method="post"
                                action="{{ $adminMode ?? false ? route('admin.login.attempt') : route('login.attempt') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="login">Username or Email *</label>
                                    <input type="text" name="login" id="login" class="form-control"
                                        value="{{ old('login') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password *</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="remember" value="1"
                                        id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <button class="btn btn-dark" type="submit">{{ $title ?? 'Login' }}</button>
                            </form>

                            @if (!($adminMode ?? false))
                                <p class="mt-3 mb-0">Need an account? <a href="{{ route('register') }}">Create one</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
