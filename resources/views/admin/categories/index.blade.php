@extends('layouts.admin')
@section('title', 'Manage Categories')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/categories.css') }}">
@endpush
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-2">Category Management</h1>
                <p class="text-muted mb-0">Organize your products with hierarchical categories and subcategories</p>
                <div class="mt-3">
                    <span class="badge-soft badge-soft-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $categoryTree->count() }} Main Categories
                    </span>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex gap-2 justify-content-md-end">
                    <button class="btn btn-primary" onclick="window.print()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Export Categories
                    </button>
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

    <div class="search-filters">
        <form action="{{ route('admin.categories.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filter Categories</label>
                    <select name="parent_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($parentOptions as $p)
                            <option value="{{ $p->id }}" {{ request('parent_id') == $p->id ? 'selected' : '' }}>
                                Subcategories of {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Type</label>
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="main" {{ request('type') == 'main' ? 'selected' : '' }}>Main Categories</option>
                        <option value="sub" {{ request('type') == 'sub' ? 'selected' : '' }}>Subcategories</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <th>Type</th>
                        <th>Parent Category</th>
                        <th>Products Count</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (request('parent_id'))
                        @forelse ($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="category-avatar bg-soft-info rounded d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ $category->name }}</h6>
                                            <small class="text-muted">Slug: {{ $category->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-soft badge-soft-info">Subcategory</span>
                                </td>
                                <td>
                                    @if ($category->parent)
                                        <span class="badge-soft badge-soft-primary">{{ $category->parent->name }}</span>
                                    @else
                                        <span class="text-muted">None (Top Level)</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $category->products->count() }}</div>
                                    <div class="text-muted small">products</div>
                                </td>
                                <td>
                                    <span class="badge-soft badge-soft-success">Active</span>
                                </td>
                                <td>
                                    <div class="action-buttons justify-content-center">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                            title="Edit Category">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.categories.make-main', $category) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to make this a main category?')">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm"
                                                data-bs-toggle="tooltip" title="Make Main Category">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category? This will affect all associated products.')">
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
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="mb-3">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                        </svg>
                                        <h5>No subcategories found</h5>
                                        <p class="text-muted">No subcategories found for the selected parent category</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    @else
                        @forelse ($categoryTree as $parentCategory)
                            <tr class="category-main-row">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="category-avatar bg-soft-success rounded d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ $parentCategory->name }}</h6>
                                            <small class="text-muted">Slug: {{ $parentCategory->slug }}</small>
                                            @if ($parentCategory->children->isNotEmpty())
                                                <div class="mt-1">
                                                    <span
                                                        class="badge-soft badge-soft-primary">{{ $parentCategory->children->count() }}
                                                        subcategories</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-soft badge-soft-success">Main Category</span>
                                </td>
                                <td>
                                    <span class="text-muted">None (Top Level)</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $parentCategory->products_count ?? 0 }}</div>
                                    <div class="text-muted small">products</div>
                                </td>
                                <td>
                                    <span class="badge-soft badge-soft-success">Active</span>
                                </td>
                                <td>
                                    <div class="action-buttons justify-content-center">
                                        <a href="{{ route('admin.categories.edit', $parentCategory) }}"
                                            class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                            title="Edit Category">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                        @if ($parentOptions->where('id', '!=', $parentCategory->id)->isNotEmpty())
                                            <form action="{{ route('admin.categories.set-parent', $parentCategory) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm"
                                                    data-bs-toggle="tooltip" title="Make Subcategory">
                                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="m9 18 6-6-6-6"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
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

                            @foreach ($parentCategory->children as $child)
                                <tr class="category-sub-row">
                                    <td class="ps-5">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="category-avatar bg-soft-info rounded d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="m9 18 6-6-6-6"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">{{ $child->name }}</h6>
                                                <small class="text-muted">Slug: {{ $child->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-soft badge-soft-info">Subcategory</span>
                                    </td>
                                    <td>
                                        <span class="badge-soft badge-soft-primary">{{ $parentCategory->name }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-primary">{{ $child->products_count ?? 0 }}</div>
                                        <div class="text-muted small">products</div>
                                    </td>
                                    <td>
                                        <span class="badge-soft badge-soft-success">Active</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons justify-content-center">
                                            <a href="{{ route('admin.categories.edit', $child) }}"
                                                class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                title="Edit Category">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.categories.make-main', $child) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to make this a main category?')">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary btn-sm"
                                                    data-bs-toggle="tooltip" title="Make Main Category">
                                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.categories.destroy', $child) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip" title="Delete Category">
                                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
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
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
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
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ request('parent_id') ? $categories->firstItem() ?? 0 : $categoryTree->firstItem() ?? 0 }} to
            {{ request('parent_id') ? $categories->lastItem() ?? 0 : $categoryTree->lastItem() ?? 0 }} of
            {{ request('parent_id') ? $categories->total() : $categoryTree->count() }} categories
        </div>
        <div>
            {{ request('parent_id') ? $categories->links() : '' }}
        </div>
    </div>
@endsection
