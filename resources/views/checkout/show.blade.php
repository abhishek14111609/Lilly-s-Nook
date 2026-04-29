@extends('layouts.app')

@section('title', 'Secure Checkout - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Checkout Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h2 class="fw-bold mb-4">Billing & Shipping</h2>

                    @if($addresses->isNotEmpty())
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Select Saved Address</label>
                            <div class="row g-3">
                                @foreach($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="address-selector p-3 border rounded-3 position-relative cursor-pointer {{ $address->is_default ? 'border-primary bg-primary-subtle' : '' }}" 
                                            onclick="selectAddress(this)"
                                            data-id="{{ $address->id }}"
                                            data-first_name="{{ $address->first_name }}"
                                            data-last_name="{{ $address->last_name }}"
                                            data-address="{{ $address->address_line_1 }} {{ $address->address_line_2 }}"
                                            data-city="{{ $address->city }}"
                                            data-zip="{{ $address->zip_code }}"
                                            data-phone="{{ $address->phone }}">
                                            <div class="d-flex justify-content-between">
                                                <span class="badge bg-white text-primary border border-primary-subtle rounded-pill small px-2 py-1 mb-2">{{ strtoupper($address->type) }}</span>
                                                @if($address->is_default) <span class="text-primary small fw-bold">Default</span> @endif
                                            </div>
                                            <p class="fw-bold small mb-1">{{ $address->first_name }} {{ $address->last_name }}</p>
                                            <p class="text-muted text-xs mb-0">{{ $address->city }}, {{ $address->zip_code }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr class="my-4 opacity-5">
                    @endif
                    
                    <form method="post" action="{{ route('checkout.store') }}" id="checkout-form">
                        @csrf
                        <input type="hidden" name="address_id" value="">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required placeholder="Jane">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required placeholder="Doe">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase">Full Delivery Address</label>
                                <textarea name="address" class="form-control" rows="3" required placeholder="House number, Street, Near Landmarks...">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required placeholder="Mumbai">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">ZIP / Postal Code</label>
                                <input type="text" name="zip" class="form-control" value="{{ old('zip') }}" required placeholder="400001">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Mobile Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">+91</span>
                                    <input type="tel" name="phone" class="form-control border-start-0" value="{{ old('phone') }}" required placeholder="9988776655">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 border mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white p-2 rounded-circle">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Secure Payment via Razorpay</h6>
                                    <p class="text-muted small mb-0">You will be redirected to complete payment securely.</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill py-3 fw-bold shadow">
                            Continue to Payment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                    <h4 class="fw-bold mb-4">In your bag</h4>
                    
                    <div class="d-flex flex-column gap-3 mb-4">
                        @foreach ($cartItems as $item)
                            @php $itemPrice = $item->product->priceForSize($item->size); @endphp
                            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-white border rounded" style="width: 50px; height: 60px; overflow: hidden;">
                                        @if ($item->product->image)
                                            <img src="{{ asset('images/' . $item->product->image) }}" class="w-100 h-100 object-fit-cover" alt="">
                                        @elseif ($item->product->video)
                                            <video src="{{ asset(ltrim($item->product->video, '/')) }}" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>
                                        @else
                                            <img src="{{ asset('images/default-product.jpg') }}" class="w-100 h-100 object-fit-cover" alt="">
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold small">{{ $item->product->name }}</h6>
                                        <p class="text-muted text-xs mb-0">{{ $item->size }} × {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <span class="fw-bold small">₹{{ number_format($itemPrice * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="mb-4 opacity-10">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Bag Total</span>
                        <span class="fw-bold">₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Standard Shipping</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>

                    <div class="d-flex justify-content-between mb-0 border-top pt-3">
                        <h5 class="fw-bold">Total to pay</h5>
                        <h5 class="fw-bold text-primary">₹{{ number_format($subtotal, 2) }}</h5>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-muted text-xs"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> 100% Secure Transaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <script>
        function selectAddress(element) {
            // UI Update
            document.querySelectorAll('.address-selector').forEach(el => {
                el.classList.remove('border-primary', 'bg-primary-subtle');
            });
            element.classList.add('border-primary', 'bg-primary-subtle');

            // Fill Form
            const form = document.getElementById('checkout-form');
            form.querySelector('[name="address_id"]').value = element.dataset.id;
            form.querySelector('[name="first_name"]').value = element.dataset.first_name;
            form.querySelector('[name="last_name"]').value = element.dataset.last_name;
            form.querySelector('[name="address"]').value = element.dataset.address;
            form.querySelector('[name="city"]').value = element.dataset.city;
            form.querySelector('[name="zip"]').value = element.dataset.zip;
            form.querySelector('[name="phone"]').value = element.dataset.phone;
        }

        // Initialize with default if exists
        document.addEventListener('DOMContentLoaded', function() {
            const defaultAddress = document.querySelector('.address-selector.border-primary');
            if(defaultAddress) {
                selectAddress(defaultAddress);
            }
        });
    </script>
    <style>
        .cursor-pointer { cursor: pointer; }
        .address-selector { transition: all 0.2s ease; }
        .address-selector:hover { border-color: var(--bs-primary) !important; }
        .text-xs { font-size: 0.75rem; }
    </style>
@endpush
@endsection
