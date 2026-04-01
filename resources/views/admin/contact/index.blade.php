@extends('layouts.admin')

@section('title', 'Customer Inquiries')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Customer Inquiries</h1>
            <p class="text-muted mb-0">Unread messages: <strong>{{ $unreadCount }}</strong></p>
        </div>
    </div>

    <form method="get" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Search name, email, or message">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="unread" @selected(request('status') === 'unread')>Unread</option>
                        <option value="read" @selected(request('status') === 'read')>Read</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($message->message, 80) }}</td>
                            <td>
                                @if ($message->read_at)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unread</span>
                                @endif
                            </td>
                            <td>{{ $message->created_at?->format('d M Y h:i A') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.contact-messages.show', $message) }}"
                                    class="btn btn-sm btn-outline-dark">View</a>
                                @if (!$message->read_at)
                                    <form method="post" action="{{ route('admin.contact-messages.mark-read', $message) }}"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Mark Read</button>
                                    </form>
                                @endif
                                <form method="post" action="{{ route('admin.contact-messages.destroy', $message) }}"
                                    class="d-inline" onsubmit="return confirm('Delete this inquiry permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $messages->links() }}
        </div>
    </div>
@endsection
