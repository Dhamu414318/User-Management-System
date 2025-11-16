<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #48bb78;
            --danger-color: #f56565;
            --warning-color: #ed8936;
            --info-color: #4299e1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 5px;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item:hover {
            background-color: #f0f0f0;
            color: var(--primary-color);
        }

        .main-content {
            flex: 1;
            padding: 30px 0;
        }

        .card {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-success {
            background: var(--success-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-success:hover {
            background: #38a169;
        }

        .btn-danger {
            background: var(--danger-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-danger:hover {
            background: #e53e3e;
        }

        .btn-warning {
            background: var(--warning-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-warning:hover {
            background: #dd6b20;
        }

        .btn-info {
            background: var(--info-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-info:hover {
            background: #3182ce;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .alert {
            border: none;
            border-radius: 10px;
            border-left: 4px solid;
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border-left-color: var(--success-color);
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left-color: var(--danger-color);
        }

        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border-left-color: var(--warning-color);
        }

        .alert-info {
            background: #f0f9ff;
            color: #0c4a6e;
            border-left-color: var(--info-color);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-admin {
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            color: white;
        }

        .badge-manager {
            background: linear-gradient(135deg, #ffa94d, #ff922b);
            color: white;
        }

        .badge-user {
            background: linear-gradient(135deg, #74c0fc, #4dabf7);
            color: white;
        }

        table {
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border: 1px solid #f0f0f0;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        .pagination {
            gap: 5px;
        }

        .page-link {
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            color: var(--primary-color);
            margin: 0 2px;
        }

        .page-link:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 40px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        footer {
            background: rgba(0,0,0,0.1);
            color: white;
            padding: 25px 0;
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        footer p {
            margin: 0;
            font-weight: 500;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .auth-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            animation: slideIn 0.3s ease;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .auth-header p {
            color: #666;
            font-size: 0.95rem;
        }

        .captcha-box {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }

        .captcha-box .question {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .form-text {
            color: #666;
            font-size: 0.85rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-people-fill"></i> User Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(session()->has('api_token'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.show') }}">
                                <i class="bi bi-person-circle"></i> Profile
                            </a>
                        </li>
                        @if(session()->get('user_role') === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-shield-lock"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i> {{ session()->get('user_name') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person"></i> My Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @if(session()->has('api_token'))
        <div class="main-content">
            <div class="container">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session()->get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    @else
        <div class="auth-container">
            <div class="auth-box">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session()->get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 User Management System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @yield('scripts')
</body>
</html>
