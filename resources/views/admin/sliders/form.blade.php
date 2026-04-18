@extends('layouts.admin')
@section('title', $slider->exists ? 'Edit Slider' : 'Add Slider')
@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="h3 mb-4">{{ $slider->exists ? 'Edit Slider' : 'Create Slider' }}</h1>
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($method !== 'POST')
                            @method($method)
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $slider->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Subtitle</label>
                            <textarea name="subtitle" rows="3" class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $slider->subtitle) }}</textarea>
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Button Text</label>
                                <input type="text" name="button_text"
                                    class="form-control @error('button_text') is-invalid @enderror"
                                    value="{{ old('button_text', $slider->button_text) }}">
                                @error('button_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Button URL</label>
                                <input type="text" name="button_url"
                                    class="form-control @error('button_url') is-invalid @enderror"
                                    value="{{ old('button_url', $slider->button_url) }}"
                                    placeholder="{{ route('shop.index') }}">
                                @error('button_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Slider Image {{ $slider->exists ? '' : '*' }}</label>
                            <input type="file" name="image_file" accept="image/*"
                                class="form-control @error('image_file') is-invalid @enderror"
                                {{ $slider->exists ? '' : 'required' }}>
                            @error('image_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($slider->exists && $slider->image)
                                <div class="form-text small">Current: {{ $slider->image }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Slider Video (MP4, optional)</label>
                            <input type="file" name="video_file" accept="video/mp4"
                                class="form-control @error('video_file') is-invalid @enderror">
                            @error('video_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($slider->exists && $slider->video)
                                <div class="form-text small">Current: {{ $slider->video }}</div>
                            @endif
                            <div class="form-text small text-muted">Use this field for MP4 video uploads. Images still go in
                                the image field.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Sort Order</label>
                                <input type="number" name="sort_order" min="0"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        id="is_active"
                                        {{ old('is_active', $slider->exists ? $slider->is_active : true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active on homepage</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Slider</button>
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
