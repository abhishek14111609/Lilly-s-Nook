<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lilly's Nook - Elegant Fashion & Lifestyle</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Dancing+Script:wght@700&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Custom Enhanced Styles for Lilly's Nook */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                overflow-x: hidden;
                background: #0a0a0a;
            }

            /* Velvet Background with Gradient */
            .velvet-bg {
                background: linear-gradient(135deg, #1a1a1a 0%, #2d1b1b 25%, #1f1f1f 50%, #2d1b1b 75%, #1a1a1a 100%);
                position: relative;
                overflow: hidden;
            }

            .velvet-bg::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background:
                    radial-gradient(circle at 20% 80%, rgba(244, 143, 177, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(244, 143, 177, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(85, 107, 47, 0.05) 0%, transparent 50%);
                pointer-events: none;
            }

            /* Flower Animations */
            .flower {
                position: absolute;
                opacity: 0.6;
                animation: float 6s ease-in-out infinite;
                pointer-events: none;
            }

            .flower-1 {
                top: 10%;
                left: 10%;
                font-size: 2rem;
                animation-delay: 0s;
            }

            .flower-2 {
                top: 20%;
                right: 15%;
                font-size: 1.5rem;
                animation-delay: 1s;
            }

            .flower-3 {
                bottom: 30%;
                left: 8%;
                font-size: 1.8rem;
                animation-delay: 2s;
            }

            .flower-4 {
                bottom: 15%;
                right: 10%;
                font-size: 1.3rem;
                animation-delay: 3s;
            }

            .flower-5 {
                top: 50%;
                left: 5%;
                font-size: 1.6rem;
                animation-delay: 4s;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                25% {
                    transform: translateY(-20px) rotate(5deg);
                }

                50% {
                    transform: translateY(-10px) rotate(-3deg);
                }

                75% {
                    transform: translateY(-15px) rotate(2deg);
                }
            }

            /* Navigation */
            nav {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                padding: 1rem 2rem;
                background: rgba(26, 26, 26, 0.95);
                backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(244, 143, 177, 0.2);
                transition: all 0.3s ease;
            }

            .nav-container {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo-text {
                font-family: 'Dancing Script', cursive;
                font-size: 2rem;
                font-weight: 700;
                color: #f48fb1;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
                letter-spacing: 1px;
            }

            .nav-links {
                display: flex;
                gap: 2rem;
                list-style: none;
            }

            .nav-links a {
                color: #fff;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                position: relative;
            }

            .nav-links a::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .nav-links a:hover::after {
                left: 100%;
            }

            .nav-links a:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 40px rgba(244, 143, 177, 0.4);
            }

            /* Hero Section */
            .hero {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 6rem 2rem 2rem;
                position: relative;
            }

            .hero-content {
                text-align: center;
                max-width: 900px;
                z-index: 2;
                position: relative;
            }

            .hero-title {
                font-family: 'Playfair Display', serif;
                font-size: clamp(3rem, 8vw, 6rem);
                font-weight: 900;
                color: #fff;
                margin-bottom: 1.5rem;
                line-height: 1.1;
                text-shadow:
                    0 0 20px rgba(244, 143, 177, 0.5),
                    0 0 40px rgba(244, 143, 177, 0.3);
                animation: glow 3s ease-in-out infinite alternate;
            }

            @keyframes glow {
                from {
                    text-shadow: 0 0 20px rgba(244, 143, 177, 0.5), 0 0 40px rgba(244, 143, 177, 0.3);
                }

                to {
                    text-shadow: 0 0 30px rgba(244, 143, 177, 0.8), 0 0 50px rgba(244, 143, 177, 0.5);
                }
            }

            .hero-subtitle {
                font-size: 1.5rem;
                color: #f48fb1;
                margin-bottom: 2rem;
                font-weight: 500;
                opacity: 0.9;
            }

            .hero-description {
                font-size: 1.1rem;
                color: #ccc;
                margin-bottom: 3rem;
                line-height: 1.6;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }

            .cta-buttons {
                display: flex;
                gap: 1.5rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-primary {
                background: linear-gradient(135deg, #f48fb1, #f06292);
                color: #fff;
                padding: 1rem 2.5rem;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0 10px 30px rgba(244, 143, 177, 0.3);
                position: relative;
                overflow: hidden;
            }

            .btn-primary::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .btn-primary:hover::before {
                left: 100%;
            }

            .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 40px rgba(244, 143, 177, 0.4);
            }

            .btn-secondary {
                background: transparent;
                color: #f48fb1;
                padding: 1rem 2.5rem;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                font-size: 1.1rem;
                border: 2px solid #f48fb1;
                transition: all 0.3s ease;
            }

            .btn-secondary:hover {
                background: #f48fb1;
                color: #fff;
                transform: translateY(-3px);
                box-shadow: 0 15px 40px rgba(244, 143, 177, 0.3);
            }

            /* Features Section */
            .features {
                padding: 5rem 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                margin-top: 3rem;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 2rem;
                border: 1px solid rgba(244, 143, 177, 0.2);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, #f48fb1, #556b2f);
            }

            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(244, 143, 177, 0.2);
                border-color: rgba(244, 143, 177, 0.4);
            }

            .feature-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
                display: block;
            }

            .feature-title {
                font-size: 1.5rem;
                color: #f48fb1;
                margin-bottom: 1rem;
                font-weight: 600;
            }

            .feature-description {
                color: #ccc;
                line-height: 1.6;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .nav-links {
                    display: none;
                }

                .hero-title {
                    font-size: 3rem;
                }

                .hero-subtitle {
                    font-size: 1.2rem;
                }

                .cta-buttons {
                    flex-direction: column;
                    align-items: center;
                }

                .btn-primary,
                .btn-secondary {
                    width: 100%;
                    max-width: 300px;
                }
            }

            /* Enhanced Animations */
            .fade-in {
                opacity: 0;
                animation: fadeIn 1s ease-in forwards;
            }

            .fade-in-delay-1 {
                opacity: 0;
                animation: fadeIn 1s ease-in 0.3s forwards;
            }

            .fade-in-delay-2 {
                opacity: 0;
                animation: fadeIn 1s ease-in 0.6s forwards;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .slide-in-left {
                opacity: 0;
                animation: slideInLeft 1s ease-out forwards;
            }

            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-100px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .slide-in-right {
                opacity: 0;
                animation: slideInRight 1s ease-out forwards;
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Category Cards */
            .category-section {
                padding: 5rem 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }

            .section-title {
                font-family: 'Playfair Display', serif;
                font-size: 3rem;
                font-weight: 700;
                color: #fff;
                text-align: center;
                margin-bottom: 3rem;
                position: relative;
            }

            .section-title::after {
                content: '';
                position: absolute;
                bottom: -15px;
                left: 50%;
                transform: translateX(-50%);
                width: 100px;
                height: 3px;
                background: linear-gradient(90deg, #f48fb1, #556b2f);
            }

            .categories-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 2rem;
                margin-bottom: 5rem;
            }

            .category-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                overflow: hidden;
                border: 1px solid rgba(244, 143, 177, 0.2);
                transition: all 0.4s ease;
                position: relative;
                cursor: pointer;
            }

            .category-card:hover {
                transform: translateY(-15px) scale(1.02);
                box-shadow: 0 25px 50px rgba(244, 143, 177, 0.3);
                border-color: rgba(244, 143, 177, 0.5);
            }

            .category-image {
                width: 100%;
                height: 200px;
                background: linear-gradient(135deg, #f48fb1, #556b2f);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 4rem;
                position: relative;
                overflow: hidden;
            }

            .category-image::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
            }

            .category-card:hover .category-image::before {
                background: rgba(0, 0, 0, 0.1);
            }

            .category-content {
                padding: 1.5rem;
            }

            .category-title {
                font-size: 1.5rem;
                color: #f48fb1;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }

            .category-description {
                color: #ccc;
                line-height: 1.6;
                margin-bottom: 1rem;
            }

            .category-link {
                color: #f48fb1;
                text-decoration: none;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.3s ease;
            }

            .category-link:hover {
                gap: 1rem;
            }

            /* Products Showcase */
            .products-showcase {
                padding: 5rem 2rem;
                background: rgba(0, 0, 0, 0.3);
            }

            .products-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }

            .product-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 1.5rem;
                border: 1px solid rgba(244, 143, 177, 0.2);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .product-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, #f48fb1, #556b2f);
            }

            .product-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(244, 143, 177, 0.2);
                border-color: rgba(244, 143, 177, 0.4);
            }

            .product-badge {
                display: inline-block;
                background: linear-gradient(135deg, #f48fb1, #f06292);
                color: #fff;
                padding: 0.3rem 0.8rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }

            .product-title {
                font-size: 1.3rem;
                color: #fff;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }

            .product-price {
                font-size: 1.5rem;
                color: #f48fb1;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .product-description {
                color: #ccc;
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }

            /* Stats Section */
            .stats-section {
                padding: 4rem 2rem;
                text-align: center;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
                max-width: 1000px;
                margin: 0 auto;
            }

            .stat-item {
                padding: 2rem;
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                border: 1px solid rgba(244, 143, 177, 0.2);
                transition: all 0.3s ease;
            }

            .stat-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(244, 143, 177, 0.2);
            }

            .stat-number {
                font-size: 3rem;
                font-weight: 700;
                color: #f48fb1;
                margin-bottom: 0.5rem;
            }

            .stat-label {
                color: #ccc;
                font-size: 1.1rem;
            }
        </style>
    @endif

    <link rel="stylesheet" href="{{ asset('css/pages/welcome.css') }}">
</head>

<body class="velvet-bg">
    <!-- Animated Flowers Background -->
    <div class="flower flower-1">≡ƒî╕</div>
    <div class="flower flower-2">≡ƒî║</div>
    <div class="flower flower-3">≡ƒî╝</div>
    <div class="flower flower-4">≡ƒî╖</div>
    <div class="flower flower-5">≡ƒî╣</div>

    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="logo-text slide-in-left">Lilly's Nook</div>
            @if (Route::has('login'))
                <ul class="nav-links">
                    @auth
                        <li><a href="{{ url('/dashboard') }}" class="fade-in">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="fade-in">Login</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="fade-in">Register</a></li>
                        @endif
                    @endauth
                </ul>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title fade-in">Welcome to Lilly's Nook</h1>
            <p class="hero-subtitle slide-in-right">Where Elegance Meets Lifestyle</p>
            <p class="hero-description fade-in">
                Discover a curated collection of premium fashion and lifestyle products designed to elevate your
                everyday experience. Immerse yourself in a world of sophistication and style.
            </p>
            <div class="cta-buttons fade-in">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Enter Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">Get Started</a>
                        <a href="{{ route('register') }}" class="btn-secondary">Join Now</a>
                    @endif
                    @endif
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <span class="feature-icon">Γ£¿</span>
                    <h3 class="feature-title">Premium Quality</h3>
                    <p class="feature-description">Experience the finest materials and craftsmanship in every piece we
                        offer.</p>
                </div>
                <div class="feature-card fade-in-delay-1">
                    <span class="feature-icon">≡ƒÄ¿</span>
                    <h3 class="feature-title">Exclusive Designs</h3>
                    <p class="feature-description">Discover unique styles that set you apart from the ordinary.</p>
                </div>
                <div class="feature-card fade-in-delay-2">
                    <span class="feature-icon">≡ƒîƒ</span>
                    <h3 class="feature-title">Personal Service</h3>
                    <p class="feature-description">Enjoy personalized attention and expert styling advice.</p>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="category-section">
            <h2 class="section-title fade-in">Shop by Category</h2>
            <div class="categories-grid">
                <div class="category-card fade-in">
                    <div class="category-image">
                        <span>≡ƒæù</span>
                    </div>
                    <div class="category-content">
                        <h3 class="category-title">Women's Fashion</h3>
                        <p class="category-description">Elegant dresses, trendy tops, and sophisticated accessories for the
                            modern woman.</p>
                        <a href="#" class="category-link">Explore Collection ΓåÆ</a>
                    </div>
                </div>
                <div class="category-card fade-in-delay-1">
                    <div class="category-image">
                        <span>≡ƒæö</span>
                    </div>
                    <div class="category-content">
                        <h3 class="category-title">Men's Fashion</h3>
                        <p class="category-description">Premium suits, casual wear, and accessories that define masculine
                            elegance.</p>
                        <a href="#" class="category-link">Explore Collection ΓåÆ</a>
                    </div>
                </div>
                <div class="category-card fade-in-delay-2">
                    <div class="category-image">
                        <span>≡ƒÆä</span>
                    </div>
                    <div class="category-content">
                        <h3 class="category-title">Beauty & Care</h3>
                        <p class="category-description">Luxury cosmetics, skincare products, and beauty essentials for your
                            daily routine.</p>
                        <a href="#" class="category-link">Explore Collection ΓåÆ</a>
                    </div>
                </div>
                <div class="category-card fade-in">
                    <div class="category-image">
                        <span>≡ƒæ£</span>
                    </div>
                    <div class="category-content">
                        <h3 class="category-title">Accessories</h3>
                        <p class="category-description">Designer bags, jewelry, watches, and other luxury accessories.</p>
                        <a href="#" class="category-link">Explore Collection ΓåÆ</a>
                    </div>
                </div>
                <div class="category-card fade-in-delay-1">
                    <div class="category-image">
                        <span>≡ƒæá</span>
                    </div>
                    <div class="category-content">
                        <h3 class="category-title">Footwear</h3>
                        <p class="category-description">Stylish shoes and boots for every occasion, combining comfort with
                            fashion.</p>
                        <a href="#" class="category-link">Explore Collection ΓåÆ</a>
                    </div>
                </div>
                <div class="category-card fade-in-delay-2">
                    <div class="category-image">
                        <span>≡ƒÅá</span>
                    </div>
                    <div class="category-content">
                        <h3 class="category-title">Home & Living</h3>
                        <p class="category-description">Elegant home decor, furniture, and lifestyle products for your
                            living space.</p>
                        <a href="#" class="category-link">Explore Collection ΓåÆ</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Showcase -->
        <section class="products-showcase">
            <h2 class="section-title fade-in">Featured Products</h2>
            <div class="products-grid">
                <div class="product-card fade-in">
                    <span class="product-badge">New Arrival</span>
                    <h3 class="product-title">Silk Evening Dress</h3>
                    <div class="product-price">Γé╣12,999</div>
                    <p class="product-description">Elegant silk dress perfect for special occasions. Available in multiple
                        colors.</p>
                    <a href="#" class="btn-primary" style="text-decoration: none; display: inline-block;">View
                        Details</a>
                </div>
                <div class="product-card fade-in-delay-1">
                    <span class="product-badge">Best Seller</span>
                    <h3 class="product-title">Leather Handbag</h3>
                    <div class="product-price">Γé╣8,499</div>
                    <p class="product-description">Premium leather handbag with spacious compartments and elegant design.
                    </p>
                    <a href="#" class="btn-primary" style="text-decoration: none; display: inline-block;">View
                        Details</a>
                </div>
                <div class="product-card fade-in-delay-2">
                    <span class="product-badge">Limited Edition</span>
                    <h3 class="product-title">Designer Watch</h3>
                    <div class="product-price">Γé╣24,999</div>
                    <p class="product-description">Luxury timepiece with Swiss movement and premium materials.</p>
                    <a href="#" class="btn-primary" style="text-decoration: none; display: inline-block;">View
                        Details</a>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stats-grid">
                <div class="stat-item fade-in">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="stat-item fade-in-delay-1">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Premium Products</div>
                </div>
                <div class="stat-item fade-in-delay-2">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Designer Brands</div>
                </div>
                <div class="stat-item fade-in">
                    <div class="stat-number">4.9Γÿà</div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>
        </section>

        @if (Route::has('login'))
            <div style="height: 100px;"></div>
        @endif
    </body>

    </html>
