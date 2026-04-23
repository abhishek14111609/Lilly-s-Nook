@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'Create Category')
@php $isEdit = isset($category); @endphp

@section('content')
    <div class="page-header">
        <div class="admin-form-header">
            <div>
                <p class="text-uppercase text-muted small mb-1">Category details</p>
                <h1 class="h3 mb-2">{{ $isEdit ? 'Edit Category' : 'Create Category' }}</h1>
                <p class="text-muted mb-0">Keep main categories and nested groups clear, organized, and easy to browse.</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">Back to List</a>
            </div>
        </div>
    </div>

    <form action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        method="POST" enctype="multipart/form-data" class="admin-form-layout">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="admin-form-stack">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Category Type</label>
                        <div class="alert alert-light border mb-0 py-3">
                            {{ old('parent_id', $category->parent_id ?? '') ? 'Subcategory' : 'Main Category' }}
                            <div class="text-muted small mt-1">Select a parent category below only if this should be nested.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                            placeholder="e.g., Children's Wear" value="{{ old('name', $category->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6"
                            placeholder="Briefly describe what this category contains...">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-stack">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Organization</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-0">
                        <label class="form-label fw-bold">Parent Category</label>
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
                    </div>
                </div>
            </div>

            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Media</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Card Image</label>
                        <div id="category-image-preview"
                            class="mb-3 border rounded d-flex align-items-center justify-content-center bg-light"
                            style="height: 180px; overflow: hidden;">
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
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Category Video (MP4)</label>
                        <input type="file" name="video_file" accept="video/mp4"
                            class="form-control @error('video_file') is-invalid @enderror">
                        @error('video_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="video" value="{{ old('video', $category->video ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="admin-inline-actions">
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Category' : 'Save Category' }}</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

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
                        const source = loadEvent.target && loadEvent.target.result ? String(loadEvent.target.result) : '';
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
