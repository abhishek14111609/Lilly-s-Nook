@extends('layouts.admin')
@section('title', 'Order Management')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Order Management</h1>
        <p class="text-muted small mb-0">Track and fulfill customer orders.</p>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>All Orders</h2>
    <form action="{{ route('admin.orders.index') }}" method="get" class="d-flex gap-2">
        <select name="status" class="form-control" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="placed" @selected($currentStatus == 'placed')>Placed</option>
            <option value="processing" @selected($currentStatus == 'processing')>Processing</option>
            <option value="shipped" @selected($currentStatus == 'shipped')>Shipped</option>
            <option value="delivered" @selected($currentStatus == 'delivered')>Delivered</option>
            <option value="canceled" @selected($currentStatus == 'canceled')>Canceled</option>
        </select>
    </form>
</div>
<table class="table">
    <thead><tr><th># Order ID</th><th>Customer</th><th>Date</th><th>Status</th><th>Total</th><th></th></tr></thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->first_name }} {{ $order->last_name }}<br><small class="text-muted">{{ $order->email }}</small></td>
                <td>{{ $order->ordered_at->format('M d, Y') }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
                <td>&#8377;{{ number_format($order->total, 2) }}</td>
                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary btn-sm">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection
