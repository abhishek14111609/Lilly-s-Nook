@extends('layouts.app')

@section('title', 'Order History - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
            <div>
                <h1 class="display-5 fw-bold mb-1">My Orders</h1>
                <p class="text-muted mb-0">Track shipments and view your purchase history.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('account.profile') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">My Account</a>
                <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-4 fw-bold">Shop More</a>
            </div>
        </div>

        @if ($orders->isNotEmpty())
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-mobile-stack">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0 py-3">Order #</th>
                                <th class="border-0 py-3">Placed On</th>
                                <th class="border-0 py-3">Total</th>
                                <th class="border-0 py-3">Status</th>
                                <th class="text-end pe-4 border-0 py-3">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="ps-4" data-label="Order #">
                                        <span class="fw-bold text-dark">#{{ $order->id }}</span>
                                        <small class="text-muted d-block font-monospace text-xs">{{ $order->invoice_number ?? 'Invoicing...' }}</small>
                                    </td>
                                    <td data-label="Placed On">
                                        <div class="text-dark fw-medium small">{{ $order->ordered_at?->format('F d, Y') }}</div>
                                        <div class="text-muted text-xs">{{ $order->ordered_at?->format('h:i A') }}</div>
                                    </td>
                                    <td data-label="Total">
                                        <span class="fw-bold">₹{{ number_format($order->total, 2) }}</span>
                                    </td>
                                    <td data-label="Status">
                                        @php
                                            $state = match($order->status) {
                                                'delivered' => 'success',
                                                'processing' => 'warning',
                                                'shipped' => 'info',
                                                'canceled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge rounded-pill bg-soft-{{ $state }} text-{{ $state }} text-uppercase fw-bold px-3" style="font-size: 10px;">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4" data-label="Details">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-white btn-sm rounded-pill border shadow-sm px-3 fw-bold">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="py-5 text-center bg-light rounded-4 border border-dashed">
                <div class="py-5">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1" class="mb-3"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    <h3 class="fw-bold">No orders found</h3>
                    <p class="text-muted">Once you place your first order, it will appear here.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow">Start Shopping</a>
                </div>
            </div>
        @endif
    </div>
@endsection
