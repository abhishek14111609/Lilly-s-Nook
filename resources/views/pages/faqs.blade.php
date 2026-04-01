@extends('layouts.app')

@section('title', 'FAQs')

@section('content')
    <!-- <section class="site-banner jarallax padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: center;">
        <div class="container"><h1 class="page-title">FAQs</h1></div>
    </section> -->

    <section class="padding-large">
        <div class="container">
            <div class="alert alert-info"><h4>How do I log in as admin?</h4><p>Use username <strong>admin</strong> and password <strong>Admin@123</strong>.</p></div>
            <div class="alert alert-info"><h4>Which payment method is active?</h4><p>The migrated Laravel version currently uses cash on delivery.</p></div>
            <div class="alert alert-info"><h4>What changed in Laravel?</h4><p>Routing, data access, authentication flow, admin product CRUD, cart, wishlist, checkout, and order tracking now run through Laravel.</p></div>
        </div>
    </section>
@endsection
