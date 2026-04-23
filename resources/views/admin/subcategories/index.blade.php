@extends('layouts.admin')
@section('title', 'Manage Subcategories')

@section('content')
    <div class="page-header">
        <div class="admin-dashboard-hero">
            <div>
                <h1 class="h3 mb-2">Subcategory Management</h1>
                <p class="text-muted mb-0">Organize subcategories under their parent categories and keep browsing tidy.</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.subcategories.create') }}" class="btn btn-success">Add Subcategory</a>
            </div>
        </div>
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
                                <span class="badge-soft badge-soft-primary">{{ $subcategory->category?->name ?? 'Unknown' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $subcategory->description ?: 'No description' }}</span>
                            </td>
                            <td>
                                <div class="action-buttons justify-content-center">
                                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="btn btn-primary btn-sm">Edit</a>
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

    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
        <div class="text-muted">
            Showing {{ $subcategories->firstItem() ?? 0 }} to {{ $subcategories->lastItem() ?? 0 }} of {{ $subcategories->total() }} subcategories
        </div>
        <div>{{ $subcategories->links() }}</div>
    </div>
@endsection
