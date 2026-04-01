@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <section class="padding-large">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="m-0">My Order History</h2>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-dark">Back to Profile</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if ($orders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>{{ $order->ordered_at?->format('d M Y') }}</td>
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
                                            </td>
                                            <td>&#8377;{{ number_format($order->total, 2) }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="btn btn-sm btn-outline-dark">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 border-top">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <p class="text-muted mb-3">You have not placed an order yet.</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-dark">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
