@extends('layouts.admin')
@section('title', 'Order Management')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="h3 mb-2">Order Management</h1>
                <p class="text-muted mb-0">Track, filter, and review every customer order from one organized view.</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <span class="badge-soft badge-soft-primary">{{ $orders->total() }} Orders</span>
            </div>
        </div>
    </div>

    <div class="search-filters">
        <form action="{{ route('admin.orders.index') }}" method="get">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" for="order-status-filter">Status</label>
                    <select id="order-status-filter" name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="placed" @selected($currentStatus == 'placed')>Placed</option>
                        <option value="processing" @selected($currentStatus == 'processing')>Processing</option>
                        <option value="shipped" @selected($currentStatus == 'shipped')>Shipped</option>
                        <option value="delivered" @selected($currentStatus == 'delivered')>Delivered</option>
                        <option value="canceled" @selected($currentStatus == 'canceled')>Canceled</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="custom-table">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th># Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="fw-semibold">#{{ $order->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $order->first_name }} {{ $order->last_name }}</div>
                                <small class="text-muted">{{ $order->email }}</small>
                            </td>
                            <td>{{ $order->ordered_at->format('M d, Y') }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
                            <td class="fw-semibold">&#8377;{{ number_format($order->total, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No orders found for the selected filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
        <div class="text-muted">
            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
        </div>
        <div>{{ $orders->links() }}</div>
    </div>
@endsection
