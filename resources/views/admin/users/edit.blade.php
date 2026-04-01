@extends('layouts.admin')
@section('title', 'Edit Customer')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white border-bottom-0 pb-0">
                <h1 class="h4 mb-0">Edit Customer #{{ $user->id }}</h1>
                <p class="text-muted small mb-0">Update customer account details below.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.users.update', $user) }}" method="post">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control form-control-lg" value="{{ old('username', $user->username) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="d-flex gap-2 mb-3">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Update Profile</button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
                    </div>
                </form>
                <hr class="my-4">
                <form action="{{ route('admin.users.destroy', $user) }}" method="post" onsubmit="return confirm('Are you sure you want to permanently delete this user?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 py-2">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

