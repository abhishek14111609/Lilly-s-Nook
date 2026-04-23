@extends('layouts.admin')
@section('title', 'Admin Customer #'.$user->id)

@section('content')
    <div class="page-header">
        <div class="admin-dashboard-hero">
            <div>
                <p class="text-uppercase text-muted small mb-1">Customer profile</p>
                <h1 class="h3 mb-2">{{ $user->name }}</h1>
                <p class="text-muted mb-0">Lifetime member since {{ $user->created_at->format('M Y') }}</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary">Edit</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark">Back to List</a>
            </div>
        </div>
    </div>

    <div class="admin-detail-grid">
        <div class="admin-surface">
            <div class="admin-surface-header">
                <h5 class="mb-0">Profile Overview</h5>
            </div>
            <div class="admin-surface-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <hr>
                <p><strong>Total Lifetime Spend:</strong> &#8377;{{ number_format($totalSpent, 2) }}</p>
                <p class="mb-0"><strong>Total Orders:</strong> {{ $user->orders->count() }}</p>
            </div>
        </div>

        <div class="admin-surface">
            <div class="admin-surface-header">
                <h5 class="mb-0">Order History</h5>
            </div>
            <div class="admin-surface-body p-0">
                @if($user->orders->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr><th>Order ID</th><th>Date</th><th>Status</th><th>Total</th><th></th></tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->ordered_at->format('M d, Y') }}</td>
                                        <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
                                        <td>&#8377;{{ number_format($order->total, 2) }}</td>
                                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark">View Order</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="admin-empty text-muted">No past orders found.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
