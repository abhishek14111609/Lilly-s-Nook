@extends('layouts.app')

@section('title', 'Track Order')

@section('content')
    <!-- <section class="site-banner jarallax min-height300 padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat;">
            <div class="container"><h1 class="page-title">My Dashboard</h1></div>
        </section> -->

    <section class="padding-large">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-dark text-white">Track Order Manually</div>
                        <div class="card-body p-4">
                            <form method="post" action="{{ route('orders.track') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="order_id">Order ID *</label>
                                    <input type="number" name="order_id" id="order_id" class="form-control"
                                        value="{{ old('order_id') }}" required>
                                </div>
                                <button class="btn btn-dark" type="submit">Track Order</button>
                                <a href="{{ route('orders.history') }}" class="btn btn-outline-dark ms-2">My Orders</a>
                            </form>
                        </div>
                    </div>

                    @if ($order)
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">Tracking Result: Order #{{ $order->id }}</div>
                            <div class="card-body">
                                <h5>Status: <span class="badge bg-primary fs-6">{{ ucfirst($order->status) }}</span></h5>
                                <p class="mb-1"><strong>Date:</strong> {{ $order->ordered_at?->format('d M Y h:i A') }}
                                </p>
                                <p class="mb-3"><strong>Total:</strong> &#8377;{{ number_format($order->total, 2) }}</p>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Open Full
                                    Details</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
