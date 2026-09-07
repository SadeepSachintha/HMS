<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Register - Create your account</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

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
            padding: 20px 0;
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
            max-height: 95vh;
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
            padding: 40px;
            flex: 1;
            overflow-y: auto;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
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
        .login-logo a {
            text-decoration: none;
            color: inherit;
            display: inline-block;
            transition: transform 0.2s ease;
        }
        .login-logo a:hover {
            color: #F7E7CE;
            transform: scale(1.02);
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

        .form-control.is-invalid {
            border-color: #ff6b6b !important;
            background-color: rgba(255, 107, 107, 0.08) !important;
            box-shadow: 0 0 0 2px rgba(255, 107, 107, 0.25) !important;
            margin-bottom: 10px;
        }

        .form-control.is-invalid:focus {
            border-color: #ff6b6b !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.35) !important;
        }

        .btn-login {
            background-color: #D4AF37;
            border: none;
            border-radius: 6px;
            color: #0A1128;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
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
            margin-top: 25px;
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

        @media (min-width: 768px) {
            .login-image {
                display: block;
            }
        }

        .validation-error {
            color: #ff6b6b;
            font-size: 0.875rem;
            margin-top: 0;
            margin-bottom: 15px;
        }
        
        /* Custom scrollbar for form area */
        .login-form::-webkit-scrollbar {
            width: 8px;
        }
        .login-form::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05); 
        }
        .login-form::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.5); 
            border-radius: 4px;
        }
        .login-form::-webkit-scrollbar-thumb:hover {
            background: rgba(212, 175, 55, 0.8); 
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form">
            <div class="mb-3 text-start">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none small"><i class="fas fa-arrow-left me-1"></i> Back to Website</a>
            </div>
            <div class="login-logo">
                <a href="{{ url('/') }}">
                    <i class="fas fa-hotel"></i>
                    <h2>Create your account</h2>
                </a>
                <p class="text-muted">Create an account to book your stay</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert" style="background-color: rgba(255, 107, 107, 0.1); border-color: rgba(255, 107, 107, 0.2); color: #ff6b6b;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="requiredFieldsAlert" class="alert alert-danger d-flex align-items-center mb-3" style="display: none; background-color: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.4); color: #ff6b6b; border-radius: 8px; padding: 12px 16px;">
                <i class="fas fa-exclamation-circle me-2 fs-5 flex-shrink-0"></i>
                <div>
                    <strong>Please fill the required fields</strong>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                    <div id="name-error" class="validation-error text-danger" style="display: none;"><i class="fas fa-exclamation-circle me-1"></i>Please fill the required fields</div>
                    @error('name')
                        <div class="validation-error text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                    <div id="email-error" class="validation-error text-danger" style="display: none;"><i class="fas fa-exclamation-circle me-1"></i>Please fill the required fields</div>
                    @error('email')
                        <div class="validation-error text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="+94771234567">
                    @error('phone')
                        <div class="validation-error text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nic_passport" class="form-label">NIC or Passport Number</label>
                    <input id="nic_passport" type="text" class="form-control @error('nic_passport') is-invalid @enderror" name="nic_passport" value="{{ old('nic_passport') }}">
                    @error('nic_passport')
                        <div class="validation-error text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter password (min 8 characters)">
                    <div id="password-error" class="validation-error text-danger" style="display: none;"><i class="fas fa-exclamation-circle me-1"></i>Please fill the required fields</div>
                    @error('password')
                        <div class="validation-error text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                    <div id="password-confirm-error" class="validation-error text-danger" style="display: none;"><i class="fas fa-exclamation-circle me-1"></i>Please fill the required fields</div>
                </div>

                <button type="submit" class="btn btn-login">Register</button>

                <div class="register-link text-center">
                    Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const requiredFields = [
                { id: 'name', errId: 'name-error' },
                { id: 'email', errId: 'email-error' },
                { id: 'password', errId: 'password-error' },
                { id: 'password-confirm', errId: 'password-confirm-error' }
            ];

            let missing = false;
            requiredFields.forEach(function(item) {
                const input = document.getElementById(item.id);
                const errDiv = document.getElementById(item.errId);
                if (!input.value.trim()) {
                    missing = true;
                    input.classList.add('is-invalid');
                    if (errDiv) errDiv.style.display = 'block';
                } else {
                    input.classList.remove('is-invalid');
                    if (errDiv) errDiv.style.display = 'none';
                }
            });

            const alertBox = document.getElementById('requiredFieldsAlert');
            if (missing) {
                e.preventDefault();
                if (alertBox) {
                    alertBox.style.display = 'flex';
                    alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            } else {
                if (alertBox) alertBox.style.display = 'none';
            }
        });

        ['name', 'email', 'password', 'password-confirm'].forEach(function(id) {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                        const errDiv = document.getElementById(id + '-error');
                        if (errDiv) errDiv.style.display = 'none';
                        
                        // Check if any error is still visible
                        const anyInvalid = document.querySelector('.form-control.is-invalid');
                        const alertBox = document.getElementById('requiredFieldsAlert');
                        if (!anyInvalid && alertBox) {
                            alertBox.style.display = 'none';
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
