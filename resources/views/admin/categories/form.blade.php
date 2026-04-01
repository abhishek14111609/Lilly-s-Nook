@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'Create Category')
@php $isEdit = isset($category); @endphp
@section('content')
    <div class="row">
        <div class="col-md-7 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">{{ $isEdit ? 'Edit Category' : 'Create Category' }}</h1>
                    <p class="text-muted small">Fill in the form to {{ $isEdit ? 'update' : 'add' }} your store's product
                        categories.</p>
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
                            <input type="file" name="image_file" accept="image/*"
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
@endsection
