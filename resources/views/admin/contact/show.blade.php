@extends('layouts.admin')

@section('title', 'Inquiry Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Inquiry #{{ $message->id }}</h1>
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">Back to Inquiries</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="text-muted small d-block">Name</label>
                    <div>{{ $message->name }}</div>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small d-block">Email</label>
                    <div>{{ $message->email }}</div>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small d-block">Status</label>
                    <div>
                        @if ($message->read_at)
                            <span class="badge bg-success">Read</span>
                        @else
                            <span class="badge bg-warning text-dark">Unread</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="text-muted small d-block">Received At</label>
                <div>{{ $message->created_at?->format('d M Y h:i A') }}</div>
            </div>

            <div>
                <label class="text-muted small d-block">Message</label>
                <div class="p-3 bg-light rounded">{{ $message->message }}</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Reply via Email</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.contact-messages.reply', $message) }}">
                @csrf
                <div class="mb-3">
                    <label for="reply_message" class="form-label text-muted small fw-bold text-uppercase letter-spacing-1">Your Reply</label>
                    <textarea class="form-control @error('reply_message') is-invalid @enderror" id="reply_message" name="reply_message" rows="5" required placeholder="Type your reply here...">{{ old('reply_message') }}</textarea>
                    @error('reply_message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2 mb-1">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"></path>
                        </svg>
                        Send Reply via SMTP
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
