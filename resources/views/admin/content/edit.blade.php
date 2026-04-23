@extends('layouts.admin')
@section('title', 'Site Content Settings')

@section('content')
    <div class="page-header">
        <div class="admin-form-header">
            <div>
                <p class="text-uppercase text-muted small mb-1">Content settings</p>
                <h1 class="h3 mb-2">Dynamic Site Content</h1>
                <p class="text-muted mb-0">Manage homepage, about page, contact page, and “Why Choose Us” content in a more spacious editor.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data" class="admin-form-stack">
        @csrf
        @method('PUT')

        <div class="admin-surface">
            <div class="admin-surface-header"><h5 class="mb-0">Homepage Hero Intro</h5></div>
            <div class="admin-surface-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Intro Text</label>
                    <textarea name="home_intro_text" rows="4" class="form-control" required>{{ old('home_intro_text', $content['home_intro_text']) }}</textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold">Age Groups (one per line)</label>
                    <textarea name="home_age_groups_text" rows="4" class="form-control" required>{{ old('home_age_groups_text', $content['home_age_groups_text']) }}</textarea>
                </div>
            </div>
        </div>

        <div class="admin-form-layout">
            <div class="admin-surface">
                <div class="admin-surface-header"><h5 class="mb-0">Homepage About Section</h5></div>
                <div class="admin-surface-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kicker</label>
                            <input type="text" name="home_about_kicker" class="form-control"
                                value="{{ old('home_about_kicker', $content['home_about_kicker']) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="home_about_title" class="form-control"
                                value="{{ old('home_about_title', $content['home_about_title']) }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="home_about_description" rows="4" class="form-control" required>{{ old('home_about_description', $content['home_about_description']) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Story Section Title</label>
                            <input type="text" name="home_story_title" class="form-control"
                                value="{{ old('home_story_title', $content['home_story_title']) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Collections Section Title</label>
                            <input type="text" name="home_collections_title" class="form-control"
                                value="{{ old('home_collections_title', $content['home_collections_title']) }}" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Collections Items (one per line)</label>
                        <textarea name="home_collections_items_text" rows="5" class="form-control" required>{{ old('home_collections_items_text', $content['home_collections_items_text']) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="admin-surface">
                <div class="admin-surface-header"><h5 class="mb-0">About Page</h5></div>
                <div class="admin-surface-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">About Title</label>
                        <input type="text" name="about_title" class="form-control"
                            value="{{ old('about_title', $content['about_title']) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">About Body 1</label>
                        <textarea name="about_body_one" rows="4" class="form-control" required>{{ old('about_body_one', $content['about_body_one']) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">About Body 2</label>
                        <textarea name="about_body_two" rows="4" class="form-control">{{ old('about_body_two', $content['about_body_two']) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Promise Section Title</label>
                        <input type="text" name="about_promise_title" class="form-control"
                            value="{{ old('about_promise_title', $content['about_promise_title']) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Promise Items (one per line)</label>
                        <textarea name="about_promise_items_text" rows="5" class="form-control" required>{{ old('about_promise_items_text', $content['about_promise_items_text']) }}</textarea>
                    </div>
                    @php
                        $aboutImagePath = ltrim((string) old('about_image', $content['about_image']), '/');
                        if (\Illuminate\Support\Str::startsWith($aboutImagePath, ['http://', 'https://'])) {
                            $aboutImageUrl = $aboutImagePath;
                            $aboutImageFallbackUrl = $aboutImagePath;
                        } elseif (\Illuminate\Support\Str::startsWith($aboutImagePath, 'images/')) {
                            $aboutImageUrl = asset($aboutImagePath);
                            $aboutImageFallbackUrl = asset('storage/' . ltrim(str_replace('images/', '', $aboutImagePath), '/'));
                        } else {
                            $aboutImageUrl = asset('images/' . $aboutImagePath);
                            $aboutImageFallbackUrl = asset('storage/' . $aboutImagePath);
                        }
                    @endphp
                    <div class="mb-0">
                        <label class="form-label fw-bold">About Image</label>
                        <div id="about-image-preview"
                            class="mb-3 border rounded d-flex align-items-center justify-content-center bg-light"
                            style="height: 180px; overflow: hidden;">
                            @if ($aboutImagePath !== '')
                                <img src="{{ $aboutImageUrl }}"
                                    onerror="this.onerror=null;this.src='{{ $aboutImageFallbackUrl }}';"
                                    alt="Current about image"
                                    style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            @else
                                <span class="text-muted small">Image preview</span>
                            @endif
                        </div>
                        <input type="file" name="about_image_file" accept="image/*" id="about-image-file"
                            class="form-control @error('about_image_file') is-invalid @enderror">
                        @error('about_image_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="about_image" value="{{ old('about_image', $content['about_image']) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-layout">
            <div class="admin-surface">
                <div class="admin-surface-header"><h5 class="mb-0">Contact Page Details</h5></div>
                <div class="admin-surface-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Heading</label>
                        <input type="text" name="contact_heading" class="form-control"
                            value="{{ old('contact_heading', $content['contact_heading']) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Description</label>
                        <textarea name="contact_description" rows="4" class="form-control" required>{{ old('contact_description', $content['contact_description']) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="contact_phone" class="form-control"
                                value="{{ old('contact_phone', $content['contact_phone']) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="contact_email" class="form-control"
                                value="{{ old('contact_email', $content['contact_email']) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" name="contact_address" class="form-control"
                                value="{{ old('contact_address', $content['contact_address']) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-surface">
                <div class="admin-surface-header"><h5 class="mb-0">Why Choose Us Cards</h5></div>
                <div class="admin-surface-body">
                    @for ($i = 0; $i < 4; $i++)
                        @php $item = $whyChooseUs[$i] ?? ['title' => '', 'description' => '', 'icon' => 'icon icon-star']; @endphp
                        <div class="border rounded p-3 mb-3">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label class="form-label small fw-bold">Title</label>
                                    <input type="text" name="why_choose_title[]" class="form-control"
                                        value="{{ old('why_choose_title.' . $i, $item['title']) }}">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-label small fw-bold">Icon Class</label>
                                    <input type="text" name="why_choose_icon[]" class="form-control"
                                        value="{{ old('why_choose_icon.' . $i, $item['icon']) }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Description</label>
                                    <input type="text" name="why_choose_description[]" class="form-control"
                                        value="{{ old('why_choose_description.' . $i, $item['description']) }}">
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="admin-inline-actions">
            <button type="submit" class="btn btn-primary">Save Content</button>
        </div>
    </form>

    @push('scripts')
        <script>
            const aboutImageInput = document.getElementById('about-image-file');
            const aboutImagePreview = document.getElementById('about-image-preview');

            if (aboutImageInput && aboutImagePreview) {
                aboutImageInput.addEventListener('change', function(event) {
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

                        aboutImagePreview.innerHTML =
                            `<img src="${source}" alt="About image preview" style="max-height: 100%; max-width: 100%; object-fit: contain;">`;
                    };
                    reader.readAsDataURL(file);
                });
            }
        </script>
    @endpush
@endsection
