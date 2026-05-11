@extends('layouts.admin')
@section('title', 'Site Content Settings')

@push('styles')
    <style>
        .content-editor-hero {
            position: relative;
            overflow: hidden;
            border-radius: 1.75rem;
            padding: 1.75rem;
            color: #fff;
            background: linear-gradient(135deg, #111827 0%, #1f2937 50%, #374151 100%);
            box-shadow: 0 1.5rem 3rem rgba(15, 23, 42, 0.14);
        }

        .content-editor-hero::after {
            content: '';
            position: absolute;
            right: -40px;
            bottom: -55px;
            width: 180px;
            height: 180px;
            border-radius: 999px;
            background: rgba(244, 143, 177, 0.14);
            filter: blur(10px);
            pointer-events: none;
        }

        .content-editor-kicker {
            letter-spacing: 0.14em;
        }

        .content-editor-hero h1 {
            font-family: 'Playfair Display', serif;
            letter-spacing: -0.03em;
            line-height: 1.08;
        }

        .content-editor-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .admin-form-stack {
            display: grid;
            gap: 1.25rem;
        }

        .admin-form-layout {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
        }

        .admin-surface {
            background: #fff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 1rem 2.5rem rgba(15, 23, 42, 0.06);
            height: 100%;
        }

        .admin-surface-header {
            padding: 1rem 1.25rem;
            background: linear-gradient(180deg, #fafbfc 0%, #f6f8fb 100%);
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .admin-surface-header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
        }

        .admin-surface-body {
            padding: 1.25rem;
        }

        .admin-inline-actions {
            display: flex;
            justify-content: flex-end;
            padding: 1rem 1.25rem;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 0.75rem 2rem rgba(15, 23, 42, 0.05);
        }

        .admin-surface .form-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .admin-surface .form-control,
        .admin-surface .form-select {
            border-radius: 1rem;
            border-color: #e5e7eb;
            min-height: 52px;
            padding: 0.85rem 1rem;
            box-shadow: none;
        }

        .admin-surface textarea.form-control {
            min-height: 140px;
        }

        .admin-surface .form-control:focus,
        .admin-surface .form-select:focus {
            border-color: rgba(244, 143, 177, 0.85);
            box-shadow: 0 0 0 0.2rem rgba(244, 143, 177, 0.14);
        }

        @media (max-width: 991.98px) {
            .admin-form-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {

            .content-editor-hero,
            .admin-surface,
            .admin-inline-actions {
                border-radius: 1.2rem;
            }

            .content-editor-hero {
                padding: 1.25rem;
            }

            .admin-surface-header,
            .admin-surface-body,
            .admin-inline-actions {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content-editor-hero mb-4">
        <div class="row g-3 align-items-end position-relative">
            <div class="col-lg-8 position-relative" style="z-index: 1;">
                <p class="content-editor-kicker text-uppercase small fw-semibold text-white-50 mb-2">Content settings</p>
                <h1 class="display-6 mb-3">Dynamic Site Content</h1>
                <p class="mb-0 text-white-75">Manage homepage, about page, contact page, and "Why Choose Us" content from one
                    clean editor.</p>
            </div>
            <div class="col-lg-4 position-relative text-lg-end" style="z-index: 1;">
                <div class="content-editor-badges justify-content-lg-end mb-2">
                    <span class="badge rounded-pill bg-white text-dark px-3 py-2">Homepage</span>
                    <span class="badge rounded-pill bg-white text-dark px-3 py-2">About</span>
                    <span class="badge rounded-pill bg-white text-dark px-3 py-2">Contact</span>
                </div>
                <p class="mb-0 text-white-50 small">Edits save to the live site as soon as you submit the form.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data"
        class="admin-form-stack">
        @csrf
        @method('PUT')

        <div class="admin-surface">
            <div class="admin-surface-header">
                <h5 class="mb-0">Homepage Hero Intro</h5>
            </div>
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
                <div class="admin-surface-header">
                    <h5 class="mb-0">Homepage About Section</h5>
                </div>
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
                <div class="admin-surface-header">
                    <h5 class="mb-0">About Page</h5>
                </div>
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
                            $aboutImageFallbackUrl = asset(
                                'storage/' . ltrim(str_replace('images/', '', $aboutImagePath), '/'),
                            );
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
                        <input type="hidden" name="about_image"
                            value="{{ old('about_image', $content['about_image']) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-layout">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Contact Page Details</h5>
                </div>
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
                <div class="admin-surface-header">
                    <h5 class="mb-0">Social Media Links</h5>
                </div>
                <div class="admin-surface-body">
                    <p class="text-muted small mb-3">These links appear in the footer and contact page.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Instagram URL</label>
                            <input type="url" name="social_instagram" class="form-control"
                                placeholder="https://instagram.com/lillysnook"
                                value="{{ old('social_instagram', $content['social_instagram']) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Facebook URL</label>
                            <input type="url" name="social_facebook" class="form-control"
                                placeholder="https://facebook.com/lillysnook"
                                value="{{ old('social_facebook', $content['social_facebook']) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Why Choose Us Cards</h5>
                </div>
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
                        const source = loadEvent.target && loadEvent.target.result ? String(loadEvent.target
                            .result) : '';
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
