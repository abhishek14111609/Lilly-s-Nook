@extends('layouts.admin')
@section('title', 'Admin Customer #'.$user->id)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Customer Profile: {{ $user->name }}</h1>
        <p class="text-muted small mb-0">Lifetime Member since {{ $user->created_at->format('M Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark">Back to List</a>
    </div>
</div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">Profile Overview</div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Username:</strong> {{ $user->username }}</p>
                        <hr>
                        <p><strong>Total Lifetime Spend:</strong> &#8377;{{ number_format($totalSpent, 2) }}</p>
                        <p><strong>Total Orders:</strong> {{ $user->orders->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">Order History</div>
                    <div class="card-body p-0">
                        @if($user->orders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="bg-light">
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
                            <p class="p-4 text-muted text-center">No past orders found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

