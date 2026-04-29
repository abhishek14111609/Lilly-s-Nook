@extends('layouts.app')

@section('title', 'Manage Addresses - Lilly\'s Nook')

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="mb-4">
                        <div class="bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm"
                            style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: 700;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                    <p class="text-muted small mb-4">{{ Auth::user()->email }}</p>

                    <div class="list-group list-group-flush text-start rounded-3 overflow-hidden border">
                        <a href="{{ route('profile.show') }}"
                            class="list-group-item list-group-item-action py-3 border-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" class="me-2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Profile Details
                        </a>
                        <a href="{{ route('addresses.index') }}"
                            class="list-group-item list-group-item-action active py-3 border-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" class="me-2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            Manage Addresses
                        </a>
                        <a href="{{ route('orders.history') }}"
                            class="list-group-item list-group-item-action py-3 border-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" class="me-2">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                <path d="M3 6h18"></path>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            Order History
                        </a>
                        <a href="{{ route('wishlist.index') }}"
                            class="list-group-item list-group-item-action py-3 border-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" class="me-2">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                                </path>
                            </svg>
                            My Wishlist
                        </a>
                    </div>
                </div>
            </div>

            <!-- Addresses Content -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Saved Addresses</h4>
                    <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal"
                        data-bs-target="#addAddressModal">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="me-1">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Address
                    </button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row g-4">
                    @forelse ($addresses as $address)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 @if ($address->is_default) border-start border-primary border-4 @endif">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill small fw-bold text-uppercase">{{ $address->type }}</span>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle p-1" type="button" data-bs-toggle="dropdown">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                            <li>
                                                <button class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Edit Address</button>
                                            </li>
                                            @if(!$address->is_default)
                                                <li>
                                                    <form method="POST" action="{{ route('addresses.default', $address) }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item py-2">Set as Default</button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider opacity-5"></li>
                                            <li>
                                                <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Delete this address?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-2 text-danger">Delete Address</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <h6 class="fw-bold mb-1">{{ $address->first_name }} {{ $address->last_name }}</h6>
                                <p class="text-muted small mb-3">{{ $address->phone }}</p>
                                
                                <p class="small mb-0 text-dark">
                                    {{ $address->address_line_1 }}<br>
                                    @if($address->address_line_2) {{ $address->address_line_2 }}<br> @endif
                                    {{ $address->city }}, {{ $address->state }} - {{ $address->zip_code }}
                                </p>
                                
                                @if($address->is_default)
                                    <div class="mt-3 pt-3 border-top">
                                        <span class="text-primary small fw-bold d-flex align-items-center gap-1">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Default Shipping Address
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Edit Address Modal -->
                        <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <div class="modal-header border-bottom p-4">
                                        <h5 class="fw-bold mb-0">Edit Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('addresses.update', $address) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">First Name</label>
                                                    <input type="text" name="first_name" class="form-control" value="{{ $address->first_name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">Last Name</label>
                                                    <input type="text" name="last_name" class="form-control" value="{{ $address->last_name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ $address->phone }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">Type</label>
                                                    <select name="type" class="form-select" required>
                                                        <option value="home" @selected($address->type == 'home')>Home</option>
                                                        <option value="work" @selected($address->type == 'work')>Work</option>
                                                        <option value="other" @selected($address->type == 'other')>Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small fw-bold">Address Line 1</label>
                                                    <input type="text" name="address_line_1" class="form-control" value="{{ $address->address_line_1 }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small fw-bold">Address Line 2 (Optional)</label>
                                                    <input type="text" name="address_line_2" class="form-control" value="{{ $address->address_line_2 }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-bold">City</label>
                                                    <input type="text" name="city" class="form-control" value="{{ $address->city }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-bold">State</label>
                                                    <input type="text" name="state" class="form-control" value="{{ $address->state }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-bold">Zip Code</label>
                                                    <input type="text" name="zip_code" class="form-control" value="{{ $address->zip_code }}" required>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="editDefault{{ $address->id }}" @checked($address->is_default)>
                                                        <label class="form-check-label small" for="editDefault{{ $address->id }}">Set as default shipping address</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top p-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center bg-light rounded-4 border border-dashed">
                            <div class="py-4">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1" class="mb-3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <h5 class="fw-bold">No saved addresses</h5>
                                <p class="text-muted small">You haven't saved any shipping addresses yet.</p>
                                <button class="btn btn-outline-primary rounded-pill px-4 btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">Add Your First Address</button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom p-4">
                    <h5 class="fw-bold mb-0">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('addresses.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Recipient First Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Recipient Last Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Mobile Number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="home">Home</option>
                                    <option value="work">Work</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Address Line 1</label>
                                <input type="text" name="address_line_1" class="form-control" placeholder="Flat, House no., Building, Company, Apartment" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Address Line 2 (Optional)</label>
                                <input type="text" name="address_line_2" class="form-control" placeholder="Area, Street, Sector, Village">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">City</label>
                                <input type="text" name="city" class="form-control" placeholder="Town/City" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">State</label>
                                <input type="text" name="state" class="form-control" placeholder="State" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Zip Code</label>
                                <input type="text" name="zip_code" class="form-control" placeholder="PIN Code" required>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_default" value="1" id="addDefault" checked>
                                    <label class="form-check-label small" for="addDefault">Set as default shipping address</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top p-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">Add Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
