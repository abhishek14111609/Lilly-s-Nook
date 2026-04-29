@extends('layouts.admin')
@section('title', $slider->exists ? 'Edit Slider' : 'Add Slider')

@section('content')
    <div class="page-header">
        <div class="admin-form-header">
            <div>
                <p class="text-uppercase text-muted small mb-1">Hero slider editor</p>
                <h1 class="h3 mb-2">{{ $slider->exists ? 'Edit Slider' : 'Create Slider' }}</h1>
                <p class="text-muted mb-0">Build homepage hero slides with better use of space for copy, controls, and media.</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-dark">Back to Sliders</a>
            </div>
        </div>
    </div>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="admin-form-layout">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="admin-form-stack">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Slider Copy</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $slider->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Subtitle</label>
                        <textarea name="subtitle" rows="6" class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $slider->subtitle) }}</textarea>
                        @error('subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Button Text</label>
                            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror"
                                value="{{ old('button_text', $slider->button_text) }}">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Button URL</label>
                            <input type="text" name="button_url" class="form-control @error('button_url') is-invalid @enderror"
                                value="{{ old('button_url', $slider->button_url) }}" placeholder="{{ route('shop.index') }}">
                            @error('button_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-stack">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Media</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Media Type</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="media_type" id="media_type_image" value="image" {{ old('media_type', ($slider->exists && $slider->video && !$slider->image) ? 'video' : 'image') === 'image' ? 'checked' : '' }}>
                                <label class="form-check-label" for="media_type_image">Image</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="media_type" id="media_type_video" value="video" {{ old('media_type', ($slider->exists && $slider->video && !$slider->image) ? 'video' : 'image') === 'video' ? 'checked' : '' }}>
                                <label class="form-check-label" for="media_type_video">Video</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 media-section" id="image-section">
                        <label class="form-label fw-bold">Slider Image {{ $slider->exists ? '' : '*' }}</label>
                        <div id="slider-image-preview"
                            class="mb-3 border rounded d-flex align-items-center justify-content-center bg-light"
                            style="height: 180px; overflow: hidden;">
                            @if ($slider->exists && $slider->image)
                                <img src="{{ asset('images/' . ltrim($slider->image, '/')) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('storage/' . ltrim($slider->image, '/')) }}';"
                                    alt="Current slider image"
                                    style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            @else
                                <span class="text-muted small">Image preview</span>
                            @endif
                        </div>
                        <input type="file" name="image_file" accept="image/*" id="slider-image-file"
                            class="form-control @error('image_file') is-invalid @enderror"
                            data-existing="{{ $slider->exists && $slider->image ? 'true' : '' }}">
                        @error('image_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 media-section" id="video-section">
                        <label class="form-label fw-bold">Slider Video (MP4)</label>
                        <div id="slider-video-preview"
                            class="mb-3 border rounded d-flex align-items-center justify-content-center bg-dark"
                            style="height: 180px; overflow: hidden;">
                            @if ($slider->exists && $slider->video)
                                <video controls preload="metadata" style="width: 100%; height: 100%; object-fit: contain;">
                                    <source src="{{ asset(ltrim($slider->video, '/')) }}" type="video/mp4">
                                </video>
                            @else
                                <span class="text-white-50 small">Video preview</span>
                            @endif
                        </div>
                        <input type="file" name="video_file" accept="video/mp4" id="slider-video-file"
                            class="form-control @error('video_file') is-invalid @enderror"
                            data-existing="{{ $slider->exists && $slider->video ? 'true' : '' }}">
                        @error('video_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                    {{ old('is_active', $slider->exists ? $slider->is_active : true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active on homepage</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-inline-actions">
                <button type="submit" class="btn btn-primary">Save Slider</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            const sliderImageInput = document.getElementById('slider-image-file');
            const sliderImagePreview = document.getElementById('slider-image-preview');
            const sliderVideoInput = document.getElementById('slider-video-file');
            const sliderVideoPreview = document.getElementById('slider-video-preview');

            const mediaTypeRadios = document.querySelectorAll('input[name="media_type"]');
            const imageSection = document.getElementById('image-section');
            const videoSection = document.getElementById('video-section');

            function toggleMediaSections() {
                const selectedType = document.querySelector('input[name="media_type"]:checked').value;
                if (selectedType === 'image') {
                    imageSection.style.display = 'block';
                    videoSection.style.display = 'none';
                    if (!sliderImageInput.dataset.existing) sliderImageInput.required = true;
                    sliderVideoInput.required = false;
                } else {
                    imageSection.style.display = 'none';
                    videoSection.style.display = 'block';
                    sliderImageInput.required = false;
                    if (!sliderVideoInput.dataset.existing) sliderVideoInput.required = true;
                }
            }

            if (mediaTypeRadios.length) {
                mediaTypeRadios.forEach(radio => radio.addEventListener('change', toggleMediaSections));
                toggleMediaSections(); // Initialize
            }

            if (sliderImageInput && sliderImagePreview) {
                sliderImageInput.addEventListener('change', function(event) {
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

                        sliderImagePreview.innerHTML =
                            `<img src="${source}" alt="Slider image preview" style="max-height: 100%; max-width: 100%; object-fit: contain;">`;
                    };
                    reader.readAsDataURL(file);
                });
            }

            if (sliderVideoInput && sliderVideoPreview) {
                sliderVideoInput.addEventListener('change', function(event) {
                    const file = event.target.files && event.target.files[0];
                    if (!file || file.type !== 'video/mp4') {
                        return;
                    }

                    const source = URL.createObjectURL(file);
                    sliderVideoPreview.innerHTML =
                        `<video controls preload="metadata" style="width: 100%; height: 100%; object-fit: contain;"><source src="${source}" type="video/mp4"></video>`;
                });
            }
        </script>
    @endpush
@endsection
