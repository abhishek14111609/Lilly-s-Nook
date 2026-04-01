@extends('layouts.admin')
@section('title', 'Site Content Settings')
@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h1 class="h3 mb-1">Dynamic Site Content</h1>
            <p class="text-muted mb-4">Manage About sections and Why Choose Us cards shown on user pages.</p>

            <form action="{{ route('admin.content.update') }}" method="POST" class="card shadow-sm border-0"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body p-4">
                    <h5 class="mb-3">Homepage About Section</h5>
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
                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="home_about_description" rows="3" class="form-control" required>{{ old('home_about_description', $content['home_about_description']) }}</textarea>
                    </div>

                    <h5 class="mb-3">About Page</h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">About Title</label>
                        <input type="text" name="about_title" class="form-control"
                            value="{{ old('about_title', $content['about_title']) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">About Body 1</label>
                        <textarea name="about_body_one" rows="3" class="form-control" required>{{ old('about_body_one', $content['about_body_one']) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">About Body 2</label>
                        <textarea name="about_body_two" rows="3" class="form-control">{{ old('about_body_two', $content['about_body_two']) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">About Image</label>
                        <input type="file" name="about_image_file" accept="image/*"
                            class="form-control @error('about_image_file') is-invalid @enderror">
                        @error('about_image_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="about_image" value="{{ old('about_image', $content['about_image']) }}">
                        <div class="form-text small text-muted">Current: {{ $content['about_image'] }}</div>
                    </div>

                    <h5 class="mb-3">Contact Page Details</h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Heading</label>
                        <input type="text" name="contact_heading" class="form-control"
                            value="{{ old('contact_heading', $content['contact_heading']) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Description</label>
                        <textarea name="contact_description" rows="3" class="form-control" required>{{ old('contact_description', $content['contact_description']) }}</textarea>
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
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" name="contact_address" class="form-control"
                                value="{{ old('contact_address', $content['contact_address']) }}" required>
                        </div>
                    </div>

                    <h5 class="mb-3">Why Choose Us Cards</h5>
                    @for ($i = 0; $i < 4; $i++)
                        @php $item = $whyChooseUs[$i] ?? ['title' => '', 'description' => '', 'icon' => 'icon icon-star']; @endphp
                        <div class="border rounded p-3 mb-3">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small fw-bold">Title</label>
                                    <input type="text" name="why_choose_title[]" class="form-control"
                                        value="{{ old('why_choose_title.' . $i, $item['title']) }}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small fw-bold">Icon Class</label>
                                    <input type="text" name="why_choose_icon[]" class="form-control"
                                        value="{{ old('why_choose_icon.' . $i, $item['icon']) }}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small fw-bold">Description</label>
                                    <input type="text" name="why_choose_description[]" class="form-control"
                                        value="{{ old('why_choose_description.' . $i, $item['description']) }}">
                                </div>
                            </div>
                        </div>
                    @endfor

                    <button type="submit" class="btn btn-primary">Save Content</button>
                </div>
            </form>
        </div>
    </div>
@endsection
