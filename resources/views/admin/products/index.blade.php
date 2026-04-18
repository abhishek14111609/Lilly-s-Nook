@extends('layouts.admin')
@section('title', 'Admin Products Catalog')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-2">Product Management</h1>
                <p class="text-muted mb-0">Manage your inventory, pricing, and product catalog</p>
                <div class="mt-3">
                    <span class="badge-soft badge-soft-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        {{ $products->total() }} Products in Catalog
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
                        Export Catalog
                    </button>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="search-filters">
        <form action="{{ route('admin.products.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search Products</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by name, SKU, description..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $parent)
                            <option value="{{ $parent->id }}"
                                {{ request('category_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @foreach ($parent->children as $child)
                                <option value="{{ $child->id }}"
                                    {{ request('category_id') == $child->id ? 'selected' : '' }}>↳ {{ $child->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Stock</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock
                        </option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock
                        </option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out
                            of Stock</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price Range</label>
                    <select name="price_range" class="form-select" onchange="this.form.submit()">
                        <option value="">All Prices</option>
                        <option value="0-500" {{ request('price_range') == '0-500' ? 'selected' : '' }}>Under ₹500
                        </option>
                        <option value="500-1000" {{ request('price_range') == '500-1000' ? 'selected' : '' }}>₹500 -
                            ₹1,000</option>
                        <option value="1000-5000" {{ request('price_range') == '1000-5000' ? 'selected' : '' }}>₹1,000 -
                            ₹5,000</option>
                        <option value="5000+" {{ request('price_range') == '5000+' ? 'selected' : '' }}>Above ₹5,000
                        </option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Clear</a>
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
                        <th class="ps-4">Product Information</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock Status</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="product-avatar bg-soft-primary rounded overflow-hidden d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        @if ($product->image)
                                            <img src="{{ asset('images/' . ltrim($product->image, '/')) }}"
                                                onerror="this.onerror=null;this.src='{{ asset('storage/' . ltrim($product->image, '/')) }}';"
                                                alt="{{ $product->name }}" class="rounded"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <span class="text-primary fw-bold">#{{ $product->id }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $product->name }}</h6>
                                        <div class="d-flex gap-2">
                                            <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                            @if ($product->featured)
                                                <span class="badge-soft badge-soft-warning">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($product->category)
                                    <div>
                                        <span class="badge-soft badge-soft-primary">{{ $product->category->name }}</span>
                                        @if ($product->subcategory)
                                            <div class="text-muted small mt-1">{{ $product->subcategory->name }}</div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">Uncategorized</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-primary">₹{{ number_format($product->price, 2) }}</div>
                                @if ($product->sale_price && $product->sale_price < $product->price)
                                    <div class="text-muted small text-decoration-line-through">
                                        ₹{{ number_format($product->sale_price, 2) }}</div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $stockClass = 'success';
                                    $stockText = 'In Stock';
                                    if ($product->stock == 0) {
                                        $stockClass = 'danger';
                                        $stockText = 'Out of Stock';
                                    } elseif ($product->stock < 5) {
                                        $stockClass = 'warning';
                                        $stockText = 'Low Stock';
                                    }
                                @endphp
                                <div>
                                    <span class="badge-soft badge-soft-{{ $stockClass }}">
                                        {{ $stockText }}
                                    </span>
                                    <div class="text-muted small mt-1">{{ $product->stock }} units available</div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusClass = $product->status == 'active' ? 'success' : 'secondary';
                                    $statusText = ucfirst($product->status ?? 'inactive');
                                @endphp
                                <span class="badge-soft badge-soft-{{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons justify-content-center">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Edit Product">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Toggle Status"
                                        onclick="alert('Status toggle feature not available in current system')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="1" y="4" width="22" height="16" rx="2"
                                                ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                            title="Delete Product">
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
                                    <h5>No products found</h5>
                                    <p class="text-muted">Start by adding your first product to the catalog</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">Add First
                                        Product</a>
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
            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
        </div>
        <div>
            {{ $products->links() }}
        </div>
    </div>
@endsection
