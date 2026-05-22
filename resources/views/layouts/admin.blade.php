<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "Lily's Nook Admin")</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --top-nav-height: 64px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            background: #ffffff;
            border-right: 1px solid rgba(0, 0, 0, .075);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-text {
            display: none;
        }

        .sidebar-header {
            height: var(--top-nav-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            flex-shrink: 0;
        }

        .sidebar-nav {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.75rem 0 1rem;
            scrollbar-gutter: stable;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, 0.14);
            border-radius: 999px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-footer {
            flex-shrink: 0;
            padding: 1rem;
            border-top: 1px solid rgba(0, 0, 0, .075);
            background: #ffffff;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        .top-navbar {
            height: var(--top-nav-height);
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, .075);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .nav-link {
            color: #6c757d;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            border-radius: 8px;
            margin: 0.2rem 0.75rem;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--bs-primary);
            background-color: rgba(var(--bs-primary-rgb), 0.08);
        }

        .nav-link svg {
            flex-shrink: 0;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.mobile-show {
                left: 0;
                width: var(--sidebar-width);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, .5);
                z-index: 999;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Custom card styling to match SaaS look */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.75rem;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-light">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar shadow-sm" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center gap-2">
                <span class="fw-bold fs-5 text-dark sidebar-text">Lily's Nook</span>
                <span
                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill sidebar-text">Admin</span>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                            <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                            <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                            <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                        </svg>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link" target="" rel="noopener noreferrer">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h6v6"></path>
                            <path d="M10 14 21 3"></path>
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        </svg>
                        <span class="sidebar-text">View Site</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m7.5 4.27 9 5.15"></path>
                            <path
                                d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z">
                            </path>
                            <path d="m3.3 7 8.7 5 8.7-5"></path>
                            <path d="M12 22V12"></path>
                        </svg>
                        <span class="sidebar-text">Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                            <path d="M3 6h18"></path>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span class="sidebar-text">Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"></path>
                            <path d="M7 12h10"></path>
                            <path d="M10 18h4"></path>
                        </svg>
                        <span class="sidebar-text">Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.subcategories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7h16"></path>
                            <path d="M7 12h10"></path>
                            <path d="M10 17h4"></path>
                        </svg>
                        <span class="sidebar-text">Subcategories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sliders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="14" rx="2"></rect>
                            <line x1="8" y1="20" x2="16" y2="20"></line>
                        </svg>
                        <span class="sidebar-text">Home Sliders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.showcase-videos.index') }}"
                        class="nav-link {{ request()->routeIs('admin.showcase-videos.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="5" width="16" height="14" rx="2"></rect>
                            <path d="m10 9 5 3-5 3V9Z"></path>
                        </svg>
                        <span class="sidebar-text">Showcase Videos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reviews.index') }}"
                        class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <span class="sidebar-text">Reviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.edit') }}"
                        class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                        </svg>
                        <span class="sidebar-text">Site Content</span>
                    </a>
                </li>
                <li class="nav-item">
                    @php $unreadContactCount = \App\Models\ContactMessage::query()->whereNull('read_at')->count(); @endphp
                    <a href="{{ route('admin.contact-messages.index') }}"
                        class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                        <span class="sidebar-text text-truncate">Inquiries</span>
                        @if ($unreadContactCount > 0)
                            <span
                                class="ms-auto badge rounded-pill bg-danger shadow-sm sidebar-text">{{ $unreadContactCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="sidebar-text">Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.newsletter-subscribers.index') }}"
                        class="nav-link {{ request()->routeIs('admin.newsletter-subscribers.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="m22 6-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 6"></path>
                        </svg>
                        <span class="sidebar-text">Newsletter</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <form method="post" action="{{ route('logout') }}" id="sidebar-logout-form" style="display:none;">
                @csrf</form>
            <a href="#"
                onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
                class="nav-link text-danger m-0">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span class="sidebar-text">Logout</span>
            </a>
        </div>
    </aside>

    <main class="main-content" id="mainContent">
        <header class="top-navbar bg-white shadow-sm">
            <div class="container-fluid d-flex align-items-center justify-content-between p-0">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light border-0 rounded-circle p-2" id="sidebarToggle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <nav aria-label="breadcrumb" class="d-none d-md-block">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                    class="text-decoration-none">Admin</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-light border-0 rounded-pill d-flex align-items-center gap-2 px-3"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px; font-size: 14px;">
                                {{ substr(auth()->user()->username, 0, 1) }}
                            </div>
                            <span class="fw-medium d-none d-sm-inline">{{ auth()->user()->username }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('home') }}">View Store</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid p-4">
            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                } else {
                    sidebar.classList.toggle('mobile-show');
                    overlay.classList.toggle('show');
                }
            }

            sidebarToggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Handle responsive view on resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('mobile-show');
                    overlay.classList.remove('show');
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
