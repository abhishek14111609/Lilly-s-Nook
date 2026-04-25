@extends('layouts.app')

@section('title', 'My Profile - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Profile Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="mb-4">
                        <div class="bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: 700;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted small mb-4">{{ $user->email }}</p>
                    
                    <div class="list-group list-group-flush text-start rounded-3 overflow-hidden border">
                        <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action active py-3 border-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            Profile Details
                        </a>
                        <a href="{{ route('orders.history') }}" class="list-group-item list-group-item-action py-3 border-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            Order History
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="list-group-item list-group-item-action py-3 border-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                            My Wishlist
                        </a>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-bold">Sign Out</button>
                    </form>
                </div>
            </div>

            <!-- Profile Info Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Account Settings</h4>
                        <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill">Verified Member</span>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase letter-spacing-1">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase letter-spacing-1">Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase letter-spacing-1">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <p class="text-muted small mt-2">Required for order notifications and login.</p>
                            </div>
                        </div>

                        <hr class="my-5 opacity-10">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <p class="mb-0 text-muted small">Account created on {{ $user->created_at?->format('F d, Y') }}</p>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection