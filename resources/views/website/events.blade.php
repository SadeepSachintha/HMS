@php
    $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Events & Celebrations - {{ $settings->hotel_name ?? config('app.name', 'Hotel Management System') }}</title>

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
        .events-hero {
            position: relative;
            padding: 150px 0 80px;
            background: linear-gradient(to bottom, rgba(5, 8, 20, 0.8), rgba(5, 8, 20, 0.95)), url('{{ asset("storage/defaults/events_hero_bg.png") }}');
            background-size: cover;
            background-position: center;
            text-align: center;
        }
        .event-card {
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
        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
            border-color: var(--secondary-color);
        }
        .event-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
        }
        .event-image-placeholder {
            height: 200px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #15224F 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 1px solid var(--border-color);
        }
        .event-image-placeholder i {
            font-size: 3.5rem;
            color: var(--secondary-color);
            opacity: 0.6;
        }
        .event-date-tag {
            position: absolute;
            bottom: 0;
            left: 0;
            background: var(--secondary-color);
            color: var(--primary-color);
            padding: 6px 16px;
            font-weight: 700;
            font-size: 0.9rem;
            border-top-right-radius: 12px;
        }
        .event-details {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .event-details h3 {
            font-size: 1.4rem;
            color: var(--text-color);
            margin-bottom: 15px;
        }
        .event-details p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }
        .event-meta {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 15px;
            margin-top: auto;
        }
        .meta-item {
            color: var(--accent-color);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        .meta-item i {
            width: 20px;
            margin-right: 8px;
            color: var(--secondary-color);
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-hotel me-2"></i>{{ $settings->hotel_name ?? config('app.name', 'HMS') }}
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
                        <a class="nav-link" href="{{ route('website.events') }}">Venues</a>
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
    <header class="events-hero">
        <div class="container">
            <h1 class="display-4 text-white font-weight-bold">Our Premium Venues</h1>
            <p class="lead text-gold" style="color: var(--secondary-color); font-size: 1.25rem;">Discover our state-of-the-art event locations designed for unforgettable experiences</p>
        </div>
    </header>

    <!-- Locations Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                @forelse($locations as $location)
                <div class="col-lg-4 col-md-6">
                    <div class="event-card position-relative">
                        <div class="event-image-placeholder">
                            @if($location->image_path)
                                <img src="{{ asset('storage/' . $location->image_path) }}" alt="{{ $location->name }}" class="w-100 h-100" style="object-fit: cover; position: absolute; top: 0; left: 0;">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-map-marker-alt text-gold" style="font-size: 3.5rem; opacity: 0.6;"></i>
                                </div>
                            @endif
                        </div>

                        <div class="event-details">
                            <h3 class="text-white mb-3">{{ $location->name }}</h3>
                            <p class="text-muted mb-4">{{ $location->description ?? 'No details provided for this location.' }}</p>
                            
                            <div class="event-meta pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                                @if($location->capacity)
                                    <div class="meta-item text-gold d-flex align-items-center mb-0">
                                        <i class="fas fa-users me-2 text-gold"></i>
                                        <span>Max Capacity: <strong>{{ $location->capacity }}</strong> Guests</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-map-marker-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No event locations are registered at the moment.</h5>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <a href="{{ url('/') }}" class="footer-brand text-decoration-none">
                        <i class="fas fa-hotel me-2"></i>{{ $settings->hotel_name ?? config('app.name', 'HMS') }}
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
                        <li><a href="{{ route('website.events') }}">Venues</a></li>
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
                            <span>{{ $settings->contact_phone ?? '+94 11 234 5678' }}</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>{{ $settings->contact_email ?? 'reservations@hms.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $settings->hotel_name ?? config('app.name', 'Hotel Management System') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
