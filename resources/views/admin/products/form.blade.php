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
                        <div class="mb-4">
                            <label class="form-label fw-bold">Base Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">&#8377;</span>
                                <input type="number" step="0.01" min="0.01" name="price"
                                    class="form-control form-control-lg" value="{{ old('price', $product->price) }}"
                                    required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">GST %</label>
                                <input type="number" step="0.1" name="gst_percentage" class="form-control" value="{{ old('gst_percentage', $product->gst_percentage) }}" placeholder="e.g. 18">
                            </div>
                            <div class="col-md-6 d-flex align-items-end pb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_gst_inclusive" value="1" id="is_gst_inclusive" {{ old('is_gst_inclusive', $product->is_gst_inclusive) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="is_gst_inclusive">Price is GST Inclusive</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">HSN Code</label>
                            <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code', $product->hsn_code) }}" placeholder="e.g. 6109">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Weight (in kg)</label>
                            <input type="number" step="0.001" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}" placeholder="e.g. 0.5">
                            <div class="form-text small">Used for shipping calculation.</div>
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
                                id="product-category" required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $parent)
                                    <option value="{{ $parent->id }}" class="fw-bold"
                                        {{ old('category_id', $product->category_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }} (Top Level)
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3 mb-0">
                            <label class="form-label fw-bold">Subcategory <span class="text-danger">*</span></label>
                            <select name="subcategory_id" id="product-subcategory"
                                class="form-control @error('subcategory_id') is-invalid @enderror" required>
                                <option value="">Select a subcategory</option>
                            </select>
                            @error('subcategory_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Product Placement</h5>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Primary Media Type</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="media_type" id="media_type_image" value="image" {{ old('media_type', ($product->exists && !empty($product->video) && empty($product->image)) ? 'video' : 'image') === 'image' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="media_type_image">Image</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="media_type" id="media_type_video" value="video" {{ old('media_type', ($product->exists && !empty($product->video) && empty($product->image)) ? 'video' : 'image') === 'video' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="media_type_video">Video</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0 media-section" id="image-section">
                            <label class="form-label fw-bold">Primary Product Image <span
                                    class="text-danger">*</span></label>
                            <div id="product-image-preview"
                                class="image-preview mb-3 border rounded d-flex align-items-center justify-content-center bg-light"
                                style="height: 150px;">
                                @if ($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" alt="Current product image"
                                        onerror="this.onerror=null;this.src='{{ asset('storage/' . ltrim($product->image, '/')) }}';"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                @else
                                    <span class="text-muted small">Preview</span>
                                @endif
                            </div>
                            <input type="file" name="image_file" accept="image/*" id="product-image-file"
                                class="form-control @error('image_file') is-invalid @enderror"
                                data-existing="{{ $product->exists && $product->image ? 'true' : '' }}">
                            @error('image_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="image" value="{{ old('image', $product->image) }}">
                            <div class="form-text small">Upload image file directly. Existing image is kept if you leave
                                this blank while editing.</div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3 d-flex justify-content-between align-items-center gap-3 flex-wrap">
                            <div>
                                <label class="form-label fw-bold mb-1">Gallery Images</label>
                                <div class="form-text small mb-0">Show more angles and details with extra product photos.
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                id="add-gallery-image-btn">+ Add Image</button>
                        </div>

                        <div id="gallery-upload-list" class="d-grid gap-3 mb-3">
                            <div class="gallery-upload-row">
                                <input type="file" name="gallery_files[]" accept="image/*"
                                    class="form-control @error('gallery_files.0') is-invalid @enderror">
                                @error('gallery_files.0')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if (!empty($product->gallery_images ?? []))
                            <div class="mb-4">
                                <div class="form-label fw-bold mb-2">Current Gallery Images</div>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($product->gallery_images as $galleryImage)
                                        <div class="position-relative border rounded-3 overflow-hidden bg-light" style="width: 120px; height: 120px;">
                                            <img src="{{ asset('images/' . $galleryImage) }}" alt="Gallery image" class="w-100 h-100 object-fit-cover">
                                            <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 p-1 text-center">
                                                <div class="form-check d-inline-block m-0">
                                                    <input class="form-check-input" type="checkbox" name="delete_gallery_images[]" value="{{ $galleryImage }}" id="delete_img_{{ $loop->index }}">
                                                    <label class="form-check-label text-white small" style="cursor: pointer;" for="delete_img_{{ $loop->index }}">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 mb-0 media-section" id="video-section">
                            <label class="form-label fw-bold">Product Video (MP4)</label>
                            <input type="file" name="video_file" accept="video/mp4"
                                class="form-control @error('video_file') is-invalid @enderror">
                            @error('video_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="video" value="{{ old('video', $product->video ?? '') }}">
                            @if (!empty($product->video ?? null))
                                <div class="form-text small">Current: {{ $product->video }}</div>
                            @endif
                            <div class="form-text small">Upload an MP4 video instead of an image as the primary product display.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            let variantIndex = {{ count(old('variants', $product->variants ?? [])) }};
            const subcategoriesByCategory = @json(collect($subcategories)->groupBy('category_id')->map(function ($items) {
                        return $items->map(function ($subcategory) {
                                return [
                                    'id' => $subcategory->id,
                                    'name' => $subcategory->name,
                                ];
                            })->values();
                    }));
            const categorySelect = document.getElementById('product-category');
            const subcategorySelect = document.getElementById('product-subcategory');
            const selectedSubcategoryId = '{{ old('subcategory_id', $product->subcategory_id ?? '') }}';

            function renderSubcategories(categoryId) {
                const options = ['<option value="">Select a subcategory</option>'];
                const items = subcategoriesByCategory[categoryId] || [];

                items.forEach((subcategory) => {
                    const selected = String(subcategory.id) === String(selectedSubcategoryId) ? 'selected' : '';
                    options.push(`<option value="${subcategory.id}" ${selected}>${subcategory.name}</option>`);
                });

                subcategorySelect.innerHTML = options.join('');
            }

            categorySelect.addEventListener('change', function() {
                renderSubcategories(this.value);
            });

            renderSubcategories(categorySelect.value);

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

            const mediaTypeRadios = document.querySelectorAll('input[name="media_type"]');
            const imageSection = document.getElementById('image-section');
            const videoSection = document.getElementById('video-section');
            const productImageInput = document.getElementById('product-image-file');
            const productImagePreview = document.getElementById('product-image-preview');

            function toggleMediaSections() {
                const selectedType = document.querySelector('input[name="media_type"]:checked').value;
                if (selectedType === 'image') {
                    imageSection.style.display = 'block';
                    videoSection.style.display = 'none';
                    if (!productImageInput.dataset.existing) productImageInput.required = true;
                } else {
                    imageSection.style.display = 'none';
                    videoSection.style.display = 'block';
                    productImageInput.required = false;
                }
            }

            if (mediaTypeRadios.length) {
                mediaTypeRadios.forEach(radio => radio.addEventListener('change', toggleMediaSections));
                toggleMediaSections();
            }

            if (productImageInput && productImagePreview) {
                productImageInput.addEventListener('change', function(event) {
                    const file = event.target.files && event.target.files[0];

                    if (!file || !file.type.startsWith('image/')) {
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(loadEvent) {
                        const source = loadEvent.target && loadEvent.target.result ? String(loadEvent.target
                            .result) : '';
                        if (!source) {
                            return;
                        }

                        productImagePreview.innerHTML =
                            `<img src="${source}" alt="Product image preview" style="max-height: 100%; max-width: 100%; object-fit: contain;">`;
                    };

                    reader.readAsDataURL(file);
                });
            }

            const galleryUploadList = document.getElementById('gallery-upload-list');
            const addGalleryImageBtn = document.getElementById('add-gallery-image-btn');

            if (galleryUploadList && addGalleryImageBtn) {
                addGalleryImageBtn.addEventListener('click', function() {
                    const row = document.createElement('div');
                    row.className = 'gallery-upload-row d-flex gap-2 align-items-start';
                    row.innerHTML = `
                        <input type="file" name="gallery_files[]" accept="image/*" class="form-control">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 remove-gallery-image">Remove</button>
                    `;
                    galleryUploadList.appendChild(row);
                });

                galleryUploadList.addEventListener('click', function(event) {
                    const removeButton = event.target.closest('.remove-gallery-image');
                    if (removeButton) {
                        const row = removeButton.closest('.gallery-upload-row');
                        if (row) {
                            row.remove();
                        }
                    }
                });
            }
        </script>
    @endpush
@endsection
