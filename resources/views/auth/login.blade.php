<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Login</title>

    <!-- Styles -->
    <link href="{{ asset('css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/fonts.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #050814;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .login-container {
            background-color: #0A1128;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            max-width: 900px;
            width: 90%;
            display: flex;
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: #fff;
        }

        .login-image {
            background: url('{{ asset('images/website/hero_bg.png') }}') no-repeat center;
            background-size: cover;
            flex: 1;
            display: none;
            position: relative;
        }
        
        .login-image::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to right, rgba(10, 17, 40, 0.2), rgba(10, 17, 40, 0.9));
        }

        .login-form {
            padding: 50px 40px;
            flex: 1;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo i {
            font-size: 3rem;
            color: #D4AF37;
        }

        .login-logo h2 {
            margin-top: 15px;
            color: #D4AF37;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }
        
        .text-muted {
            color: #b0b5c1 !important;
        }

        .form-label {
            color: #e0e0e0;
            font-weight: 500;
        }

        .form-control {
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.3);
            border-color: #D4AF37;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .btn-login {
            background-color: #D4AF37;
            border: none;
            border-radius: 6px;
            color: #0A1128;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #bfa030;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        .register-link {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 30px;
            color: #b0b5c1;
        }

        .register-link a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #F7E7CE;
            text-decoration: underline;
        }

        .remember-me {
            display: flex;
            align-items: center;
            color: #b0b5c1;
        }

        .remember-me input {
            margin-right: 8px;
            cursor: pointer;
        }

        @media (min-width: 768px) {
            .login-image {
                display: block;
            }
        }

        .validation-error {
            color: #ff6b6b;
            font-size: 0.875rem;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        /* Password input group styles */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group .form-control {
            margin-bottom: 0;
            border-right: none;
        }

        .input-group .form-control:focus + .btn-outline-secondary {
            border-color: #D4AF37;
        }

        .input-group .btn-outline-secondary {
            border-color: rgba(255, 255, 255, 0.1);
            border-left: none;
            padding: 12px 16px;
            color: #b0b5c1;
            background-color: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .input-group .btn-outline-secondary:hover,
        .input-group .btn-outline-secondary:focus {
            color: #D4AF37;
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: none;
        }

        .input-group .form-control:focus,
        .input-group .btn-outline-secondary:focus {
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.3);
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form">
            <div class="login-logo">
                <i class="fas fa-hotel"></i>
                <h2>Hotel Management System</h2>
                <p class="text-muted">Sign in to access your dashboard</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-login">Sign In</button>

                {{-- <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                    @endif
                </div> --}}

                <div class="register-link text-center mt-3">
                    Don't have an account? <a href="{{ route('register') }}">Create one</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Password toggle visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>
