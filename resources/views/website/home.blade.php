<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Hotel Management System') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('css/vendor/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="{{ asset('css/vendor/all.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/website.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
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
                        <a class="nav-link" href="#featured-rooms">Rooms & Suites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#amenities">Amenities</a>
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

    <!-- Flash Messages -->
    <div class="container" style="position: relative; z-index: 1050; margin-top: 100px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Experience Unmatched Luxury</h1>
            <p>Welcome to {{ config('app.name', 'our hotel') }}. Discover a world of elegance, comfort, and personalized service designed to make your stay unforgettable.</p>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-gold me-3">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-gold me-3">Book Your Stay</a>
                    <a href="#featured-rooms" class="btn-outline-gold">Explore Rooms</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Featured Rooms Section -->
    <section id="featured-rooms" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Our Signature Accommodations</h2>
                <p>Relax in our meticulously designed rooms and suites, offering stunning views and premium amenities for the perfect getaway.</p>
            </div>
            
            <div class="row g-4">
                @forelse($featuredRooms as $roomType)
                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img-wrapper">
                            <img src="{{ asset($roomType->main_image_url) }}" alt="{{ $roomType->name }}">
                            <div class="room-price">LKR {{ number_format($roomType->price_per_night, 2) }} / Night</div>
                        </div>
                        <div class="room-details">
                            <h3>{{ $roomType->name }}</h3>
                            <p>{{ Str::limit($roomType->description, 100) }}</p>
                            
                            <div class="room-features">
                                <div class="feature-item">
                                    <i class="fas fa-users"></i> Up to {{ $roomType->capacity }} Guests
                                </div>
                                @if(is_array($roomType->amenities) && count($roomType->amenities) > 0)
                                    <div class="feature-item">
                                        <i class="fas fa-star"></i> {{ count($roomType->amenities) }} Premium Amenities
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-auto pt-3 text-center">
                                <a href="{{ route('login') }}" class="btn-outline-gold w-100 py-2">Book This Room</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No rooms currently available to display.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Amenities Section -->
    <section id="amenities" class="section-padding amenities-section">
        <div class="container">
            <div class="section-title">
                <h2>Exceptional Services</h2>
                <p>We provide everything you need for a relaxing and enjoyable stay, from world-class dining to rejuvenating spa treatments.</p>
            </div>
            
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="amenity-box">
                        <div class="amenity-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4>Fine Dining</h4>
                        <p>Experience culinary masterpieces prepared by our award-winning chefs using the freshest local ingredients.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="amenity-box">
                        <div class="amenity-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4>Luxury Spa</h4>
                        <p>Relax and rejuvenate with our extensive range of therapeutic massages and holistic spa treatments.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="amenity-box">
                        <div class="amenity-icon">
                            <i class="fas fa-swimming-pool"></i>
                        </div>
                        <h4>Infinity Pool</h4>
                        <p>Take a dip in our temperature-controlled infinity pool offering breathtaking views of the city skyline.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="amenity-box">
                        <div class="amenity-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h4>Fitness Center</h4>
                        <p>Stay in shape during your travels with our state-of-the-art gym equipment and professional trainers.</p>
                    </div>
                </div>
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
                        <li><a href="#featured-rooms">Rooms</a></li>
                        <li><a href="#amenities">Amenities</a></li>
                        <li><a href="{{ route('food-items.index') }}">Food Menu</a></li>
                        <li><a href="{{ route('events.index') }}">Events</a></li>
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
    
    <!-- Navbar Scroll Effect -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener("scroll", function() {
                if (window.scrollY > 50) {
                    document.querySelector('.navbar-custom').style.background = 'rgba(5, 8, 20, 0.95)';
                    document.querySelector('.navbar-custom').style.boxShadow = '0 4px 20px rgba(0,0,0,0.5)';
                } else {
                    document.querySelector('.navbar-custom').style.background = 'rgba(10, 17, 40, 0.7)';
                    document.querySelector('.navbar-custom').style.boxShadow = 'none';
                }
            });
        });
    </script>
    <!-- Auto-dismiss alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeButton = alert.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.click();
                    } else {
                        alert.remove();
                    }
                }, 5000); // 5 seconds for visibility on landing page
            });
        });
    </script>
</body>
</html>
