@extends('layouts.admin')
@section('title', 'Admin Dashboard - Lilly\'s Nook')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1">Business Overview</h2>
                <p class="text-muted mb-0">Track your store's performance at a glance.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg>
                    <span>Add Product</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Revenue Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-primary-subtle text-primary p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Revenue</p>
                    <h3 class="fw-bold mb-2">&#8377;{{ number_format($metrics['total_sales'], 2) }}</h3>
                    <div class="d-flex align-items-center gap-1 small">
                        <span class="text-success d-flex align-items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                            +12%
                        </span>
                        <span class="text-muted">vs last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-success-subtle text-success p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    </div>
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Orders</p>
                    <h3 class="fw-bold mb-2">{{ number_format($metrics['total_orders']) }}</h3>
                    <div class="d-flex align-items-center gap-1 small">
                        <span class="text-success d-flex align-items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                            +8%
                        </span>
                        <span class="text-muted">vs last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-warning-subtle text-warning p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"></path><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
                    </div>
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Inventory</p>
                    <h3 class="fw-bold mb-2">{{ number_format($metrics['total_products']) }}</h3>
                    <div class="d-flex align-items-center gap-1 small">
                        <span class="text-danger d-flex align-items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                            -3%
                        </span>
                        <span class="text-muted">vs last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audience Card -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-info-subtle text-info p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                    </div>
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Customers</p>
                    <h3 class="fw-bold mb-2">{{ number_format($metrics['total_customers']) }}</h3>
                    <div class="d-flex align-items-center gap-1 small">
                        <span class="text-success d-flex align-items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                            +15%
                        </span>
                        <span class="text-muted">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
                    <h5 class="fw-bold mb-0">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-4 border-0">Order ID</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0">Date</th>
                                    <th class="border-0">Amount</th>
                                    <th class="border-0">Status</th>
                                    <th class="text-end pe-4 border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="ps-4 fw-medium text-dark">#{{ $order->id }}</td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $order->user->username ?? $order->first_name }}</div>
                                            <small class="text-muted">{{ $order->email }}</small>
                                        </td>
                                        <td class="text-muted small">{{ $order->ordered_at->format('M d, Y') }}</td>
                                        <td class="fw-bold text-dark">&#8377;{{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match ($order->status) {
                                                    'delivered' => 'bg-success-subtle text-success border border-success-subtle',
                                                    'canceled' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                                    'shipped' => 'bg-info-subtle text-info border border-info-subtle',
                                                    'processing' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                                    default => 'bg-secondary-subtle text-secondary border border-secondary-subtle'
                                                };
                                            @endphp
                                            <span class="badge rounded-pill {{ $badgeClass }} px-3 fw-medium">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light border p-2 rounded-circle shadow-sm" title="Details">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <img src="{{ asset('images/empty-state.svg') }}" alt="No orders" class="mb-3 d-none" style="width: 120px;">
                                            <p class="mb-0">No recent transaction data available.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock & Insights -->
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Insights & Health</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small fw-bold text-uppercase">Stock Health</span>
                            <span class="badge bg-danger text-uppercase p-1" style="font-size: 10px;">Critical</span>
                        </div>
                        <div class="progress rounded-pill mb-2" style="height: 8px;">
                            <div class="progress-bar bg-danger rounded-pill" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="small text-muted mb-0">12 products are below your threshold (5 units).</p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small fw-bold text-uppercase">Fulfillment Rate</span>
                            <span class="badge bg-success text-uppercase p-1" style="font-size: 10px;">Healthy</span>
                        </div>
                        <div class="progress rounded-pill mb-2" style="height: 8px;">
                            <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="small text-muted mb-0">92% of orders were delivered within 48 hours this week.</p>
                    </div>

                    <div class="p-3 bg-primary-subtle rounded-3 border border-primary-subtle">
                        <h6 class="fw-bold text-primary mb-2 small">Admin Support</h6>
                        <p class="small text-primary-emphasis mb-2">Need help managing your store or analyzing trends?</p>
                        <a href="#" class="btn btn-sm btn-primary rounded-pill px-3">Read Guide</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
