@extends('layouts.app')

@section('title', 'My Orders')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/account.css') }}">
@endpush

@section('content')
    @php
        /** @var \Illuminate\Pagination\LengthAwarePaginator $orders */
    @endphp
    <section class="padding-large account-page">
        <div class="container">
            <div class="account-page-header mb-4 mb-lg-5">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Account activity</p>
                    <h1 class="h2 mb-2">My order history</h1>
                    <p class="text-muted mb-0">Review invoices, payment status, and every order you have placed.</p>
                </div>
                <div class="account-page-actions">
                    <a href="{{ route('profile.show') }}" class="btn btn-dark">Back to profile</a>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Shop again</a>
                </div>
            </div>

            <div class="account-stats-grid mb-4">
                <div class="account-stat-card">
                    <span class="text-muted small d-block mb-1">Orders placed</span>
                    <strong>{{ $orders->total() }}</strong>
                </div>
                <div class="account-stat-card">
                    <span class="text-muted small d-block mb-1">Current page</span>
                    <strong>{{ $orders->currentPage() }}</strong>
                </div>
                <div class="account-stat-card">
                    <span class="text-muted small d-block mb-1">Payment status</span>
                    <strong>Paid & pending orders</strong>
                </div>
            </div>

            <div class="account-panel">
                @if ($orders->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>#{{ $order->id }}</strong>
                                            <div class="text-muted small">{{ $order->invoice_number ?? 'Invoice pending' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $order->ordered_at?->format('d M Y') }}</div>
                                            <div class="text-muted small">{{ $order->ordered_at?->format('h:i A') }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match ($order->status) {
                                                    'delivered' => 'bg-success',
                                                    'canceled' => 'bg-danger',
                                                    'shipped' => 'bg-info',
                                                    'processing' => 'bg-warning text-dark',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                                            <div class="text-muted small mt-1">
                                                {{ ucfirst($order->payment_status ?? 'pending') }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">&#8377;{{ number_format($order->total, 2) }}</div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('orders.show', $order) }}"
                                                class="btn btn-sm btn-outline-dark">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="account-panel-footer">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="account-empty-state">
                        <p class="text-muted mb-3">You have not placed an order yet.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-dark">Start shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
