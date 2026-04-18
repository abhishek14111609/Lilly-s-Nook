@extends('layouts.admin')
@section('title', 'Manage Reviews')
@section('content')
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Product Reviews</h1>
            <p class="text-muted small mb-0">Approve, hide, and manage dynamic customer ratings and testimonials.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">Add Manual Review</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small text-muted mb-1">Search</label>
                    <input type="text" name="search" value="{{ $search }}" class="form-control"
                        placeholder="Customer, product, or review text">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="" {{ $statusFilter === '' ? 'selected' : '' }}>All</option>
                        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $statusFilter === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Type</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="ps-4">
                                <span
                                    class="badge {{ $review->product_id ? 'bg-soft-primary text-primary' : 'bg-soft-secondary text-secondary' }}">
                                    {{ $review->product_id ? 'Product Review' : 'Homepage Testimonial' }}
                                </span>
                            </td>
                            <td>{{ $review->product?->name ?? 'N/A' }}</td>
                            <td>
                                <div class="fw-semibold">{{ $review->name ?: $review->user?->name ?? 'Customer' }}</div>
                                <small class="text-muted">{{ $review->role ?: $review->user?->email ?? '-' }}</small>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($review->quote, 100) }}</td>
                            <td>{{ $review->rating }}/5</td>
                            <td>
                                <span
                                    class="badge {{ $review->is_active ? 'bg-soft-success text-success' : 'bg-soft-warning text-warning' }}">{{ $review->is_active ? 'Approved' : 'Pending/Hidden' }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <form action="{{ route('admin.reviews.toggle-status', $review) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            {{ $review->is_active ? 'Hide' : 'Approve' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.reviews.edit', $review) }}"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                        onsubmit="return confirm('Delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>
@endsection
