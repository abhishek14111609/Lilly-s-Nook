@extends('layouts.app')

@section('title', 'My Profile')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    <section class="padding-large account-page">
        <div class="container">
            <div class="account-page-header mb-4 mb-lg-5">
                <div>
                    <p class="text-uppercase text-muted small mb-1">My account</p>
                    <h1 class="h2 mb-2">Profile details</h1>
                    <p class="text-muted mb-0">Keep your contact details current so orders and invoices stay accurate.</p>
                </div>
                <div class="account-page-actions">
                    <a href="{{ route('orders.history') }}" class="btn btn-dark">View my orders</a>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Continue shopping</a>
                </div>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <div class="account-summary-card">
                        <p class="text-uppercase text-muted small mb-2">Account overview</p>
                        <div class="account-avatar mb-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <h3 class="h5 mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-3">{{ $user->username }}</p>

                        <div class="account-summary-list">
                            <div>
                                <span>Full name</span>
                                <strong>{{ $user->name }}</strong>
                            </div>
                            <div>
                                <span>Email</span>
                                <strong>{{ $user->email }}</strong>
                            </div>
                            <div>
                                <span>Member since</span>
                                <strong>{{ $user->created_at?->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="account-form-card">
                        <div class="account-form-header">
                            <div>
                                <p class="text-uppercase text-muted small mb-1">Profile details</p>
                                <h2 class="h4 mb-0">Update your information</h2>
                            </div>
                            <a href="{{ route('orders.history') }}" class="btn btn-sm btn-outline-dark">My orders</a>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="account-form-body">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username *</label>
                                    <input type="text" id="username" name="username" class="form-control"
                                        value="{{ old('username', $user->username) }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                            <div class="account-form-footer">
                                <div class="text-muted small">Member since {{ $user->created_at?->format('d M Y') }}</div>
                                <button type="submit" class="btn btn-dark">Save profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection