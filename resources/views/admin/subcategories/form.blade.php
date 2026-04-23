@extends('layouts.admin')
@section('title', isset($subcategory->id) ? 'Edit Subcategory' : 'Create Subcategory')

@section('content')
    <div class="page-header">
        <div class="admin-form-header">
            <div>
                <p class="text-uppercase text-muted small mb-1">Subcategory details</p>
                <h1 class="h3 mb-2">{{ isset($subcategory->id) ? 'Edit Subcategory' : 'Create Subcategory' }}</h1>
                <p class="text-muted mb-0">Keep subcategories clearly mapped to their main category for easier browsing.</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-dark">Back to List</a>
            </div>
        </div>
    </div>

    <form action="{{ $action }}" method="POST" class="admin-form-layout">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="admin-form-stack">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Subcategory Information</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Subcategory Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $subcategory->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6">{{ old('description', $subcategory->description ?? '') }}</textarea>
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
                    <h5 class="mb-0">Parent Category</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-0">
                        <label class="form-label fw-bold">Main Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select main category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $subcategory->category_id ?? '') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="admin-inline-actions">
                <button type="submit" class="btn btn-primary">{{ isset($subcategory->id) ? 'Update Subcategory' : 'Save Subcategory' }}</button>
                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
@endsection
