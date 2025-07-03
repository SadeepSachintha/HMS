<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
        }

        .login-image {
            background: url('https://images.pexels.com/photos/338504/pexels-photo-338504.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2') no-repeat center;
            background-size: cover;
            flex: 1;
            display: none;
        }

        .login-form {
            padding: 40px;
            flex: 1;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo i {
            font-size: 3rem;
            color: #1a73e8;
        }

        .login-logo h2 {
            margin-top: 10px;
            color: #333;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            transition: box-shadow 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.3);
            border-color: #1a73e8;
        }

        .btn-login {
            background-color: #1a73e8;
            border: none;
            border-radius: 8px;
            color: white;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #1557b0;
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #1a73e8;
            text-decoration: none;
        }

        .register-link {
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
        }

        .register-link a {
            color: #1a73e8;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 8px;
        }

        @media (min-width: 768px) {
            .login-image {
                display: block;
            }
        }

        .validation-error {
            color: #dc3545;
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
            border-color: #1a73e8;
        }

        .input-group .btn-outline-secondary {
            border-color: #ddd;
            border-left: none;
            padding: 12px 16px;
            color: #666;
            background-color: white;
            transition: all 0.3s ease;
        }

        .input-group .btn-outline-secondary:hover,
        .input-group .btn-outline-secondary:focus {
            color: #1a73e8;
            background-color: #f8f9fa;
            border-color: #ddd;
            box-shadow: none;
        }

        .input-group .form-control:focus,
        .input-group .btn-outline-secondary:focus {
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.3);
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

                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                    @endif
                </div>

                <div class="register-link text-center mt-3">
                    Don't have an account? <a href="{{ route('register') }}">Create one</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
