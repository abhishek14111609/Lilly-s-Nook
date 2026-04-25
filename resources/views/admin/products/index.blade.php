@extends('layouts.admin')

@section('title', 'Product Management - Lilly\'s Nook')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Products Catalog</h1>
            <p class="text-muted small mb-0">Manage your collection items, dynamic pricing, and variants.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                New Product
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-soft-primary h-100">
                <div class="small fw-bold text-primary text-uppercase mb-1">Total Products</div>
                <div class="h4 fw-bold mb-0 text-dark">{{ $products->total() }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-soft-success h-100">
                <div class="small fw-bold text-success text-uppercase mb-1">Active Items</div>
                <div class="h4 fw-bold mb-0 text-dark">{{ \App\Models\Product::where('status', 'active')->count() }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-soft-warning h-100">
                <div class="small fw-bold text-warning text-uppercase mb-1">Low Stock</div>
                <div class="h4 fw-bold mb-0 text-dark">{{ \App\Models\Product::where('stock', '<', 5)->count() }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-soft-danger h-100">
                <div class="small fw-bold text-danger text-uppercase mb-1">Out of Stock</div>
                <div class="h4 fw-bold mb-0 text-dark">{{ \App\Models\Product::where('stock', 0)->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-3">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2">
                <div class="col-lg-4 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-0 py-2" placeholder="Search SKU or name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <select name="category_id" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $p)
                            <option value="{{ $p->id }}" @selected(request('category_id') == $p->id)>{{ $p->name }}</option>
                            @foreach ($p->children as $c)
                                <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>&nbsp;— {{ $c->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-3">
                    <select name="stock_status" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                        <option value="">Availability</option>
                        <option value="in_stock" @selected(request('stock_status') == 'in_stock')>In Stock</option>
                        <option value="low_stock" @selected(request('stock_status') == 'low_stock')>Low Stock</option>
                        <option value="out_of_stock" @selected(request('stock_status') == 'out_of_stock')>Out of Stock</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 flex-grow-1 flex-md-grow-0">Filter</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm rounded-pill px-4 border flex-grow-1 flex-md-grow-0">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-mobile-stack">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0 py-3">Product</th>
                        <th class="border-0 py-3">Price</th>
                        <th class="border-0 py-3">Inventory</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="text-end pe-4 border-0 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="ps-4" data-label="Product">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 border overflow-hidden d-flex align-items-center justify-content-center bg-white" style="width: 52px; height: 52px; flex-shrink: 0;">
                                        @if ($product->image)
                                            <img src="{{ asset('images/' . $product->image) }}" class="w-100 h-100 object-fit-cover" alt="">
                                        @else
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        @endif
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $product->name }}</div>
                                        <div class="text-muted text-xs text-uppercase font-monospace">{{ $product->sku ?? 'NO-SKU' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Price">
                                <div class="fw-bold text-dark">₹{{ number_format($product->price, 2) }}</div>
                                @if($product->category)
                                    <small class="text-muted d-block text-xs">{{ $product->category->name }}</small>
                                @endif
                            </td>
                            <td data-label="Inventory">
                                @php
                                    $lvl = $product->stock <= 0 ? 'danger' : ($product->stock < 10 ? 'warning' : 'success');
                                    $msg = $product->stock <= 0 ? 'Out of Stock' : ($product->stock < 10 ? 'Low Stock' : 'Healthy');
                                @endphp
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium small mb-1">{{ $product->stock }} units</span>
                                    <div class="progress" style="height: 4px; width: 80px;">
                                        <div class="progress-bar bg-{{ $lvl }}" style="width: {{ min(($product->stock/50)*100, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Status">
                                <span class="badge rounded-pill bg-soft-{{ $product->status == 'active' ? 'success' : 'secondary' }} text-{{ $product->status == 'active' ? 'success' : 'secondary' }} text-uppercase fw-bold px-3 py-1" style="font-size: 10px;">
                                    {{ $product->status ?? 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end pe-4" data-label="Actions">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-white btn-sm rounded-circle border shadow-sm p-2" title="Edit">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this product?')">
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
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#dee2e6" stroke-width="1.5" class="mb-3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    <h5 class="fw-bold">No products found</h5>
                                    <p class="text-muted small">Try refining your search or add a new item.</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-4">Create Product</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="text-muted small">Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} items</div>
        <div class="shadow-sm rounded-pill overflow-hidden">{{ $products->links() }}</div>
    </div>
@endsection
