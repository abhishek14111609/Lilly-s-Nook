@extends('layouts.admin')
@section('title', 'Edit Customer')

@section('content')
    <div class="page-header">
        <div class="admin-form-header">
            <div>
                <p class="text-uppercase text-muted small mb-1">Customer editor</p>
                <h1 class="h3 mb-2">Edit Customer #{{ $user->id }}</h1>
                <p class="text-muted mb-0">Update customer account details in a cleaner full-width editing layout.</p>
            </div>
            <div class="admin-inline-actions">
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-dark">Back to Profile</a>
            </div>
        </div>
    </div>

    <div class="admin-form-layout">
        <div class="admin-form-stack">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Account Details</h5>
                </div>
                <div class="admin-surface-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg" value="{{ old('username', $user->username) }}" required>
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="admin-inline-actions">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="admin-form-stack">
            <div class="admin-surface">
                <div class="admin-surface-header">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="admin-surface-body">
                    <p class="text-muted">Deleting this account will permanently remove the user from the system.</p>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="post"
                        onsubmit="return confirm('Are you sure you want to permanently delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Delete Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
