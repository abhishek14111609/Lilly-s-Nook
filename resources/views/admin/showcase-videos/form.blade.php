@extends('layouts.admin')
@section('title', $video->exists ? 'Edit Showcase Video' : 'Add Showcase Video')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.showcase-videos.index') }}">Showcase Videos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $video->exists ? 'Edit' : 'Create' }}</li>
@endsection

@section('content')
    <div class="page-header">
        <div class="admin-form-header">
            <div>
                <p class="text-uppercase text-muted small mb-1">Portrait video editor</p>
                <h1 class="h3 mb-2">{{ $video->exists ? 'Edit Showcase Video' : 'Create Showcase Video' }}</h1>
                <p class="text-muted mb-0">Manage the portrait clips that appear on the homepage showcase section.</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.showcase-videos.index') }}" class="btn btn-outline-dark">Back to Videos</a>
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
                    <h5 class="mb-0">Video Details</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $video->title) }}" required placeholder="Example: Spring edit 01">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror"
                            placeholder="Short caption shown on the homepage showcase card.">{{ old('description', $video->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="order" min="0"
                                class="form-control @error('order') is-invalid @enderror"
                                value="{{ old('order', $video->order ?? 0) }}">
                            <div class="form-text">Lower numbers show first in the homepage showcase.</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                    id="is_active"
                                    {{ old('is_active', $video->exists ? $video->is_active : true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">Active on homepage</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Media Uploads</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Video File {{ $video->exists ? '' : '*' }}</label>
                                <div id="video-preview"
                                    class="mb-3 border rounded-4 d-flex align-items-center justify-content-center bg-dark overflow-hidden"
                                    style="min-height: 280px;">
                                    @if ($video->exists && $video->video_path)
                                        <video controls preload="metadata"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                            <source src="{{ asset($video->video_path) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <div class="text-center text-white-50 py-5 px-4">
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" class="mb-3 opacity-50">
                                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                                <path d="m10 9 5 3-5 3V9Z"></path>
                                            </svg>
                                            <div class="fw-semibold">Video preview</div>
                                            <div class="small">Upload a portrait MP4 to preview it here.</div>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="video_file" accept="video/mp4,video/quicktime,video/ogg"
                                    id="video-file" class="form-control @error('video_file') is-invalid @enderror"
                                    {{ $video->exists && $video->video_path ? '' : 'required' }}>
                                <div class="form-text">Recommended portrait format. Existing video remains if you do not
                                    upload a new one.</div>
                                @error('video_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Thumbnail</label>
                                <div id="thumbnail-preview"
                                    class="mb-3 border rounded-4 d-flex align-items-center justify-content-center bg-light overflow-hidden"
                                    style="min-height: 220px;">
                                    @if ($video->exists && $video->thumbnail_path)
                                        <img src="{{ asset('images/' . $video->thumbnail_path) }}" alt="Current thumbnail"
                                            style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                    @else
                                        <div class="text-center text-muted py-5 px-4">
                                            <svg width="42" height="42" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" class="mb-3 opacity-50">
                                                <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                <path d="m21 15-5-5L5 21"></path>
                                            </svg>
                                            <div class="fw-semibold">Thumbnail preview</div>
                                            <div class="small">Optional fallback image for the showcase card.</div>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="thumbnail_file" accept="image/*" id="thumbnail-file"
                                    class="form-control @error('thumbnail_file') is-invalid @enderror">
                                <div class="form-text">Optional. This is used as a fallback preview if the video is
                                    unavailable.</div>
                                @error('thumbnail_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-inline-actions">
                <button type="submit"
                    class="btn btn-primary">{{ $video->exists ? 'Update Video' : 'Save Video' }}</button>
                <a href="{{ route('admin.showcase-videos.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            const videoInput = document.getElementById('video-file');
            const videoPreview = document.getElementById('video-preview');
            const thumbnailInput = document.getElementById('thumbnail-file');
            const thumbnailPreview = document.getElementById('thumbnail-preview');

            if (videoInput && videoPreview) {
                videoInput.addEventListener('change', function(event) {
                    const file = event.target.files && event.target.files[0];
                    if (!file || !file.type.startsWith('video/')) {
                        return;
                    }

                    const url = URL.createObjectURL(file);
                    videoPreview.innerHTML = `
                        <video controls preload="metadata" style="width: 100%; height: 100%; object-fit: cover;">
                            <source src="${url}">
                        </video>
                    `;
                });
            }

            if (thumbnailInput && thumbnailPreview) {
                thumbnailInput.addEventListener('change', function(event) {
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

                        thumbnailPreview.innerHTML = `
                            <img src="${source}" alt="Thumbnail preview" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                        `;
                    };
                    reader.readAsDataURL(file);
                });
            }
        </script>
    @endpush
@endsection
