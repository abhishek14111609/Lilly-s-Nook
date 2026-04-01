@extends('layouts.admin')
@section('title', $product->exists ? 'Edit Product' : 'Add Product')
@section('content')
    <form method="post" action="{{ $action }}" id="product-form" enctype="multipart/form-data">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">{{ $product->exists ? 'Edit Product' : 'Add New Product' }}</h1>
                <p class="text-muted small mb-0">Fill in the details to list your product in the storefront.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark px-4">Cancel</a>
                <button class="btn btn-primary px-4 shadow-sm fw-bold"
                    type="submit">{{ $product->exists ? 'Update Product' : 'Publish Product' }}</button>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">General Information</h5>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}" placeholder="e.g., Casual Cotton T-Shirt"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Detailed Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="8"
                                placeholder="Tell your customers more about this item...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Variants Table -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title fw-bold mb-0">Sizes & Stock Variants</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-variant-btn">+ Add
                                Size/Color</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle" id="variants-table">
                                <thead class="bg-light small fw-bold text-uppercase">
                                    <tr>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Stock</th>
                                        <th>Price Mod (+/-)</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="variants-body">
                                    @php $variants = old('variants', $product->variants ?? []); @endphp
                                    @forelse($variants as $index => $variant)
                                        <tr class="variant-row">
                                            <td><input type="text" name="variants[{{ $index }}][size]"
                                                    class="form-control form-control-sm"
                                                    value="{{ $variant['size'] ?? '' }}" placeholder="S, M, L..."></td>
                                            <td><input type="text" name="variants[{{ $index }}][color]"
                                                    class="form-control form-control-sm"
                                                    value="{{ $variant['color'] ?? '' }}" placeholder="Red, Blue..."></td>
                                            <td><input type="number" name="variants[{{ $index }}][stock]"
                                                    class="form-control form-control-sm"
                                                    value="{{ $variant['stock'] ?? 0 }}" min="0"></td>
                                            <td><input type="number" step="0.01"
                                                    name="variants[{{ $index }}][price_modifier]"
                                                    class="form-control form-control-sm"
                                                    value="{{ $variant['price_modifier'] ?? 0 }}"></td>
                                            <td><button type="button"
                                                    class="btn btn-sm btn-link text-danger remove-variant">Remove</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="no-variants">
                                            <td colspan="5" class="text-center py-3 text-muted small">No specific
                                                variants added yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Price & Global Stock -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Inventory & Pricing</h5>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Base Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">&#8377;</span>
                                <input type="number" step="0.01" min="0.01" name="price"
                                    class="form-control form-control-lg" value="{{ old('price', $product->price) }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Global Stock <span class="text-danger">*</span></label>
                            <input type="number" min="0" name="stock" class="form-control"
                                value="{{ old('stock', $product->stock ?? 0) }}" required>
                            <div class="form-text small">This is the default stock if no variants are selected.</div>
                        </div>
                    </div>
                </div>

                <!-- Category Selection -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Organization</h5>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Product Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                                required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $parent)
                                    <option value="{{ $parent->id }}" class="fw-bold"
                                        {{ old('category_id', $product->category_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }} (Top Level)
                                    </option>
                                    @foreach ($parent->children as $child)
                                        <option value="{{ $child->id }}"
                                            {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;↳ {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Product Placement</h5>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Product Image <span class="text-danger">*</span></label>
                            <div class="image-preview mb-3 border rounded d-flex align-items-center justify-content-center bg-light"
                                style="height: 150px;">
                                @if ($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" alt="Current product image"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                @else
                                    <span class="text-muted small">Preview</span>
                                @endif
                            </div>
                            <input type="file" name="image_file" accept="image/*"
                                class="form-control @error('image_file') is-invalid @enderror"
                                {{ $product->exists ? '' : 'required' }}>
                            @error('image_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="image" value="{{ old('image', $product->image) }}">
                            <div class="form-text small">Upload image file directly. Existing image is kept if you leave
                                this blank while editing.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            let variantIndex = {{ count(old('variants', $product->variants ?? [])) }};

            document.getElementById('add-variant-btn').addEventListener('click', function() {
                const body = document.getElementById('variants-body');
                const noVariants = body.querySelector('.no-variants');
                if (noVariants) noVariants.remove();

                const row = document.createElement('tr');
                row.className = 'variant-row';
                row.innerHTML = `
            <td><input type="text" name="variants[${variantIndex}][size]" class="form-control form-control-sm" placeholder="e.g., L"></td>
            <td><input type="text" name="variants[${variantIndex}][color]" class="form-control form-control-sm" placeholder="e.g., Blue"></td>
            <td><input type="number" name="variants[${variantIndex}][stock]" class="form-control form-control-sm" value="0" min="0"></td>
            <td><input type="number" step="0.01" name="variants[${variantIndex}][price_modifier]" class="form-control form-control-sm" value="0"></td>
            <td><button type="button" class="btn btn-sm btn-link text-danger remove-variant">Remove</button></td>
        `;
                body.appendChild(row);
                variantIndex++;
            });

            document.getElementById('variants-body').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant')) {
                    e.target.closest('tr').remove();
                    if (document.querySelectorAll('.variant-row').length === 0) {
                        document.getElementById('variants-body').innerHTML =
                            '<tr class="no-variants"><td colspan="5" class="text-center py-3 text-muted small">No specific variants added yet.</td></tr>';
                    }
                }
            });
        </script>
    @endpush
@endsection
