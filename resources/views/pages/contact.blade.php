@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <!-- <section class="site-banner jarallax padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: top;">
            <div class="container"><h1 class="page-title">Contact Us</h1></div>
        </section> -->

    <section class="contact-information padding-large">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="section-title">{{ $contactHeading }}</h2>
                    <p>{{ $contactDescription }}</p>
                    <ul class="list-unstyled list-icon">
                        <li><i class="icon icon-phone"></i> {{ $contactPhone }}</li>
                        <li><i class="icon icon-mail"></i> {{ $contactEmail }}</li>
                        <li><i class="icon icon-map-pin"></i> {{ $contactAddress }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h2 class="section-title">Send us a message</h2>
                    <form method="post" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="form-item">
                            <input type="text" name="name" placeholder="Name" class="u-full-width bg-light"
                                value="{{ old('name') }}" required>
                            <input type="email" name="email" placeholder="Email" class="u-full-width bg-light"
                                value="{{ old('email') }}" required>
                            <textarea class="u-full-width bg-light" name="message" placeholder="Message" style="height: 180px;" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-dark btn-full btn-medium">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
