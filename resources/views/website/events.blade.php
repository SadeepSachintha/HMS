<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Events & Celebrations - {{ config('app.name', 'Hotel Management System') }}</title>

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
    <header class="events-hero">
        <div class="container">
            <h1 class="display-4 text-white font-weight-bold">Events & Celebrations</h1>
            <p class="lead text-gold" style="color: var(--secondary-color); font-size: 1.25rem;">Experience spectacular moments and grand celebrations hosted at our premium venues</p>
        </div>
    </header>

    <!-- Events Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                @forelse($events as $event)
                <div class="col-lg-4 col-md-6">
                    <div class="event-card position-relative">
                        <div class="event-image-placeholder">
                            @if($event->location_rel && $event->location_rel->image_path)
                                <img src="{{ asset('storage/' . $event->location_rel->image_path) }}" alt="{{ $event->location_rel->name }}" class="w-100 h-100" style="object-fit: cover; position: absolute; top: 0; left: 0;">
                            @else
                                <i class="fas {{ $event->status === 'completed' ? 'fa-calendar-check' : 'fa-calendar-day' }}"></i>
                            @endif
                            
                            @php
                                $date = \Carbon\Carbon::parse($event->start_time);
                            @endphp
                            <div class="event-date-tag">
                                {{ $date->format('M d, Y') }}
                            </div>
                        </div>

                        <!-- Status Badge -->
                        @if($event->status === 'completed')
                            <span class="event-badge bg-secondary text-white">Completed</span>
                        @elseif($event->status === 'in_progress')
                            <span class="event-badge bg-warning text-dark">In Progress</span>
                        @else
                            <span class="event-badge bg-success text-white">Upcoming</span>
                        @endif

                        <div class="event-details">
                            <h3>{{ $event->name }}</h3>
                            <p>{{ $event->description ?? 'No details provided.' }}</p>
                            
                            <div class="event-meta">
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $date->format('h:i A') }} onwards</span>
                                </div>
                                <div class="meta-item align-items-start">
                                    <i class="fas fa-map-marker-alt mt-1"></i>
                                    <span>
                                        <strong>{{ $event->location_rel->name ?? $event->location }}</strong>
                                        @if($event->location_rel && $event->location_rel->description)
                                            <span class="d-block text-muted mt-1" style="font-size: 0.8rem; line-height: 1.4;">{{ $event->location_rel->description }}</span>
                                        @endif
                                    </span>
                                </div>
                                @if($event->price && $event->price > 0)
                                    <div class="meta-item">
                                        <i class="fas fa-ticket-alt"></i>
                                        <span>LKR {{ number_format($event->price, 2) }}</span>
                                    </div>
                                @else
                                    <div class="meta-item">
                                        <i class="fas fa-ticket-alt"></i>
                                        <span class="text-success">Free Admission</span>
                                    </div>
                                @endif
                                @if($event->max_attendees)
                                    <div class="meta-item">
                                        <i class="fas fa-users"></i>
                                        <span>Max Capacity: {{ $event->max_attendees }} Guests</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5>No events are scheduled at the moment. Please check back later!</h5>
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
