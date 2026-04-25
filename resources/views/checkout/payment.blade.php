@extends('layouts.app')

@section('title', 'Payment Required - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                    <div class="row g-0">
                        <div class="col-md-7 p-4 p-md-5">
                            <div class="mb-4">
                                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3">SECURE CHECKOUT</span>
                                <h1 class="display-6 fw-bold mb-3">Finalize Your Order</h1>
                                <p class="text-muted">You're just one step away from completing your purchase. Please use the button below to authorize the transaction securely via Razorpay.</p>
                            </div>

                            <div class="d-grid gap-3 mb-4">
                                <button id="launch-payment" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow">
                                    Continue to Pay ₹{{ number_format($subtotal, 2) }}
                                </button>
                                <a href="{{ route('checkout.show') }}" class="btn btn-link text-muted text-decoration-none small">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M19 12H5"></path><path d="M12 19l-7-7 7-7"></path></svg>
                                    Review billing details
                                </a>
                            </div>

                            <div class="p-3 bg-light rounded-3 border-start border-primary border-4">
                                <p class="small text-muted flex-grow-1 mb-0">
                                    <strong>Merchant:</strong> {{ $razorpayMerchantName }}<br>
                                    <strong>Order Reference:</strong> {{ $razorpayOrderId }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-5 bg-light p-4 p-md-5 border-start">
                            <h4 class="fw-bold mb-4">Order Summary</h4>
                            <div class="d-flex flex-column gap-3 mb-4">
                                @foreach ($items as $item)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-start">
                                            <h6 class="mb-0 fw-bold small text-truncate" style="max-width: 150px;">{{ $item['product_name'] }}</h6>
                                            <small class="text-muted">{{ $item['quantity'] }} × {{ $item['size'] }}</small>
                                        </div>
                                        <span class="fw-bold small">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <hr class="mb-4 opacity-10">
                            
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <h5 class="fw-bold mb-0">Total Amount</h5>
                                <h4 class="fw-bold mb-0 text-primary">₹{{ number_format($subtotal, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="razorpay-success-form" method="post" action="{{ route('checkout.razorpay.verify') }}" class="d-none">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>
@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successForm = document.getElementById('razorpay-success-form');
            const launchButton = document.getElementById('launch-payment');
            
            const options = {
                key: @json($razorpayKeyId),
                amount: @json($amount),
                currency: @json($currency),
                name: @json($razorpayMerchantName),
                description: 'Lilly\'s Nook Checkout',
                order_id: @json($razorpayOrderId),
                prefill: {
                    name: @json(trim($billing['first_name'] . ' ' . $billing['last_name'])),
                    email: @json($billing['email']),
                    contact: @json($billing['phone']),
                },
                theme: { color: '#f48fb1' },
                modal: {
                    ondismiss: function() {
                        launchButton.disabled = false;
                        launchButton.textContent = 'Retry Payment';
                        launchButton.classList.replace('btn-primary', 'btn-dark');
                    },
                },
                handler: function(response) {
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    successForm.submit();
                },
            };

            const razorpay = new Razorpay(options);

            launchButton.addEventListener('click', function() {
                launchButton.disabled = true;
                launchButton.textContent = 'Initializing Secure Gateway...';
                razorpay.open();
            });

            // Auto-trigger if not coming from a back navigation
            if (!localStorage.getItem('payment_dismissed')) {
                // Comment out if you want manual trigger only
                // razorpay.open();
            }
        });
    </script>
@endpush
