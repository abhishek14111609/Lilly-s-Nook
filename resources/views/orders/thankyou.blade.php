@extends('layouts.app')

@section('title', 'Thank You')

@section('content')
    <section id="thank-you" class="padding-large bg-light-grey">
        <div class="container">
            <div class="section-header">
                <h1 class="page-title">Thank You!</h1>
                <p>Your order has been placed successfully.</p>
            </div>
            <div class="alert alert-success">
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Total:</strong> &#8377;{{ number_format($order->total, 2) }}</p>
                <p><strong>Payment:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
            <a href="{{ route('orders.show', $order) }}" class="btn btn-dark">View this order</a>
            <a href="{{ route('shop.index') }}" class="btn btn-secondary">Continue shopping</a>
        </div>
    </section>
@endsection
