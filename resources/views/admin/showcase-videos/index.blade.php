@extends('layouts.admin')

@section('title', 'Manage Showcase Videos')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Showcase Videos</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Showcase Videos</h1>
        <a href="{{ route('admin.showcase-videos.create') }}" class="btn btn-primary shadow-sm">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New Video
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $video)
                            <tr class="draggable-row" draggable="true" data-id="{{ $video->getKey() }}">
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border shadow-sm">{{ $video->order }}</span>
                                </td>
                                <td>
                                    @if ($video->thumbnail_path)
                                        <img src="{{ asset('images/' . $video->thumbnail_path) }}" alt="Thumbnail"
                                            class="rounded-3 object-fit-cover" width="80" height="60">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted"
                                            style="width: 80px; height: 60px;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M10 8v8l6-4-6-4Z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <h6 class="mb-1">{{ $video->title }}</h6>
                                </td>
                                <td>
                                    @if ($video->is_active)
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Active</span>
                                    @else
                                        <span
                                            class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.showcase-videos.edit', $video) }}"
                                            class="btn btn-sm btn-light border" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light border drag-handle"
                                            title="Drag to reorder" aria-label="Drag to reorder">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M10 6h10M10 12h10M10 18h10M4 6h.01M4 12h.01M4 18h.01"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.showcase-videos.destroy', $video) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this video?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border text-danger"
                                                title="Delete">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-3">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="opacity-50">
                                            <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                                            <path d="M10 8v8l6-4-6-4Z"></path>
                                        </svg>
                                    </div>
                                    <p class="mb-0">No videos found. Click 'Add New Video' to create one.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const tbody = document.querySelector('table.table tbody');
            if (!tbody) return;

            let dragSrc = null;

            function handleDragStart(e) {
                dragSrc = this;
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', this.dataset.id);
                this.classList.add('dragging');
            }

            function handleDragOver(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                const target = e.target.closest('tr.draggable-row');
                if (target && target !== dragSrc) {
                    const rect = target.getBoundingClientRect();
                    const next = (e.clientY - rect.top) > (rect.height / 2);
                    tbody.insertBefore(dragSrc, next ? target.nextSibling : target);
                }
            }

            function handleDragEnd() {
                this.classList.remove('dragging');
                // collect new order
                const order = Array.from(tbody.querySelectorAll('tr.draggable-row')).map((row) => row.dataset.id);
                // send to server
                fetch("{{ route('admin.showcase-videos.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        order
                    })
                }).then(r => r.json()).then(data => {
                    // update badges to reflect new positions (1-based)
                    tbody.querySelectorAll('tr.draggable-row').forEach((row, idx) => {
                        const badge = row.querySelector('td:first-child .badge');
                        if (badge) badge.textContent = idx + 1;
                    });
                }).catch(() => {
                    // ignore errors for now
                });
            }

            tbody.querySelectorAll('tr.draggable-row').forEach(function(row) {
                row.addEventListener('dragstart', handleDragStart, false);
                row.addEventListener('dragover', handleDragOver, false);
                row.addEventListener('dragend', handleDragEnd, false);
            });
        })();
    </script>
@endpush
