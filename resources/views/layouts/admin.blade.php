<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "Lilly's Nook Admin")</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/layout.css') }}">
    @stack('styles')
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="sidebar-logo">
                    <span>🌸 Lilly's Nook</span>
                </a>
                <small style="color: #666; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Admin
                    Panel</small>
            </div>

            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                            <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                            <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                            <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m7.5 4.27 9 5.15"></path>
                            <path
                                d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z">
                            </path>
                            <path d="m3.3 7 8.7 5 8.7-5"></path>
                            <path d="M12 22V12"></path>
                        </svg>
                        <span>Products</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                            <path d="M3 6h18"></path>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"></path>
                            <path d="M7 12h10"></path>
                            <path d="M10 18h4"></path>
                        </svg>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.sliders.index') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="14" rx="2"></rect>
                            <line x1="8" y1="20" x2="16" y2="20"></line>
                        </svg>
                        <span>Home Sliders</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reviews.index') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <span>Reviews</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.content.edit') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                        </svg>
                        <span>Site Content</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                    @php $unreadContactCount = \App\Models\ContactMessage::query()->whereNull('read_at')->count(); @endphp
                    <a href="{{ route('admin.contact-messages.index') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                        <span>Inquiries</span>
                        @if ($unreadContactCount > 0)
                            <span class="badge-dot">{{ $unreadContactCount }}</span>
                        @endif
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Customers</span>
                    </a>
                </li>
                <li class="mt-5">
                    <form method="post" action="{{ route('logout') }}" id="sidebar-logout-form" style="display:none;">
                        @csrf</form>
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
                        style="color: #ff4d4d;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-top-nav">
                <div class="user-info d-flex align-items-center gap-3">
                    <span class="text-muted">Welcome back, <strong>{{ auth()->user()->username }}</strong></span>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-dark"
                        style="padding: 5px 15px; font-size: 12px;">View Site</a>
                </div>
            </header>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
