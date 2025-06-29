<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hotel Management System</title>

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

        .register-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
        }

        .register-image {
            background: url('https://images.pexels.com/photos/338504/pexels-photo-338504.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2') no-repeat center;
            background-size: cover;
            flex: 1;
            display: none;
        }

        .register-form {
            padding: 40px;
            flex: 1;
        }

        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-logo i {
            font-size: 3rem;
            color: #1a73e8;
        }

        .register-logo h2 {
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

        .btn-register {
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

        .btn-register:hover {
            background-color: #1557b0;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #1a73e8;
            text-decoration: none;
        }

        @media (min-width: 768px) {
            .register-image {
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
    <div class="register-container">
        <div class="register-image"></div>
        <div class="register-form">
            <div class="register-logo">
                <i class="fas fa-hotel"></i>
                <h2>Hotel Management System</h2>
                <p class="text-muted">Create your account</p>
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

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" required>
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

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password-confirm"
                            name="password_confirmation" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-register">Register</button>

                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
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
            togglePasswordVisibility(passwordInput, icon);
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordInput = document.getElementById('password-confirm');
            const icon = this.querySelector('i');
            togglePasswordVisibility(passwordInput, icon);
        });

        function togglePasswordVisibility(input, icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
