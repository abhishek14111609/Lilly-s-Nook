@extends('layouts.admin')
@section('title', 'Admin Customers')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 mb-2">Customer Management</h1>
            <p class="text-muted mb-0">Manage and monitor all registered customer accounts</p>
            <div class="mt-3">
                <span class="badge-soft badge-soft-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    {{ $users->total() }} Total Customers
                </span>
            </div>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="d-flex gap-2 justify-content-md-end">
                <button class="btn btn-primary" onclick="window.print()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Export
                </button>
                <a href="#" onclick="alert('User creation not available in current system')" class="btn btn-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    Add Customer
                </a>
            </div>
        </div>
    </div>
</div>

<div class="search-filters">
    <form action="{{ route('admin.users.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Search Customers</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, username..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Registration Date</label>
                <select name="date_filter" class="form-select" onchange="this.form.submit()">
                    <option value="">All Time</option>
                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>This Year</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
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
                    <th class="ps-4">Customer Info</th>
                    <th>Contact Details</th>
                    <th>Registration</th>
                    <th>Status</th>
                    <th>Orders</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <span class="text-primary fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                    <small class="text-muted">@{{ $user->username }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2 text-muted">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <span class="text-muted">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $user->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $user->created_at->format('g:i A') }}</small>
                            </div>
                        </td>
                        <td>
                            @php
                                $status = 'active';
                                $statusClass = 'success';
                                if ($user->banned) {
                                    $status = 'banned';
                                    $statusClass = 'danger';
                                } elseif (!$user->active) {
                                    $status = 'inactive';
                                    $statusClass = 'warning';
                                }
                            @endphp
                            <span class="badge-soft badge-soft-{{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td>
                            <div class="text-center">
                                <span class="fw-bold text-primary">{{ $user->orders_count ?? 0 }}</span>
                                <div class="text-muted small">Orders</div>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons justify-content-center">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="View Details">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Edit Customer">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                @if (!$user->banned)
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Suspend Customer" onclick="alert('Suspend feature not available in current system')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} customers
    </div>
    <div>
        {{ $users->links() }}
    </div>
</div>
@endsection
