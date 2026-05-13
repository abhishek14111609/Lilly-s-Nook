@extends('layouts.app')

@section('title', 'Success - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center p-5 mb-5">
                    <div class="mb-4">
                        <div class="bg-soft-success text-success rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 80px; height: 80px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"></path></svg>
                        </div>
                    </div>
                    
                    <h1 class="display-5 fw-bold mb-3">Order Confirmed!</h1>
                    <p class="text-muted fs-5 mb-5 px-lg-5">Thank you for shopping with Lily's Nook. Your payment was successful, and we've started preparing your magical package for delivery.</p>
                    
                    <div class="row g-3 justify-content-center mb-5">
                        <div class="col-sm-auto">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-dark btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm">View Order #{{ $order->id }}</a>
                        </div>
                        <div class="col-sm-auto">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-dark btn-lg rounded-pill px-5 py-3 fw-bold border-2">Continue Shopping</a>
                        </div>
                    </div>

                    <div class="p-4 bg-light rounded-4 text-start">
                        <h6 class="fw-bold mb-3 text-uppercase small text-muted">What's next?</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex gap-3 mb-3">
                                <div class="text-primary fw-bold">01</div>
                                <div>
                                    <p class="fw-bold mb-0">Invoice Generated</p>
                                    <small class="text-muted">A digital receipt has been sent to your registered email.</small>
                                </div>
                            </li>
                            <li class="d-flex gap-3 mb-3">
                                <div class="text-primary fw-bold">02</div>
                                <div>
                                    <p class="fw-bold mb-0">Quality Check</p>
                                    <small class="text-muted">Our team is hand-picking and inspecting your items for quality.</small>
                                </div>
                            </li>
                            <li class="d-flex gap-3">
                                <div class="text-primary fw-bold">03</div>
                                <div>
                                    <p class="fw-bold mb-0">Shipping Update</p>
                                    <small class="text-muted">You will receive a tracking link via SMS once shipped.</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
