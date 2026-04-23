@extends('layouts.admin')
@section('title', 'Admin Order #' . $order->id)
@section('content')
    <div class="page-header">
        <div class="admin-dashboard-hero">
            <div>
                <p class="text-uppercase text-muted small mb-1">Order details</p>
                <h1 class="h3 mb-2">Order #{{ $order->id }}</h1>
                <p class="text-muted mb-0">Placed on {{ $order->ordered_at->format('M d, Y') }}. Invoice: {{ $order->invoice_number ?? 'Pending' }}</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
            </div>
        </div>
    </div>

    <div class="admin-two-col">
        <div class="admin-surface">
            <div class="admin-surface-header">
                <h5 class="mb-0">Items</h5>
            </div>
            <div class="admin-surface-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->size ?: 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>&#8377;{{ number_format($item->price, 2) }}</td>
                                    <td>&#8377;{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th>&#8377;{{ number_format($order->total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="admin-compact-grid">
            <div class="admin-surface">
                <div class="admin-surface-header"><h5 class="mb-0">Status</h5></div>
                <div class="admin-surface-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="post">
                        @csrf @method('PUT')
                        <div class="form-group mb-3">
                            <label>Current Status</label>
                            <select name="status" class="form-control">
                                <option value="placed" @selected($order->status == 'placed')>Placed</option>
                                <option value="processing" @selected($order->status == 'processing')>Processing</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                                <option value="delivered" @selected($order->status == 'delivered')>Delivered</option>
                                <option value="canceled" @selected($order->status == 'canceled')>Canceled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Update Status</button>
                    </form>
                </div>
            </div>
            <div class="admin-surface">
                <div class="admin-surface-header"><h5 class="mb-0">Payment Information</h5></div>
                <div class="admin-surface-body">
                    <p><strong>Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->payment_status ?? 'pending') }}</p>
                    <p><strong>Paid at:</strong> {{ $order->paid_at?->format('M d, Y h:i A') ?? 'Pending' }}</p>
                    <p class="mb-0"><strong>Razorpay payment ID:</strong><br>{{ $order->razorpay_payment_id ?? 'N/A' }}
                    </p>
                </div>
            </div>
            <div class="admin-surface">
                <div class="admin-surface-header"><h5 class="mb-0">Customer Information</h5></div>
                <div class="admin-surface-body">
                    <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <hr>
                    <p><strong>Shipping Address:</strong><br>{{ $order->address }}<br>{{ $order->city }},
                        {{ $order->zip }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
