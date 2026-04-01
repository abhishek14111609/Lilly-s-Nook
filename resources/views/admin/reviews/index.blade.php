@extends('layouts.admin')
@section('title', 'Manage Testimonials')
@section('content')
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Testimonials</h1>
            <p class="text-muted small mb-0">Manage customer reviews shown on the homepage slider rows.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">Add Testimonial</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Person</th>
                        <th>Quote</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold">{{ $review->name }}</div>
                                <small class="text-muted">{{ $review->role }}</small>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($review->quote, 90) }}</td>
                            <td>{{ $review->rating }}/5</td>
                            <td>
                                <span
                                    class="badge {{ $review->is_active ? 'bg-soft-success text-success' : 'bg-soft-secondary text-secondary' }}">{{ $review->is_active ? 'Active' : 'Hidden' }}</span>
                            </td>
                            <td>{{ $review->sort_order }}</td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.reviews.edit', $review) }}"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                        onsubmit="return confirm('Delete this testimonial?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No testimonials yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>
@endsection
