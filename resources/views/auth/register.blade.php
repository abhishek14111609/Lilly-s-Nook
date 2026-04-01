@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section class="padding-large">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row g-0 shadow-sm border rounded overflow-hidden bg-white">
                        <div class="col-md-5 p-4 p-md-5"
                            style="background: linear-gradient(140deg, #78350f, #a16207); color: #fff;">
                            <p class="text-uppercase mb-2" style="letter-spacing: 1px; opacity: .8;">Join Lilly's Nook</p>
                            <h2 class="mb-3 text-white">Create Your Account</h2>
                            <p class="mb-0" style="opacity: .9;">Save favorites, track orders, and enjoy a smoother
                                shopping experience.</p>
                        </div>
                        <div class="col-md-7 p-4 p-md-5">
                            <form method="post" action="{{ route('register.store') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="username">Username *</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="{{ old('username') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email *</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password *</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password_confirmation">Confirm Password *</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </div>
                                <button class="btn btn-dark" type="submit">Create Account</button>
                            </form>
                            <p class="mt-3 mb-0">Already have an account? <a href="{{ route('login') }}">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
