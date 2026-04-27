<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "Lilly's Nook")</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CDN (Restoring UI) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #f48fb1;
            --secondary-color: #556b2f;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .playfair {
            font-family: 'Playfair Display', serif;
        }

        .navbar-brand img {
            max-height: 96px;
            width: auto;
        }

        .sticky-top {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .nav-link {
            font-weight: 500;
            color: #444;
            transition: color 0.2s;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0.5rem;
            right: 0.5rem;
            height: 2px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .badge-count {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 10px;
            padding: 0.25em 0.6em;
        }

        .search-wrapper {
            position: relative;
            max-width: 300px;
        }

        .search-wrapper.mobile-search-wrapper {
            max-width: none;
        }

        .search-input {
            border-radius: 50px;
            padding-left: 40px;
            background-color: #f8f9fa;
            border: 1px solid transparent;
            transition: all 0.3s;
        }

        .search-input:focus {
            background-color: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(244, 143, 177, 0.25);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            pointer-events: none;
        }

        .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 15px 15px;
            max-height: 400px;
            overflow-y: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
        }

        .search-wrapper.mobile-search-wrapper .search-dropdown {
            position: static;
            border-top: 1px solid #e0e0e0;
            border-radius: 0 0 18px 18px;
            margin-top: -1px;
        }

        .search-dropdown.show {
            display: block;
        }

        .search-dropdown-section {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-dropdown-section:last-child {
            border-bottom: none;
        }

        .search-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            color: #333;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            border-radius: 8px;
        }

        .search-result-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
            border: 1px solid #e0e0e0;
            display: block;
            color: transparent;
        }

        .search-result-info {
            flex: 1;
            min-width: 0;
        }

        .search-result-name {
            font-size: 0.9rem;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-result-price {
            font-size: 0.8rem;
            color: #666;
        }

        .search-empty {
            padding: 1.5rem 1rem;
            text-align: center;
            color: #999;
            font-size: 0.9rem;
        }

        .mobile-nav-panel {
            border-top: 1px solid #eef1f5;
            padding-top: 0.75rem;
        }

        .mobile-search-form {
            display: block;
        }

        .mobile-search-form .search-input {
            max-width: none;
            width: 100%;
            min-height: 46px;
        }

        .mobile-quick-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .mobile-action-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            min-height: 70px;
            border: 1px solid #e9edf2;
            border-radius: 14px;
            background: #fff;
            color: #111827;
            text-decoration: none;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
        }

        .mobile-action-card small {
            font-size: 0.78rem;
            color: #6b7280;
        }

        .mobile-account-card {
            border: 1px solid #e9edf2;
            border-radius: 16px;
            background: linear-gradient(180deg, #ffffff 0%, #fafbfc 100%);
            padding: 0.75rem;
        }

        .mobile-account-card summary {
            list-style: none;
            cursor: pointer;
        }

        .mobile-account-card summary::-webkit-details-marker {
            display: none;
        }

        .mobile-account-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .mobile-account-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-color);
            color: #fff;
            font-weight: 700;
            flex-shrink: 0;
        }

        .mobile-account-links {
            display: grid;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .mobile-account-links .btn {
            justify-content: center;
        }

        .mobile-account-meta {
            color: #6b7280;
            font-size: 0.88rem;
        }

        @media (max-width: 991.98px) {
            .navbar-brand img {
                max-height: 52px;
            }

            .navbar-collapse {
                padding-top: 0.5rem;
                padding-bottom: 0.75rem;
                max-height: calc(100vh - 92px);
                overflow-y: auto;
                overscroll-behavior: contain;
            }

            .navbar-nav {
                padding-top: 0.4rem !important;
                padding-bottom: 0.5rem !important;
            }
        }

        @media (max-width: 575.98px) {
            .mobile-search-form {
                flex-direction: column;
            }

            .mobile-quick-actions {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        footer {
            background-color: #f9f9f9;
            padding: 80px 0 40px;
            border-top: 1px solid #eee;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 25px;
        }

        .footer-link {
            color: #666;
            text-decoration: none;
            transition: color 0.2s;
            display: block;
            margin-bottom: 10px;
        }

        .footer-link:hover {
            color: var(--primary-color);
        }

        /* Preloader */
        .preloader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s;
        }

        .preloader {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loaded .preloader-wrapper {
            opacity: 0;
            pointer-events: none;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="preloader-wrapper" id="preloader">
        <div class="preloader"></div>
    </div>

    @php
        $navItems = [
            ['label' => 'Home', 'url' => route('home'), 'match' => 'home'],
            ['label' => 'Shop', 'url' => route('shop.index'), 'match' => 'shop.*'],
            ['label' => 'About', 'url' => route('about'), 'match' => 'about'],
            ['label' => 'Contact', 'url' => route('contact.show'), 'match' => 'contact.*'],
            ['label' => 'Blog', 'url' => route('blog'), 'match' => 'blog'],
            ['label' => 'FAQs', 'url' => route('faqs'), 'match' => 'faqs'],
        ];
    @endphp

    <!-- Top Utility Bar -->
    <div class="bg-dark text-white py-1 d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center">
            <small class="fw-light">Thoughtfully curated outfits for everyday magic.</small>
            <div class="d-flex gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-white text-decoration-none small">Login</a>
                    <a href="{{ route('register') }}" class="text-white text-decoration-none small">Register</a>
                @else
                    <span class="small fw-medium">Welcome, {{ auth()->user()->username }}</span>
                @endguest
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-white py-3">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/lillys-logo.png') }}" alt="Lilly's Nook" class="me-2">
                <span class="fw-bold fs-4 d-lg-none">Lilly's Nook</span>
            </a>

            <!-- Mobile Toggles -->
            <div class="d-flex align-items-center gap-3 d-lg-none">
                <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 py-3 py-lg-0 gap-lg-3">
                    @foreach ($navItems as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($item['match']) ? 'active' : '' }}"
                                href="{{ $item['url'] }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="d-lg-none mobile-nav-panel">
                    <div class="search-wrapper mobile-search-wrapper mb-3">
                        <form action="{{ route('shop.index') }}" method="GET" class="mobile-search-form"
                            onsubmit="return handleSearchSubmit(event)">
                            <span class="search-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </span>
                            <input type="search" name="s" class="form-control search-input"
                                id="mobileSearchInput" placeholder="Search products..." value="{{ request('s') }}"
                                autocomplete="off">

                            <div class="search-dropdown" id="mobileSearchDropdown">
                                <div class="search-empty">Start typing to search...</div>
                            </div>
                        </form>
                    </div>

                    <div class="mobile-quick-actions mb-3">
                        <a href="{{ route('wishlist.index') }}" class="mobile-action-card">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                                </path>
                            </svg>
                            <small>Wishlist</small>
                        </a>

                        <a href="{{ route('cart.index') }}" class="mobile-action-card position-relative">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path
                                    d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                </path>
                            </svg>
                            <small>Cart</small>
                            <span class="badge rounded-pill bg-primary badge-count">{{ $cartCount }}</span>
                        </a>

                        @auth
                            <a href="{{ route('profile.show') }}" class="mobile-action-card">
                                <div class="mobile-account-avatar">
                                    {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username, 0, 1)) }}
                                </div>
                                <small>Profile</small>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="mobile-action-card">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21a8 8 0 1 0-16 0"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <small>Login</small>
                            </a>
                        @endauth
                    </div>

                    <details class="mobile-account-card">
                        @auth
                            <summary class="mobile-account-header">
                                <div class="mobile-account-avatar">
                                    {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username, 0, 1)) }}
                                </div>
                                <div class="grow">
                                    <div class="fw-bold">{{ auth()->user()->name ?? auth()->user()->username }}</div>
                                    <div class="mobile-account-meta">Tap to expand account options</div>
                                </div>
                            </summary>

                            <div class="mobile-account-links">
                                <a href="{{ route('orders.history') }}" class="btn btn-outline-dark rounded-pill">My
                                    Orders</a>
                                @if (auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary rounded-pill">Admin
                                        Panel</a>
                                @endif
                                <form method="post" action="{{ route('logout') }}" id="logout-form-mobile"
                                    class="d-none">
                                    @csrf
                                </form>
                                <a href="#" class="btn btn-outline-danger rounded-pill"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Logout</a>
                            </div>
                        @else
                            <summary class="mobile-account-header">
                                <div class="mobile-account-avatar">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 21a8 8 0 1 0-16 0"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <div class="grow">
                                    <div class="fw-bold">Guest account</div>
                                    <div class="mobile-account-meta">Tap to login or register</div>
                                </div>
                            </summary>

                            <div class="mobile-account-links">
                                <a href="{{ route('login') }}" class="btn btn-dark rounded-pill">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-dark rounded-pill">Register</a>
                            </div>
                        @endauth
                    </details>
                </div>

                <!-- Desktop End Actions -->
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <div class="search-wrapper me-2">
                        <form action="{{ route('shop.index') }}" method="GET" id="searchForm"
                            onsubmit="return handleSearchSubmit(event)">
                            <span class="search-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </span>
                            <input type="search" name="s" class="form-control search-input" id="searchInput"
                                placeholder="Search products..." value="{{ request('s') }}" autocomplete="off">

                            <!-- Dynamic Search Dropdown -->
                            <div class="search-dropdown" id="searchDropdown">
                                <div class="search-empty">Start typing to search...</div>
                            </div>
                        </form>
                    </div>

                    <a href="{{ route('wishlist.index') }}" class="text-dark position-relative p-2"
                        title="Wishlist">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                            </path>
                        </svg>
                        <span class="badge rounded-pill bg-danger badge-count">{{ $wishlistCount }}</span>
                    </a>

                    <a href="{{ route('cart.index') }}" class="text-dark position-relative p-2" title="Cart">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="8" cy="21" r="1"></circle>
                            <circle cx="19" cy="21" r="1"></circle>
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                            </path>
                        </svg>
                        <span class="badge rounded-pill bg-primary badge-count">{{ $cartCount }}</span>
                    </a>

                    @auth
                        <div class="dropdown">
                            <button
                                class="btn d-flex align-items-center gap-2 p-1 rounded-pill border-0 shadow-none dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                    style="width: 32px; height: 32px; font-size: 0.9rem;">
                                    {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username, 0, 1)) }}
                                </div>
                                <span
                                    class="d-none d-xl-inline small fw-bold text-dark">{{ explode(' ', auth()->user()->name ?? auth()->user()->username)[0] }}</span>
                            </button>
                            <ul
                                class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-4 animate slideIn">
                                <li><a class="dropdown-item rounded-2 py-2"
                                        href="{{ route('profile.show') }}">Profile</a></li>
                                <li><a class="dropdown-item rounded-2 py-2" href="{{ route('orders.history') }}">My
                                        Orders</a></li>
                                @if (auth()->user()->is_admin)
                                    <li><a class="dropdown-item rounded-2 py-2 fw-bold text-primary"
                                            href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="post" action="{{ route('logout') }}" id="logout-form-desktop"
                                        class="d-none">@csrf</form>
                                    <a class="dropdown-item rounded-2 py-2 text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">Logout</a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-dark rounded-pill px-4 ms-2">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="py-4 py-lg-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title h4">Lilly's Nook</h5>
                    <p class="text-muted mb-4 pe-lg-5">Thoughtfully curated outfits for everyday magic. Quality and
                        style handpicked for you.</p>
                    <div class="d-flex gap-3">
                        <a href="#"
                            class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="#"
                            class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                </rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('shop.index') }}" class="footer-link">Shop All</a></li>
                        <li><a href="{{ route('about') }}" class="footer-link">About Us</a></li>
                        <li><a href="{{ route('blog') }}" class="footer-link">Our Blog</a></li>
                        <li><a href="{{ route('faqs') }}" class="footer-link">FAQs</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="footer-title">Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('contact.show') }}" class="footer-link">Contact Us</a></li>
                        <li><a href="#" class="footer-link">Shipping Policy</a></li>
                        <li><a href="#" class="footer-link">Returns & Refunds</a></li>
                        <li><a href="#" class="footer-link">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h5 class="footer-title">Join our Newsletter</h5>
                    <p class="text-muted mb-4">Get updates on new collections and exclusive offers.</p>
                    <form action="{{ route('subscribe.store') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="email" name="email" class="form-control rounded-pill px-4"
                            placeholder="Email address" required>
                        <button class="btn btn-primary rounded-pill px-4 shadow-sm" type="submit">Join</button>
                    </form>
                </div>
            </div>

            <div class="border-top mt-5 pt-4 text-center">
                <p class="text-muted small mb-0">&copy; {{ now()->year }} Lilly's Nook. Built with love and Laravel.
                    All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide preloader
            setTimeout(() => {
                document.body.classList.add('loaded');
            }, 500);

            // Responsive tables enhancement
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                if (!table.parentElement.classList.contains('table-responsive')) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('table-responsive');
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
                table.classList.add('table', 'table-hover', 'align-middle');
            });

            // Standardize forms
            const inputs = document.querySelectorAll(
                'input:not([type="checkbox"]):not([type="radio"]), select, textarea');
            inputs.forEach(input => {
                if (!input.classList.contains('form-control') && !input.classList.contains('form-select')) {
                    input.classList.add(input.tagName === 'SELECT' ? 'form-select' : 'form-control');
                }
            });

            const buttons = document.querySelectorAll('button:not(.btn-close):not(.navbar-toggler)');
            buttons.forEach(btn => {
                if (!btn.classList.length || (btn.classList.length === 1 && btn.classList.contains(
                        'btn'))) {
                    btn.classList.add('btn', 'btn-primary');
                }
            });

            // Dynamic Search Dropdown
            initSearchDropdown();
            initSearchDropdown('mobileSearchInput', 'mobileSearchDropdown');

            // Auto-close mobile nav after selecting an item
            const mainNavbar = document.getElementById('mainNavbar');
            if (mainNavbar) {
                mainNavbar.querySelectorAll('.nav-link, .mobile-action-card').forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth < 992) {
                            const collapseInstance = bootstrap.Collapse.getOrCreateInstance(
                                mainNavbar, {
                                    toggle: false
                                });
                            collapseInstance.hide();
                        }
                    });
                });
            }
        });

        function initSearchDropdown(inputId = 'searchInput', dropdownId = 'searchDropdown') {
            const searchInput = document.getElementById(inputId);
            const searchDropdown = document.getElementById(dropdownId);
            let searchTimeout;

            if (!searchInput || !searchDropdown) return;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim();

                if (query.length < 1) {
                    searchDropdown.classList.remove('show');
                    searchDropdown.innerHTML = '<div class="search-empty">Start typing to search...</div>';
                    return;
                }

                // Debounce search
                searchTimeout = setTimeout(() => {
                    fetchSearchResults(query, searchDropdown);
                }, 300);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                const wrapper = searchInput.closest('.search-wrapper');
                if (!wrapper || !wrapper.contains(e.target)) {
                    searchDropdown.classList.remove('show');
                }
            });

            // Handle keyboard navigation and item clicks
            searchDropdown.addEventListener('click', (e) => {
                const item = e.target.closest('.search-result-item');
                if (item) {
                    window.location.href = item.href;
                }
            });
        }

        function fetchSearchResults(query, dropdown) {
            if (!dropdown) return;

            fetch(`{{ route('products.search') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Search results:', data);
                    renderSearchResults(data, dropdown);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    dropdown.innerHTML = '<div class="search-empty">Error loading results</div>';
                    dropdown.classList.add('show');
                });
        }

        function renderSearchResults(data, dropdown) {
            let html = '';

            // Products section
            if (data.products && data.products.length > 0) {
                html += '<div class="search-dropdown-section">';
                html += '<div class="search-section-title">Products</div>';
                data.products.slice(0, 5).forEach(product => {
                    const imageUrl = product.image ? `/images/uploads/products/${product.image}` : '';
                    const productUrl = `/products/${product.id}`;
                    html += `
                        <a href="${productUrl}" class="search-result-item">
                            ${imageUrl ? `<img src="${imageUrl}" alt="${product.name}" class="search-result-img" loading="lazy">` : '<div class="search-result-img"></div>'}
                            <div class="search-result-info">
                                <div class="search-result-name">${product.name}</div>
                                <div class="search-result-price">₹${parseFloat(product.price).toLocaleString('en-IN', {minimumFractionDigits: 0})}</div>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }

            // Categories section
            if (data.categories && data.categories.length > 0) {
                html += '<div class="search-dropdown-section">';
                html += '<div class="search-section-title">Categories</div>';
                data.categories.slice(0, 3).forEach(category => {
                    const categoryUrl = `{{ route('shop.index') }}?category_id=${category.id}`;
                    const categoryImage = category.image ? `/images/uploads/categories/${category.image}` : '';
                    html += `
                        <a href="${categoryUrl}" class="search-result-item">
                            ${categoryImage ? `<img src="${categoryImage}" alt="${category.name}" class="search-result-img" loading="lazy">` : '<div class="search-result-img"></div>'}
                            <div class="search-result-info">
                                <div class="search-result-name">${category.name}</div>
                                <div class="search-result-price">${category.products_count || 0} Products</div>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
            }

            if (!html) {
                html = '<div class="search-empty">No results found</div>';
            }

            dropdown.innerHTML = html;
            dropdown.classList.add('show');
        }

        function handleSearchSubmit(e) {
            // Allow form submission
            return true;
        }
    </script>
    @stack('scripts')
</body>

</html>
