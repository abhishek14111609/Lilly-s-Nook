@extends('layouts.admin')
@section('title', 'Manage Subcategories')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">Subcategory Management</h1>
            <p class="text-muted mb-0">Create and organize product subcategories under main categories.</p>
        </div>
        <a href="{{ route('admin.subcategories.create') }}" class="btn btn-success">Add Subcategory</a>
    </div>

    <div class="custom-table">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Subcategory</th>
                        <th>Main Category</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subcategories as $subcategory)
                        <tr>
                            <td class="ps-4">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $subcategory->name }}</h6>
                                    <small class="text-muted">Slug: {{ $subcategory->slug }}</small>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="badge-soft badge-soft-primary">{{ $subcategory->category?->name ?? 'Unknown' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $subcategory->description ?: 'No description' }}</span>
                            </td>
                            <td>
                                <div class="action-buttons justify-content-center">
                                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this subcategory?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No subcategories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $subcategories->links() }}
    </div>
@endsection
