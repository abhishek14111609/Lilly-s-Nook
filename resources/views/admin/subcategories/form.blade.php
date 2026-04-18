@extends('layouts.admin')
@section('title', isset($subcategory->id) ? 'Edit Subcategory' : 'Create Subcategory')

@section('content')
    <div class="row">
        <div class="col-md-7 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">{{ isset($subcategory->id) ? 'Edit Subcategory' : 'Create Subcategory' }}</h1>
                    <p class="text-muted small mb-0">Keep subcategories under a main category.</p>
                </div>
                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-dark px-4">Back to List</a>
            </div>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @if ($method !== 'POST')
                            @method($method)
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-bold">Main Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                                required>
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

                        <div class="mb-4">
                            <label class="form-label fw-bold">Subcategory Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $subcategory->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $subcategory->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 fw-bold">
                                {{ isset($subcategory->id) ? 'Update Subcategory' : 'Save Subcategory' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
