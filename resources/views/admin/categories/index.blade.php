@extends('layouts.admin')
@section('title', 'Manage Categories')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/categories.css') }}">
@endpush
@section('content')
    <div class="page-header admin-categories-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-2">Category Management</h1>
                <p class="text-muted mb-0">Organize your products with hierarchical categories and subcategories</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4 admin-category-stats">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-label">Main Categories</div>
                <div class="stat-card-value">{{ $stats['main_categories'] ?? $categoryTree->count() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-label">Subcategories</div>
                <div class="stat-card-value">{{ $stats['subcategories'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-label">Linked Products</div>
                <div class="stat-card-value">{{ $stats['total_products'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="search-filters">
        <form action="{{ route('admin.categories.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or slug"
                        value="{{ $search ?? request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Type</label>
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="">Main Categories</option>
                        <option value="main" @selected(($type ?? request('type')) === 'main')>Main Categories</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Clear</a>
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
                        <th class="ps-4">Category Information</th>
                        <th>Subcategories</th>
                        <th>Products Count</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categoryTree as $parentCategory)
                        <tr class="category-main-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="category-avatar bg-soft-success rounded overflow-hidden d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        @if (!empty($parentCategory->image))
                                            <img src="{{ asset('images/' . ltrim($parentCategory->image, '/')) }}"
                                                onerror="this.onerror=null;this.src='{{ asset('storage/' . ltrim($parentCategory->image, '/')) }}';"
                                                alt="{{ $parentCategory->name }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $parentCategory->name }}</h6>
                                        <small class="text-muted">Slug: {{ $parentCategory->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-soft badge-soft-primary">{{ $parentCategory->subcategories_count ?? 0 }}
                                    subcategories</span>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $parentCategory->products_count ?? 0 }}</div>
                                <div class="text-muted small">products</div>
                            </td>
                            <td>
                                <div class="action-buttons justify-content-center">
                                    <a href="{{ route('admin.categories.edit', $parentCategory) }}"
                                        class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit Category">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary btn-sm"
                                        data-bs-toggle="tooltip" title="Manage Subcategories">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 7h16"></path>
                                            <path d="M7 12h10"></path>
                                            <path d="M10 17h4"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $parentCategory) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this main category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                            title="Delete Category">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="mb-3">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                    <h5>No categories found</h5>
                                    <p class="text-muted">Start by creating your first product category</p>
                                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">Add
                                        First Category</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ $categoryTree->firstItem() ?? 0 }} to
            {{ $categoryTree->lastItem() ?? 0 }} of
            {{ $categoryTree->total() }} categories
        </div>
        <div>
            {{ $categoryTree->links() }}
        </div>
    </div>
@endsection
