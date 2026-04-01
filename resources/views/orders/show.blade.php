@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <section class="padding-large">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="m-0">Order #{{ $order->id }}</h2>
                <a href="{{ route('orders.history') }}" class="btn btn-outline-dark">Back to Orders</a>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Status</h6>
                            <p class="mb-3"><span class="badge bg-primary">{{ ucfirst($order->status) }}</span></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Ordered On</h6>
                            <p class="mb-3">{{ $order->ordered_at?->format('d M Y h:i A') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Order Total</h6>
                            <p class="mb-3">&#8377;{{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1">Shipping Address</h6>
                    <p class="mb-0">{{ $order->first_name }} {{ $order->last_name }}, {{ $order->address }},
                        {{ $order->city }}, {{ $order->zip }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">Ordered Items</div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->size ?: 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>&#8377;{{ number_format($item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
