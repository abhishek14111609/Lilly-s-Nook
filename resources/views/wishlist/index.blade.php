@extends('layouts.app')

@section('title', 'Your Wishlist - Lilly\'s Nook')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
            <div>
                <h1 class="display-5 fw-bold mb-1">My Wishlist</h1>
                <p class="text-muted mb-0">Saved pieces waiting for their moment.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('cart.index') }}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">View Bag</a>
            </div>
        </div>

        @if ($wishlistItems->isNotEmpty())
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-mobile-stack">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0 py-3">Product</th>
                                <th class="border-0 py-3">Price</th>
                                <th class="border-0 py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wishlistItems as $item)
                                <tr>
                                    <td class="ps-4" data-label="Product">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 border overflow-hidden bg-light" style="width: 70px; height: 90px; flex-shrink: 0;">
                                                @if ($item->product->image)
                                                    <img src="{{ asset('images/' . $item->product->image) }}" class="w-100 h-100 object-fit-cover" alt="">
                                                @elseif ($item->product->video)
                                                    <video src="{{ asset(ltrim($item->product->video, '/')) }}" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>
                                                @else
                                                    <img src="{{ asset('images/default-product.jpg') }}" class="w-100 h-100 object-fit-cover" alt="">
                                                @endif
                                            </div>
                                            <div class="text-start">
                                                <a href="{{ route('products.show', $item->product) }}" class="fw-bold text-dark text-decoration-none mb-1 d-block">{{ $item->product->name }}</a>
                                                <p class="text-muted small mb-0">{{ $item->product->category?->name ?? 'Collection' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Price">
                                        <span class="text-dark fw-bold">₹{{ number_format($item->product->price, 2) }}</span>
                                    </td>
                                    <td class="text-end pe-4" data-label="Actions">
                                        <div class="d-flex gap-2 justify-content-end align-items-center">
                                            <form method="post" action="{{ route('wishlist.cart.store', $item->product) }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm" type="submit">Move to Bag</button>
                                            </form>
                                            <form method="post" action="{{ route('wishlist.destroy', $item) }}">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-white btn-sm rounded-circle border shadow-sm p-2 text-danger" type="submit" title="Remove">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="py-5 text-center bg-light rounded-4 border border-dashed mt-4">
                <div class="py-5">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1" class="mb-3"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                    <h3 class="fw-bold">Your wishlist is empty</h3>
                    <p class="text-muted mb-4">Save items you love here to find them easily later.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow">Browse Collection</a>
                </div>
            </div>
        @endif
        
        <div class="p-5 bg-soft-primary rounded-4 text-center mt-5">
            <h4 class="fw-bold mb-3">Free Shipping on your first order!</h4>
            <p class="text-muted px-lg-5 mx-auto mb-0" style="max-width: 600px;">Every piece from Lily's Nook is wrapped with love. Shop our new arrivals and bring some magic to your little star's wardrobe.</p>
        </div>
    </div>
@endsection
