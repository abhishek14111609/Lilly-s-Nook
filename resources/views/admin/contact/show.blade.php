@extends('layouts.admin')

@section('title', 'Inquiry Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Inquiry #{{ $message->id }}</h1>
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">Back to Inquiries</a>
    </div>

    <div class="card border-0 shadow-sm">
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
@endsection
