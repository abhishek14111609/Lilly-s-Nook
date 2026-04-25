@extends('layouts.admin')

@section('title', 'Categories - Lilly\'s Nook')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Categories</h1>
            <p class="text-muted small mb-0">Organize your collection items into a logical hierarchy.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Main Category
        </a>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-soft-success">
                <div class="small fw-bold text-success text-uppercase mb-1">Main Categories</div>
                <div class="h4 fw-bold mb-0 text-dark">{{ $categoryTree->count() }}</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-soft-primary">
                <div class="small fw-bold text-primary text-uppercase mb-1">Total Subcategories</div>
                <div class="h4 fw-bold mb-0 text-dark">{{ \App\Models\Category::whereNotNull('parent_id')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-mobile-stack">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0 py-3">Category</th>
                        <th class="border-0 py-3">Slugs / Tree</th>
                        <th class="border-0 py-3">Inventory Count</th>
                        <th class="text-end pe-4 border-0 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categoryTree as $category)
                        <tr>
                            <td class="ps-4" data-label="Category">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 border overflow-hidden d-flex align-items-center justify-content-center bg-white" style="width: 48px; height: 48px; flex-shrink: 0;">
                                        @if ($category->image)
                                            <img src="{{ asset('images/' . $category->image) }}" class="w-100 h-100 object-fit-cover" alt="">
                                        @else
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                                        @endif
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-bold text-dark">{{ $category->name }}</div>
                                        <div class="text-muted text-xs">ID: #{{ $category->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Slugs / Tree">
                                <div class="badge bg-light text-dark border rounded-pill px-3 py-1 font-monospace text-xs">{{ $category->slug }}</div>
                                <div class="mt-1 d-flex align-items-center gap-1">
                                    <span class="text-xs text-muted">{{ $category->children->count() }} sub-items</span>
                                </div>
                            </td>
                            <td data-label="Inventory Count">
                                <div class="fw-bold text-dark">{{ $category->products_count ?? 0 }}</div>
                                <small class="text-muted text-xs text-uppercase">Total Products</small>
                            </td>
                            <td class="text-end pe-4" data-label="Actions">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-white btn-sm rounded-circle border shadow-sm p-2" title="Edit">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category and its associations?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm rounded-circle border shadow-sm p-2 text-danger" title="Delete">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#dee2e6" stroke-width="1.5" class="mb-3"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                                    <h5 class="fw-bold">No categories defined</h5>
                                    <p class="text-muted small">Start by creating a top-level category.</p>
                                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill px-4">New Category</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
