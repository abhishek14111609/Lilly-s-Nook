@extends('layouts.admin')
@section('title', $review->exists ? 'Edit Review' : 'Add Review')
@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="h3 mb-4">{{ $review->exists ? 'Edit Review' : 'Create Review' }}</h1>
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @if ($method !== 'POST')
                            @method($method)
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product (Optional)</label>
                            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                                <option value="">Homepage testimonial / generic review</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ (string) old('product_id', $review->product_id) === (string) $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $review->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Role</label>
                                <input type="text" name="role"
                                    class="form-control @error('role') is-invalid @enderror"
                                    value="{{ old('role', $review->role) }}" placeholder="Fashion Blogger">
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Review Text</label>
                            <textarea name="quote" rows="4" class="form-control @error('quote') is-invalid @enderror" required>{{ old('quote', $review->quote) }}</textarea>
                            @error('quote')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Rating (1-5)</label>
                                <input type="number" min="1" max="5" name="rating"
                                    class="form-control @error('rating') is-invalid @enderror"
                                    value="{{ old('rating', $review->rating ?? 5) }}" required>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Sort Order</label>
                                <input type="number" min="0" name="sort_order"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', $review->sort_order ?? 0) }}">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        id="is_active"
                                        {{ old('is_active', $review->exists ? $review->is_active : true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Approved / Visible</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Review</button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
