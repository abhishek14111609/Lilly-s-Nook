@extends('layouts.admin')
@section('title', 'Admin Dashboard - Business Insights')
@section('content')
<div class="d-flex justify-content-between align-items-end mb-5">
    <div>
        <h1 class="h3 mb-0">Business Overview</h1>
        <p class="text-muted small mb-0">Track your store's performance at a glance.</p>
    </div>
    <div class="d-flex gap-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg>
            <span>Add Product</span>
        </a>
    </div>
</div>

<div class="admin-stats-grid">
    <!-- Stat Card 1 -->
    <div class="admin-stat-card border-primary">
        <div class="admin-stat-body">
            <div class="admin-stat-header">
                <span class="admin-stat-badge bg-soft-primary text-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    Revenue
                </span>
                <div class="admin-stat-icon bg-soft-primary text-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">&#8377;{{ number_format($metrics['total_sales'], 2) }}</div>
            <div class="admin-stat-label">Total lifetime earnings</div>
            <div class="admin-stat-trend positive">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                +12% from last month
            </div>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="admin-stat-card border-success">
        <div class="admin-stat-body">
            <div class="admin-stat-header">
                <span class="admin-stat-badge bg-soft-success text-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                        <path d="M3 6h18"></path>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    Orders
                </span>
                <div class="admin-stat-icon bg-soft-success text-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                        <path d="M3 6h18"></path>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">{{ number_format($metrics['total_orders']) }}</div>
            <div class="admin-stat-label">Processed transactions</div>
            <div class="admin-stat-trend positive">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                +8% from last month
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="admin-stat-card border-warning">
        <div class="admin-stat-body">
            <div class="admin-stat-header">
                <span class="admin-stat-badge bg-soft-warning text-warning">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7.5 4.27 9 5.15"></path>
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                        <path d="m3.3 7 8.7 5 8.7-5"></path>
                        <path d="M12 22V12"></path>
                    </svg>
                    Inventory
                </span>
                <div class="admin-stat-icon bg-soft-warning text-warning">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7.5 4.27 9 5.15"></path>
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                        <path d="m3.3 7 8.7 5 8.7-5"></path>
                        <path d="M12 22V12"></path>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">{{ number_format($metrics['total_products']) }}</div>
            <div class="admin-stat-label">Unique items listed</div>
            <div class="admin-stat-trend negative">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                    <polyline points="17 18 23 18 23 12"></polyline>
                </svg>
                -3% from last month
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="admin-stat-card border-dark">
        <div class="admin-stat-body">
            <div class="admin-stat-header">
                <span class="admin-stat-badge bg-soft-dark text-dark">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Audience
                </span>
                <div class="admin-stat-icon bg-soft-dark text-dark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">{{ number_format($metrics['total_customers']) }}</div>
            <div class="admin-stat-label">Registered customers</div>
            <div class="admin-stat-trend positive">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                +15% from last month
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">Recent Order Activity</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-lg">View All Orders</a>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light fw-bold text-uppercase">
                            <tr>
                                <th class="ps-4">ID & Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">#{{ $order->id }}</div>
                                    <small class="text-muted text-xs">{{ $order->user->name ?? $order->first_name }}</small>
                                </td>
                                <td class="text-muted small">{{ $order->ordered_at->format('M d, Y') }}</td>
                                <td class="fw-medium">&#8377;{{ number_format($order->total, 2) }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($order->status) {
                                            'delivered' => 'bg-soft-success text-success',
                                            'canceled' => 'bg-soft-danger text-danger',
                                            'shipped' => 'bg-soft-info text-info',
                                            'processing' => 'bg-soft-warning text-warning',
                                            default => 'bg-soft-secondary text-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-lg small">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-link text-primary fw-bold text-xs p-0">Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted small">No recent transaction data available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Insights -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="admin-card-title">Stock Vitality</h5>
            </div>
            <div class="admin-card-body">
                <div class="stock-alerts">
                    <div class="stock-alert-item">
                        <div class="stock-alert-header">
                            <span class="stock-alert-title">LOW STOCK ITEMS</span>
                            <span class="stock-alert-badge bg-danger text-white">Critical</span>
                        </div>
                        <div class="admin-progress">
                            <div class="admin-progress-bar bg-danger" style="width: 15%;"></div>
                        </div>
                        <div class="stock-alert-description">12 products are below your threshold (5 units).</div>
                    </div>

                    <div class="stock-alert-item healthy">
                        <div class="stock-alert-header">
                            <span class="stock-alert-title">ORDER FULFILLMENT</span>
                            <span class="stock-alert-badge bg-success text-white">Healthy</span>
                        </div>
                        <div class="admin-progress">
                            <div class="admin-progress-bar bg-success" style="width: 92%;"></div>
                        </div>
                        <div class="stock-alert-description">92% of orders were delivered within 48 hours this week.</div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-lg">
                        <h6 class="fw-bold mb-2 small">Admin Support</h6>
                        <p class="small text-muted mb-0">Need help managing your store? Check out the <a href="#" class="text-primary fw-bold">Admin Guide</a> or contact technical support.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
