@extends('layouts.app')

@section('title', 'Thank You')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    <section id="thank-you" class="padding-large account-page bg-light-grey">
        <div class="container">
            <div class="account-success-banner mb-4 mb-lg-5">
                <p class="text-uppercase text-muted small mb-2">Payment confirmed</p>
                <h1 class="page-title mb-2">Payment successful</h1>
                <p class="text-muted mb-0">Your invoice is ready and the order has been confirmed.</p>
                <div class="account-success-actions mt-3">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-dark">View order details</a>
                    <a href="{{ route('orders.history') }}" class="btn btn-outline-dark">My orders</a>
                </div>
            </div>

            <div class="account-panel">
                @include('orders.partials.invoice', ['order' => $order])
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Continue shopping</a>
            </div>
        </div>
    </section>
@endsection
