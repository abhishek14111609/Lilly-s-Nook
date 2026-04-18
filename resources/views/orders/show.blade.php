@extends('layouts.app')

@section('title', 'Order Details')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    <section class="padding-large account-page bg-light-grey">
        <div class="container">
            <div class="account-page-header mb-4 mb-lg-5">
                <div>
                    <p class="text-uppercase text-muted small mb-1">My order</p>
                    <h1 class="h2 mb-2">Order #{{ $order->id }}</h1>
                    <p class="text-muted mb-0">View the invoice, payment references, and item details in one place.</p>
                </div>
                <div class="account-page-actions">
                    <a href="{{ route('orders.history') }}" class="btn btn-dark">Back to orders</a>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Continue shopping</a>
                </div>
            </div>

            <div class="account-panel">
                @include('orders.partials.invoice', ['order' => $order])
            </div>
        </div>
    </section>
@endsection