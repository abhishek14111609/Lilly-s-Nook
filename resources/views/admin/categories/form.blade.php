@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'Create Category')
@php $isEdit = isset($category); @endphp
@section('content')
    <div class="row">
        <div class="col-md-7 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Category details</p>
                    <h1 class="h3 mb-0">{{ $isEdit ? 'Edit Category' : 'Create Category' }}</h1>
                    <p class="text-muted small mb-0">Keep main categories and subcategories clear and easy to browse.</p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark px-4">Back to List</a>
            </div>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <form
                        action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-bold">Category Type</label>
                            <div class="alert alert-light border mb-0 py-3">
                                {{ old('parent_id', $category->parent_id ?? '') ? 'Subcategory' : 'Main Category' }}
                                <div class="text-muted small mt-1">Select a parent category below only if this should be
                                    nested.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                placeholder="e.g., Children's Wear" value="{{ old('name', $category->name ?? '') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small text-muted">A clear name helps your customers browse easily.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Parent Category (Optional)</label>
                            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                <option value="">None (Make this a Top Category)</option>
                                @foreach ($parentCategories as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small text-muted">Select a parent if this is a subcategory (e.g., 'Men's
                                Wear' for 'T-Shirts').</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Description (Optional)</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                placeholder="Briefly describe what this category contains...">{{ old('description', $category->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Card Image (Optional)</label>
                            <div id="category-image-preview"
                                class="mb-3 border rounded d-flex align-items-center justify-content-center bg-light"
                                style="height: 150px; overflow: hidden;">
                                @if (!empty($category->image ?? null))
                                    <img src="{{ asset('images/' . ltrim($category->image, '/')) }}"
                                        onerror="this.onerror=null;this.src='{{ asset('storage/' . ltrim($category->image, '/')) }}';"
                                        alt="Current category image"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                @else
                                    <span class="text-muted small">Preview</span>
                                @endif
                            </div>
                            <input type="file" name="image_file" accept="image/*" id="category-image-file"
                                class="form-control @error('image_file') is-invalid @enderror">
                            @error('image_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="image" value="{{ old('image', $category->image ?? '') }}">
                            @if (!empty($category->image ?? null))
                                <div class="form-text small text-muted">Current: {{ $category->image }}</div>
                            @endif
                            <div class="form-text small text-muted">Used on homepage category cards. Leave blank to use
                                default image.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Category Video (MP4, optional)</label>
                            <input type="file" name="video_file" accept="video/mp4"
                                class="form-control @error('video_file') is-invalid @enderror">
                            @error('video_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="video" value="{{ old('video', $category->video ?? '') }}">
                            @if (!empty($category->video ?? null))
                                <div class="form-text small text-muted">Current: {{ $category->video }}</div>
                            @endif
                            <div class="form-text small text-muted">Upload MP4 here. Do not use the image field for videos.
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-3 fw-bold">
                                {{ $isEdit ? 'Update Category' : 'Save Category' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const categoryImageInput = document.getElementById('category-image-file');
            const categoryImagePreview = document.getElementById('category-image-preview');

            if (categoryImageInput && categoryImagePreview) {
                categoryImageInput.addEventListener('change', function(event) {
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

                        categoryImagePreview.innerHTML =
                            `<img src="${source}" alt="Category image preview" style="max-height: 100%; max-width: 100%; object-fit: contain;">`;
                    };

                    reader.readAsDataURL(file);
                });
            }
        </script>
    @endpush
@endsection
