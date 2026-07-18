<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hotel Management System') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('css/vendor/fonts.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @auth
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-hotel me-2"></i>HMS</h3>
            </div>

            <ul class="list-unstyled components">
                @if(!auth()->user()->isGuest())
                <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Front Office -->
                <li class="{{ Request::is('reservations*') || Request::is('customers*') ? 'active' : '' }}">
                    <a href="#frontOfficeSubmenu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('reservations*') || Request::is('customers*') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <i class="fas fa-concierge-bell"></i>
                        <span>Front Office</span>
                    </a>
                    <ul class="collapse list-unstyled {{ Request::is('reservations*') || Request::is('customers*') ? 'show' : '' }}" id="frontOfficeSubmenu">
                        <li class="{{ Request::is('reservations*') ? 'active' : '' }}">
                            <a href="{{ route('reservations.index') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Reservations</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('customers*') ? 'active' : '' }}">
                            <a href="{{ route('customers.index') }}">
                                <i class="fas fa-users"></i>
                                <span>Customers</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Room Management -->
                <li class="{{ Request::is('rooms*') || Request::is('room-types*') ? 'active' : '' }}">
                    <a href="#roomSubmenu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('rooms*') || Request::is('room-types*') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <i class="fas fa-bed"></i>
                        <span>Room Management</span>
                    </a>
                    <ul class="collapse list-unstyled {{ Request::is('rooms*') || Request::is('room-types*') ? 'show' : '' }}" id="roomSubmenu">
                        <li class="{{ Request::is('rooms*') ? 'active' : '' }}">
                            <a href="{{ route('rooms.index') }}">
                                <i class="fas fa-door-closed"></i>
                                <span>Rooms</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('room-types*') ? 'active' : '' }}">
                            <a href="{{ route('room-types.index') }}">
                                <i class="fas fa-door-open"></i>
                                <span>Room Types</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Hotel Services -->
                <li class="{{ Request::is('food-items*') || Request::is('events*') || Request::is('event-locations*') ? 'active' : '' }}">
                    <a href="#servicesSubmenu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('food-items*') || Request::is('events*') || Request::is('event-locations*') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>Services</span>
                    </a>
                    <ul class="collapse list-unstyled {{ Request::is('food-items*') || Request::is('events*') || Request::is('event-locations*') ? 'show' : '' }}" id="servicesSubmenu">
                        <li class="{{ Request::is('food-items*') ? 'active' : '' }}">
                            <a href="{{ route('food-items.index') }}">
                                <i class="fas fa-utensils"></i>
                                <span>Food Menu</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('events*') ? 'active' : '' }}">
                            <a href="{{ route('events.index') }}">
                                <i class="fas fa-calendar-day"></i>
                                <span>Events</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('event-locations*') ? 'active' : '' }}">
                            <a href="{{ route('event-locations.index') }}">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Locations</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('payments*') || Request::is('invoices*') ? 'active' : '' }}">
                    <a href="#billingSubmenu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('payments*') || Request::is('invoices*') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Billing</span>
                    </a>
                    <ul class="collapse list-unstyled {{ Request::is('payments*') || Request::is('invoices*') ? 'show' : '' }}" id="billingSubmenu">
                        <li>
                            <a href="{{ route('invoices.index') }}">
                                <i class="fas fa-file-invoice"></i>
                                <span>Invoices</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('payments.index') }}">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Payments</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @role('admin,manager')
                <!-- Administration -->
                <li class="{{ Request::is('staff*') || Request::is('users*') || Request::is('reports*') || Request::is('settings*') ? 'active' : '' }}">
                    <a href="#adminSubmenu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('staff*') || Request::is('users*') || Request::is('reports*') || Request::is('settings*') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <i class="fas fa-user-shield"></i>
                        <span>Administration</span>
                    </a>
                    <ul class="collapse list-unstyled {{ Request::is('staff*') || Request::is('users*') || Request::is('reports*') || Request::is('settings*') ? 'show' : '' }}" id="adminSubmenu">
                        <li class="{{ Request::is('staff*') ? 'active' : '' }}">
                            <a href="{{ route('staff.index') }}">
                                <i class="fas fa-user-tie"></i>
                                <span>Staff</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('users*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <i class="fas fa-users-cog"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('reports*') ? 'active' : '' }}">
                            <a href="{{ route('reports.index') }}">
                                <i class="fas fa-chart-bar"></i>
                                <span>Reports</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('settings*') ? 'active' : '' }}">
                            <a href="{{ route('settings.index') }}">
                                <i class="fas fa-cogs"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                @else
                <!-- Guest View -->
                <li class="{{ Request::is('reservations*') ? 'active' : '' }}">
                    <a href="{{ route('reservations.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>My Reservations</span>
                    </a>
                </li>
                <li class="{{ Request::is('payments*') || Request::is('invoices*') ? 'active' : '' }}">
                    <a href="{{ route('invoices.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>My Invoices</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        @endauth

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container-fluid">
                    @auth
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-align-left"></i>
                    </button>
                    @else
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <i class="fas fa-hotel me-2"></i>{{ config('app.name', 'Hotel Management System') }}
                    </a>
                    @endauth

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <!-- Alerts Dropdown -->
                                <li class="nav-item dropdown me-3">
                                    <a id="alertsDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bell"></i>
                                        <span class="badge bg-danger rounded-pill" id="alerts-count" style="position: absolute; top: 0; right: -5px; display: none;"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end alerts-dropdown" aria-labelledby="alertsDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                                        <h6 class="dropdown-header">Alerts</h6>
                                        <div id="alerts-container">
                                            <!-- Alerts will be loaded here -->
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-center" href="{{ route('alerts.index') }}">View All Alerts</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Flash Messages -->
            <div class="container mt-3">
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

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <link href="{{ asset('css/vendor/sweetalert2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/vendor/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
    <script src="{{ asset('js/delete-confirmation.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
            });

            // Global real-time debounced search for list views
            let searchTimeout = null;
            const searchInput = $('form[method="GET"] input[name="search"]');
            if (searchInput.length) {
                const val = searchInput.val();
                if (val) {
                    searchInput.focus();
                    // Put cursor at the end of the text input
                    searchInput[0].setSelectionRange(val.length, val.length);
                }
                
                searchInput.on('input', function() {
                    clearTimeout(searchTimeout);
                    const form = $(this).closest('form');
                    
                    searchTimeout = setTimeout(function() {
                        form.submit();
                    }, 700); // 700ms debounce to allow user to finish typing
                });
            }
        });

        // Auto-dismiss alerts after 3 seconds
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
                }, 3000);
            });
        });
    </script>
    @stack('scripts')
    @yield('scripts')

    <!-- Inactivity Warning Modal -->
    <div class="modal fade" id="inactivityModal" tabindex="-1" aria-labelledby="inactivityModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="inactivityModalLabel">Session Expiring Soon</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            You have been inactive for a while. You will be logged out in <span id="logoutCountdown">60</span> seconds.<br>
            Do you want to stay signed in?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="stayLoggedInBtn" data-bs-dismiss="modal">Stay Signed In</button>
          </div>
        </div>
      </div>
    </div>

    <script>
    (function() {
        var inactivityTime = 15 * 60 * 1000; // 15 minutes
        var warningTime = 14 * 60 * 1000; // Show modal at 14 minutes
        var logoutCountdown = 60; // seconds
        var timer, warningTimer, countdownInterval;
        var modalShown = false;

        function resetTimer() {
            clearTimeout(timer);
            clearTimeout(warningTimer);
            if (modalShown) {
                hideModal();
            }
            startTimers();
        }

        function startTimers() {
            warningTimer = setTimeout(showModal, warningTime);
            timer = setTimeout(logout, inactivityTime);
        }

        function showModal() {
            modalShown = true;
            var modal = new bootstrap.Modal(document.getElementById('inactivityModal'));
            document.getElementById('logoutCountdown').textContent = logoutCountdown;
            modal.show();
            countdownInterval = setInterval(function() {
                logoutCountdown--;
                document.getElementById('logoutCountdown').textContent = logoutCountdown;
                if (logoutCountdown <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
        }

        function hideModal() {
            modalShown = false;
            logoutCountdown = 60;
            clearInterval(countdownInterval);
            var modalEl = document.getElementById('inactivityModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }

        function logout() {
            document.getElementById('logout-form').submit();
        }

        // Reset timer on user activity
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeydown = resetTimer;
        document.onscroll = resetTimer;
        document.onclick = resetTimer;
        document.ontouchstart = resetTimer;

        // Stay signed in button
        document.addEventListener('DOMContentLoaded', function() {
            var stayBtn = document.getElementById('stayLoggedInBtn');
            if (stayBtn) {
                stayBtn.addEventListener('click', function() {
                    resetTimer();
                });
            }
        });

        startTimers();
    })();
    </script>
</body>
</html>
