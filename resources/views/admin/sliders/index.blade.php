@extends('layouts.admin')
@section('title', 'Manage Home Sliders')
@section('content')
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Homepage Sliders</h1>
            <p class="text-muted small mb-0">Control hero slides shown on the user homepage.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Add Slider</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $slider)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold">{{ $slider->title }}</div>
                                <div class="text-muted small">{{ \Illuminate\Support\Str::limit($slider->subtitle, 65) }}
                                </div>
                            </td>
                            <td><code>{{ $slider->image }}</code></td>
                            <td>
                                <span
                                    class="badge {{ $slider->is_active ? 'bg-soft-success text-success' : 'bg-soft-secondary text-secondary' }}">
                                    {{ $slider->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td>{{ $slider->sort_order }}</td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.sliders.edit', $slider) }}"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                                        onsubmit="return confirm('Delete this slider?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No sliders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $sliders->links() }}</div>
@endsection
