<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'IETI School Activities Scheduling and Inventory Management System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --ieti-yellow: #FFD700;
            --ieti-green: #a3b18a;
            --ieti-green-dark: #6b7c4a;
            --ieti-black: #000000;
            --ieti-white: #FFFFFF;
        }

        body {
            font-family: 'Figtree', 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        .login-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('IETI-background.png') }}');
            background-size: cover;
            background-position: center;
            filter: blur(3px);
            z-index: -1;
        }

        .login-background::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(163, 177, 138, 0.25);
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 900px;
            padding: 20px;
        }

        .login-card {
            background: var(--ieti-white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: row;
            min-height: 480px;
        }

        /* Left panel: blurred IETI background image */
        .login-split-left {
            flex: 0 0 40%;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .login-split-left::before {
            content: '';
            position: absolute;
            inset: -20px;
            background: url('{{ asset('IETI-background.png') }}') center / cover no-repeat;
            filter: blur(3px);
            pointer-events: none;
            z-index: 0;
        }

        .login-split-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(45, 49, 38, 0.25);
            pointer-events: none;
            z-index: 1;
        }

        .split-left-top {
            position: relative;
            z-index: 2;
            padding: 36px 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .split-logo-wrap {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid var(--ieti-green);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .split-logo-wrap img {
            width: 125%;
            height: 125%;
            object-fit: cover;
        }

        .split-left-bottom {
            flex: 1;
            position: relative;
            z-index: 2;
            padding: 28px 28px 24px;
            display: flex;
            flex-direction: column;
        }

        .split-left-main {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .split-title {
            position: relative;
            margin: 0;
            color: var(--ieti-white);
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.35;
            text-align: center;
        }

        .split-title .title-emphasis {
            font-weight: 700;
        }

        .split-footer {
            position: relative;
            color: var(--ieti-white);
            font-size: 0.8rem;
            text-align: center;
            padding-top: 24px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.25);
        }

        .split-footer .school-name {
            font-weight: 600;
            display: block;
        }

        .split-footer .since-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 8px;
        }

        .split-footer .since-line {
            width: 24px;
            height: 1px;
            background: var(--ieti-yellow);
        }

        .split-footer .since {
            font-weight: 500;
        }

        /* Right panel - form */
        .login-split-right {
            flex: 1;
            padding: 40px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .split-form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .split-form-title-underline {
            display: flex;
            width: 64px;
            height: 4px;
            border-radius: 2px;
            margin-bottom: 28px;
            overflow: hidden;
        }

        .split-form-title-underline span {
            flex: 1;
            height: 100%;
        }

        .split-form-title-underline .line-green {
            background: var(--ieti-green);
        }

        .split-form-title-underline .line-yellow {
            background: var(--ieti-yellow);
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .input-group-text {
            background: #f5f6f8;
            border: 1px solid #e0e2e6;
            border-right: none;
            color: #555;
        }

        .form-control {
            border: 1px solid #e0e2e6;
            border-left: none;
            padding: 12px 14px;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text {
            border-color: var(--ieti-green);
        }

        .form-control:focus {
            border-color: var(--ieti-green);
            box-shadow: 0 0 0 0.2rem rgba(163, 177, 138, 0.2);
        }

        .btn-login {
            background: var(--ieti-green-dark);
            border: none;
            color: var(--ieti-white);
            padding: 12px 24px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-login:hover {
            background: var(--ieti-green);
            color: var(--ieti-white);
        }

        .btn-password-toggle {
            background: #f5f6f8;
            border: 1px solid #e0e2e6;
            border-left: none;
            color: #555;
            padding: 12px 14px;
            cursor: pointer;
        }

        .btn-password-toggle:hover {
            background: #e9ecef;
            color: #333;
        }

        .form-check-input:checked {
            background-color: var(--ieti-green);
            border-color: var(--ieti-green);
        }

        .form-check-input:focus {
            border-color: var(--ieti-green);
            box-shadow: 0 0 0 0.2rem rgba(163, 177, 138, 0.25);
        }

        .link-forgot {
            color: var(--ieti-green-dark);
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid var(--ieti-green);
        }

        .link-forgot:hover {
            color: var(--ieti-green-dark);
            text-decoration: none;
            border-bottom-color: var(--ieti-green-dark);
        }

        /* Responsive: stack panels on small screens */
        @media (max-width: 767px) {
            .login-card {
                flex-direction: column;
                min-height: auto;
            }

            .login-split-left {
                flex: none;
            }

            .split-left-top {
                padding: 28px 20px;
            }

            .split-logo-wrap {
                width: 90px;
                height: 90px;
            }

            .split-left-bottom {
                padding: 24px 20px 20px;
            }

            .split-left-main {
                min-height: 0;
            }

            .split-title {
                font-size: 1.15rem;
            }

            .split-footer {
                padding-top: 20px;
            }

            .login-split-right {
                padding: 32px 24px;
            }

            .split-form-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-background"></div>
    <div class="login-container">
        <div class="login-card">
            <div class="login-split-left">
                <div class="split-left-top">
                    <div class="split-logo-wrap">
                        <img src="{{ asset('logo.jpg') }}" alt="IETI Logo">
                    </div>
                </div>
                <div class="split-left-bottom">
                    <div class="split-left-main">
                        <h2 class="split-title">
                            School Activities and <span class="title-emphasis">Inventory Management</span> System
                        </h2>
                    </div>
                    <div class="split-footer">
                        <span class="school-name">IETI College of Science and Technology</span>
                        <div class="since-wrap">
                            <span class="since-line"></span>
                            <span class="since">Since 1974</span>
                            <span class="since-line"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-split-right">
                <h3 class="split-form-title">Login</h3>
                <div class="split-form-title-underline">
                    <span class="line-green"></span>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus
                                   placeholder="Enter your email">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Enter your password">
                            <button class="btn btn-password-toggle" type="button" id="togglePassword">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login">
                            Login
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="link-forgot">
                            Forgot Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (togglePassword && passwordInput && toggleIcon) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleIcon.classList.toggle('fa-eye', type === 'password');
                toggleIcon.classList.toggle('fa-eye-slash', type === 'text');
            });
        }
    });
    </script>
</body>
</html>
