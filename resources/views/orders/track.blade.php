@extends('layouts.app')

@section('title', 'Track Order')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    <section class="padding-large account-page">
        <div class="container">
            <div class="account-page-header mb-4 mb-lg-5">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Order support</p>
                    <h1 class="h2 mb-2">Track order</h1>
                    <p class="text-muted mb-0">Enter your order ID to review its current status and invoice details.</p>
                </div>
                <div class="account-page-actions">
                    <a href="{{ route('orders.history') }}" class="btn btn-dark">My orders</a>
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-dark">Back to profile</a>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-lg-7">
                    <div class="account-form-card mb-4">
                        <div class="account-form-header">
                            <div>
                                <p class="text-uppercase text-muted small mb-1">Track manually</p>
                                <h2 class="h4 mb-0">Look up your order</h2>
                            </div>
                        </div>
                        <div class="account-form-body">
                            <form method="post" action="{{ route('orders.track') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="order_id" class="form-label">Order ID *</label>
                                    <input type="number" name="order_id" id="order_id" class="form-control"
                                        value="{{ old('order_id') }}" required>
                                </div>
                                <div class="account-form-actions">
                                    <button class="btn btn-dark" type="submit">Track order</button>
                                    <a href="{{ route('orders.history') }}" class="btn btn-outline-dark">My orders</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($order)
                        <div class="account-panel">
                            <div class="account-panel-header border-bottom mb-3 pb-3">
                                <div>
                                    <p class="text-uppercase text-muted small mb-1">Tracking result</p>
                                    <h3 class="h4 mb-0">Order #{{ $order->id }}</h3>
                                </div>
                                <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="account-stat-card h-100">
                                        <span class="text-muted small d-block mb-1">Date</span>
                                        <strong>{{ $order->ordered_at?->format('d M Y h:i A') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="account-stat-card h-100">
                                        <span class="text-muted small d-block mb-1">Total</span>
                                        <strong>&#8377;{{ number_format((float) $order->total, 2) }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="account-stat-card h-100">
                                        <span class="text-muted small d-block mb-1">Payment</span>
                                        <strong>{{ ucfirst($order->payment_status ?? 'pending') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-dark">Open full details</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
