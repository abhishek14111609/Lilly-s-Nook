@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
    <section class="padding-large bg-light-grey">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <div class="row g-4 align-items-start">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                                        <div>
                                            <p class="text-uppercase text-muted small mb-1">Secure checkout</p>
                                            <h2 class="mb-0">Complete your Razorpay payment</h2>
                                        </div>
                                        <span class="badge bg-dark">{{ $currency }}</span>
                                    </div>

                                    <p class="text-muted mb-4">
                                        Your order has been prepared. When you confirm payment, Razorpay will securely
                                        authorize the transaction and we will generate your invoice immediately.
                                    </p>

                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <button id="launch-payment" class="btn btn-dark" type="button">Open payment
                                            window</button>
                                        <a href="{{ route('checkout.show') }}" class="btn btn-outline-dark">Back to
                                            checkout</a>
                                    </div>

                                    <div class="alert alert-info mb-0">
                                        If the payment popup does not open automatically, use the button above. Your
                                        billing details are already saved for this checkout.
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="border rounded-4 p-4 bg-white h-100">
                                        <h5 class="mb-3">Order summary</h5>
                                        <ul class="list-unstyled mb-4">
                                            @foreach ($items as $item)
                                                <li class="d-flex justify-content-between gap-3 py-2 border-bottom">
                                                    <span>{{ $item['product_name'] }} x {{ $item['quantity'] }}
                                                        @if ($item['size'])
                                                            <small class="text-muted">({{ $item['size'] }})</small>
                                                        @endif
                                                    </span>
                                                    <strong>&#8377;{{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Total</span>
                                            <strong class="fs-5">&#8377;{{ number_format($subtotal, 2) }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center text-muted small">
                                            <span>Razorpay order reference</span>
                                            <span class="text-break text-end"
                                                style="max-width: 180px;">{{ $razorpayOrderId }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                description: 'Lilly\'s Nook checkout',
                order_id: @json($razorpayOrderId),
                prefill: {
                    name: @json(trim($billing['first_name'] . ' ' . $billing['last_name'])),
                    email: @json($billing['email']),
                    contact: @json($billing['phone']),
                },
                theme: {
                    color: '#111111',
                },
                modal: {
                    ondismiss: function() {
                        launchButton.disabled = false;
                        launchButton.textContent = 'Open payment window';
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
                launchButton.textContent = 'Opening payment window...';
                razorpay.open();
                setTimeout(function() {
                    if (!document.querySelector('.razorpay-container')) {
                        launchButton.disabled = false;
                        launchButton.textContent = 'Open payment window';
                    }
                }, 1500);
            });

            razorpay.open();
        });
    </script>
@endpush
