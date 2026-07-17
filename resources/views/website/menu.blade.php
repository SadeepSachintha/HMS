<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Food Menu - {{ config('app.name', 'Hotel Management System') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('css/vendor/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="{{ asset('css/vendor/all.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/website.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <style>
        .menu-hero {
            position: relative;
            padding: 150px 0 80px;
            background: linear-gradient(to bottom, rgba(5, 8, 20, 0.8), rgba(5, 8, 20, 0.95)), url('{{ asset("storage/defaults/menu_hero_bg.png") }}');
            background-size: cover;
            background-position: center;
            text-align: center;
        }
        .category-header {
            position: relative;
            display: inline-block;
            margin-bottom: 40px;
            color: var(--secondary-color);
            font-size: 2.2rem;
            font-weight: 700;
        }
        .category-header::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background-color: var(--secondary-color);
        }
        .food-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .food-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
            border-color: var(--secondary-color);
        }
        .food-img-wrapper {
            position: relative;
            overflow: hidden;
            padding-top: 60%; /* Aspect Ratio */
        }
        .food-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .food-card:hover .food-img-wrapper img {
            transform: scale(1.06);
        }
        .food-price {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--secondary-color);
            color: var(--primary-color);
            padding: 6px 16px;
            font-weight: 700;
            font-size: 1rem;
            border-top-left-radius: 12px;
        }
        .food-details {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .food-details h3 {
            font-size: 1.3rem;
            color: var(--text-color);
            margin-bottom: 10px;
        }
        .food-details p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 15px;
            flex-grow: 1;
        }
        .ingredient-badge {
            background: transparent;
            color: var(--accent-color);
            border: 1px solid rgba(212, 175, 55, 0.4);
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
            margin: 0 4px 6px 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-hotel me-2"></i>{{ config('app.name', 'HMS') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#websiteNavbar" aria-controls="websiteNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button>
            <div class="collapse navbar-collapse" id="websiteNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#featured-rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.menu') }}">Food Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.events') }}">Events</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-gold px-4 py-2" style="font-size: 0.9rem;">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-gold px-4 py-2" style="font-size: 0.9rem;">Book Now / Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Header -->
    <header class="menu-hero">
        <div class="container">
            <h1 class="display-4 text-white font-weight-bold">Gastronomic Excellence</h1>
            <p class="lead text-gold" style="color: var(--secondary-color); font-size: 1.25rem;">Indulge in a curated selection of culinary creations prepared by our master chefs</p>
        </div>
    </header>

    <!-- Menu Section -->
    <section class="section-padding">
        <div class="container">
            @php
                $categoryNames = [
                    'appetizer' => 'Appetizers',
                    'main_course' => 'Main Courses',
                    'dessert' => 'Desserts',
                    'beverage' => 'Beverages'
                ];
            @endphp

            @forelse($categoryNames as $key => $name)
                @if(isset($foodItems[$key]) && count($foodItems[$key]) > 0)
                    <div class="text-center mt-5 mb-4">
                        <h2 class="category-header">{{ $name }}</h2>
                    </div>
                    
                    <div class="row g-4 mb-5">
                        @foreach($foodItems[$key] as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="food-card">
                                <div class="food-img-wrapper">
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                                    @else
                                        <img src="{{ asset('storage/defaults/room-placeholder.jpg') }}" alt="{{ $item->name }}">
                                    @endif
                                    <div class="food-price">LKR {{ number_format($item->price, 2) }}</div>
                                </div>
                                <div class="food-details">
                                    <h3>{{ $item->name }}</h3>
                                    <p>{{ $item->description }}</p>
                                    
                                    @if(is_array($item->ingredients) && count($item->ingredients) > 0)
                                        <div class="mt-auto pt-2">
                                            <h6 class="text-muted" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Ingredients:</h6>
                                            <div class="d-flex flex-wrap mt-1">
                                                @foreach($item->ingredients as $ingredient)
                                                    <span class="ingredient-badge">{{ $ingredient }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                    <h5>No menu items are currently available.</h5>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <a href="{{ url('/') }}" class="footer-brand text-decoration-none">
                        <i class="fas fa-hotel me-2"></i>{{ config('app.name', 'HMS') }}
                    </a>
                    <p class="footer-text">
                        Setting the standard for luxury hospitality. We are committed to providing our guests with unforgettable experiences, impeccable service, and ultimate comfort.
                    </p>
                </div>
                
                <div class="col-lg-2 offset-lg-1 mb-4 mb-lg-0">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/') }}#featured-rooms">Rooms</a></li>
                        <li><a href="{{ route('website.menu') }}">Food Menu</a></li>
                        <li><a href="{{ route('website.events') }}">Events</a></li>
                        <li><a href="{{ route('login') }}">Book Now</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 offset-lg-1">
                    <h5 class="footer-heading">Contact Us</h5>
                    <ul class="footer-contact list-unstyled">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>No. 456, Galle Road, Colombo 03, Sri Lanka</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+94 11 234 5678</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>reservations&#64;{{ strtolower(str_replace(' ', '', config('app.name', 'hms'))) }}.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Hotel Management System') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
