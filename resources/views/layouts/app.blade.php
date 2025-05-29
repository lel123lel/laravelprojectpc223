<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Demo App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #22325a 0%, #28416e 100%);
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(40,65,110,0.12);
            padding: 3rem 1.5rem 2rem 1.5rem;
            margin-bottom: 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section h1 {
            font-weight: 800;
            color: #28416e;
            letter-spacing: 2px;
        }
        .hero-section p {
            font-size: 1.25rem;
            color: #b6c6e3;
            margin-bottom: 2rem;
        }
        .hero-illustration {
            position: absolute;
            right: 2rem;
            bottom: 0;
            width: 180px;
            opacity: 0.12;
            z-index: 0;
        }
        .hero-btn {
            font-size: 1.15rem;
            padding: 0.75rem 2.5rem;
            border-radius: 30px;
            font-weight: 600;
            background: #28416e;
            border: none;
            color: #fff;
            box-shadow: 0 2px 12px rgba(40,65,110,0.10);
            transition: background 0.2s;
        }
        .hero-btn:hover, .hero-btn:focus {
            background: #3a5a99;
            color: #fff;
        }
        .navbar {
            background: #22325a !important;
        }
        .navbar-light .navbar-brand,
        .navbar-light .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar-light .navbar-nav .nav-link.active {
            color: #4b6fae !important;
            font-weight: 600;
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: #28416e !important;
        }
        .btn-primary {
            background-color: #28416e;
            border-color: #28416e;
            color: #fff;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #3a5a99;
            border-color: #3a5a99;
            color: #fff;
        }
        .btn-outline-secondary {
            color: #28416e;
            border-color: #28416e;
        }
        .btn-outline-secondary:hover, .btn-outline-secondary:focus {
            background-color: #28416e;
            color: #fff;
        }
        body {
            background: linear-gradient(135deg, #1a2233 0%, #28416e 100%) fixed;
            color: #fff;
        }
        @media (max-width: 768px) {
            .hero-illustration { display: none; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lost & Found</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav" style="margin-right: 55px;">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lost.index') ? 'active' : '' }}" href="{{ route('lost.index') }}">Lost Items</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin') }}">Admin</a>
                    </li>
                    @endauth
                </ul>
            </div>
            @auth
                <div class="d-flex align-items-center ms-3">
                    <span class="me-2">{{ Auth::user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" style="color:#fff; font-weight:600;">Logout</button>
                    </form>
                </div>
            @else
                <a class="btn btn-primary ms-3" href="{{ route('login') }}">Log in</a>
            @endauth
        </div>
    </nav>
    <!-- Hero Section (only on initial/landing page) -->
    @if(request()->is('/'))
    <div class="container">
        <div class="hero-section mt-4 mb-4">
            <h1>Welcome to Lost &amp; Found</h1>
            <p>Quickly report, search, and recover lost items.<br>
            Helping you reconnect with your belongings in a modern, easy-to-use platform.</p>
            <a href="{{ route('lost.index') }}" class="hero-btn">Get Started</a>
            <svg class="hero-illustration" viewBox="0 0 200 200" fill="none">
                <ellipse cx="100" cy="100" rx="100" ry="100" fill="#6366f1"/>
                <ellipse cx="100" cy="100" rx="70" ry="70" fill="#a5b4fc"/>
                <ellipse cx="100" cy="100" rx="40" ry="40" fill="#fff"/>
            </svg>
        </div>
    </div>
    @endif
    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
