@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <section class="padding-large">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <span>Profile Details</span>
                            <a href="{{ route('orders.history') }}" class="btn btn-sm btn-light">View My Orders</a>
                        </div>
                        <div class="card-body p-4">
                            <form method="post" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username *</label>
                                        <input type="text" id="username" name="username" class="form-control"
                                            value="{{ old('username', $user->username) }}" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="small text-muted mb-4">
                                    Member since {{ $user->created_at?->format('d M Y') }}
                                </div>

                                <button type="submit" class="btn btn-dark">Save Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
