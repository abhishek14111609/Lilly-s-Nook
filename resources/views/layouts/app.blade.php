<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "Lilly's Nook")</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('icomoon/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <style>
        .badge-dot {
            background: #111;
            border-radius: 999px;
            color: #fff;
            font-size: 11px;
            margin-left: 4px;
            padding: 2px 6px;
        }

        .page-shell {
            min-height: 60vh;
        }

        .flash-message {
            margin: 1rem auto 0;
            max-width: 1100px;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="preloader-wrapper">
        <div class="preloader"></div>
    </div>

    <!-- Search popup kept hidden for potential future use -->
    <div class="search-popup" style="display:none;">
        <div class="search-popup-container">
            <form role="search" method="get" class="search-form" action="{{ route('shop.index') }}">
                <input type="search" id="search-popup-input" class="search-field"
                    placeholder="Search products, categories, subcategories..." value="{{ request('s') }}"
                    name="s" aria-label="Search products, categories and subcategories">
                <button type="submit" class="search-submit" aria-label="Search"><i class="icon icon-search"
                        aria-hidden="true"></i></button>
            </form>
        </div>
    </div>

    <nav class="secondary-nav">
        <div class="container">
            <div class="row align-items-center py-2">
                <div class="col-md-5 d-none d-md-block">
                    <small class="store-tagline">🌸 Lilly's Nook Storefront</small>
                </div>
                <div class="col-md-7">
                    <ul class="user-items d-flex justify-content-end list-unstyled align-items-center m-0 gap-3">
                        <li class="search-bar-item">
                            <div class="header-search-wrapper">
                                <form role="search" method="get" class="header-search-form"
                                    action="{{ route('shop.index') }}">
                                    <span class="header-search-icon" aria-hidden="true">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </span>
                                    <input type="search" class="header-search-input"
                                        placeholder="Search products, categories, subcategories..."
                                        value="{{ request('s') }}" name="s"
                                        aria-label="Search products, categories and subcategories" autocomplete="off">
                                </form>
                                <div class="search-dropdown" id="search-dropdown" style="display:none;">
                                    <div class="search-dropdown-content"></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" class="icon-link position-relative">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="8" cy="21" r="1"></circle>
                                    <circle cx="19" cy="21" r="1"></circle>
                                    <path
                                        d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                    </path>
                                </svg>
                                <span class="badge-count">{{ $cartCount }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('wishlist.index') }}" class="icon-link position-relative">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                                    </path>
                                </svg>
                                <span class="badge-count">{{ $wishlistCount }}</span>
                            </a>
                        </li>

                        @auth
                            <li class="profile-dropdown-wrapper">
                                <div class="profile-trigger d-flex align-items-center gap-2">
                                    <div class="avatar-sm">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                    <span class="user-name">{{ auth()->user()->username }}</span>
                                    <svg class="dropdown-chevron" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6"></path>
                                    </svg>
                                </div>
                                <ul class="profile-dropdown">
                                    <li>
                                        <a href="{{ route('profile.show') }}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('orders.history') }}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                                <path d="M3 6h18"></path>
                                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                                            </svg>
                                            <span>My Orders</span>
                                        </a>
                                    </li>
                                    @if (auth()->user()->is_admin)
                                        <li>
                                            <a href="{{ route('admin.dashboard') }}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <rect width="18" height="18" x="3" y="3" rx="2">
                                                    </rect>
                                                    <path d="M3 9h18"></path>
                                                    <path d="M9 21V9"></path>
                                                </svg>
                                                <span>Admin Panel</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="dropdown-divider"></li>
                                    <li>
                                        <form method="post" action="{{ route('logout') }}" id="logout-form"
                                            style="display:none;">@csrf</form>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="text-danger">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                <polyline points="16 17 21 12 16 7"></polyline>
                                                <line x1="21" y1="12" x2="9" y2="12">
                                                </line>
                                            </svg>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="item-link">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                        <polyline points="10 17 15 12 10 7"></polyline>
                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                    <span>Login</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <nav class="primary-nav padding-small">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-2 col-md-2">
                    <div class="main-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/lillys-logo.png') }}" alt="Lilly's Nook logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="navbar">
                        <div id="main-nav" class="stellarnav d-flex justify-content-end right">
                            <ul class="menu-list">
                                <li><a href="{{ route('home') }}" class="item-anchor">Home</a></li>
                                <li><a href="{{ route('about') }}" class="item-anchor">About</a></li>
                                <li><a href="{{ route('shop.index') }}" class="item-anchor">Shop</a></li>
                                <li><a href="{{ route('contact.show') }}" class="item-anchor">Contact</a></li>
                                <li><a href="{{ route('blog') }}" class="item-anchor">Blog</a></li>
                                <li><a href="{{ route('faqs') }}" class="item-anchor">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </div>
    </header>

    @if (session('status'))
        <div class="container flash-message">
            <div class="alert alert-success">{{ session('status') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container flash-message">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="page-shell">@yield('content')</main>

    <footer id="footer">
        <div class="container">
            <div class="footer-menu-list">
                <div class="row d-flex flex-wrap justify-content-between">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-menu">
                            <h5 class="widget-title">Lilly's Nook</h5>
                            <ul class="menu-list list-unstyled">
                                <li class="menu-item"><a href="{{ route('about') }}">About us</a></li>
                                <li class="menu-item"><a href="{{ route('blog') }}">Our Journal</a></li>
                                <li class="menu-item"><a href="{{ route('faqs') }}">FAQs</a></li>
                                <li class="menu-item"><a href="{{ route('contact.show') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-menu">
                            <h5 class="widget-title">Newsletter</h5>
                            <p>Get updates on new drops, offers, and the Laravel build.</p>
                            <form method="post" action="{{ route('subscribe.store') }}">
                                @csrf
                                <input type="email" name="email" placeholder="Email address"
                                    class="form-control" required>
                                <button class="btn btn-dark" type="submit"
                                    style="margin-top:12px;">Subscribe</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        @php
                            $footerPhone = \App\Models\SiteSetting::getValue('contact_phone', '+91 9106005682');
                            $footerEmail = \App\Models\SiteSetting::getValue('contact_email', 'info@lillysnook.com');
                            $footerAddress = \App\Models\SiteSetting::getValue(
                                'contact_address',
                                'Rajkot, Gujarat, India',
                            );
                        @endphp
                        <div class="footer-menu">
                            <h5 class="widget-title">Contact Us</h5>
                            <p>Questions, feedback, or wholesale inquiries.</p>
                            <p><strong>{{ $footerPhone }}</strong><br>{{ $footerEmail }}<br>{{ $footerAddress }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="{{ asset('js/jquery-1.11.0.min.js') }}"><\/script>');
    </script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
