<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a2233 0%, #28416e 100%);
            color: #f1f1f1;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(40,65,110,0.18);
            background: #22325a !important;
        }
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            color: #f1f1f1 !important;
        }
        .navbar-brand img {
            height: 32px;
            margin-right: 10px;
            filter: brightness(0) invert(1) sepia(1) saturate(10) hue-rotate(180deg);
        }
        .navbar-nav .nav-link {
            color: #f1f1f1 !important;
            transition: color 0.2s;
        }
        .nav-link.active {
            color: #4b6fae !important;
            font-weight: 600;
        }
        .nav-link:hover {
            color: #28416e !important;
        }
        .hero-card {
            background: rgba(40, 65, 110, 0.95);
            border-radius: 1.5rem;
            box-shadow: 0 6px 32px rgba(40,65,110,0.12);
            padding: 3rem 2rem;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            color: #f1f1f1;
        }
        .hero-illustration {
            max-width: 320px;
            margin: 0 auto 2rem;
            display: block;
            filter: brightness(0.95) sepia(0.5) saturate(2) hue-rotate(180deg);
        }
        .about-card {
            background: #22325a;
            border-radius: 1rem;
            box-shadow: 0 2px 16px rgba(40,65,110,0.15);
            padding: 2rem;
            margin: 0 auto;
            max-width: 800px;
            color: #f1f1f1;
        }
        .about-icon {
            font-size: 2.5rem;
            color: #28416e;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background-color: #3a5a99;
            border-color: #3a5a99;
            color: #f1f1f1;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #28416e;
            border-color: #28416e;
            color: #f1f1f1;
        }
        .btn-outline-secondary {
            color: #28416e;
            border-color: #28416e;
        }
        .btn-outline-secondary:hover, .btn-outline-secondary:focus {
            background-color: #28416e;
            color: #f1f1f1;
        }
        .btn-light {
            background: #fff !important;
            color: #28416e !important;
            border: 1px solid #fff !important;
            font-weight: 600;
        }
        @media (max-width: 767px) {
            .hero-card {
                padding: 2rem 1rem;
            }
            .about-card {
                padding: 1.5rem;
            }
        }
        ::placeholder {
            color: #b6c6e3 !important;
            opacity: 1;
        }
        input.form-control::-moz-placeholder {
            color: #b6c6e3 !important;
            opacity: 1;
        }
        input.form-control:-ms-input-placeholder {
            color: #b6c6e3 !important;
        }
        input.form-control::-ms-input-placeholder {
            color: #b6c6e3 !important;
        }
        input.form-control::placeholder {
            color: #b6c6e3 !important;
            opacity: 1;
        }
        h1, h2, h3, h4, h5, h6, label, .card-title, .card-text, .modal-title, .form-label, .btn, .navbar-brand, .nav-link, p, span, strong {
            color: #f1f1f1 !important;
        }
        .text-primary {
            color: #4b6fae !important;
        }
        .text-muted {
            color: #b6c6e3 !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Lost & Found Logo">
                Lost & Found
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav" style="margin-right: 55px;">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lost.index') }}">Lost Items</a>
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

    <!-- Hero Section -->
    <div class="position-relative" style="min-height: 60vh;">
        <div class="container py-5 position-relative" style="z-index:2;">
            <div class="hero-card text-center">
                <img src="{{ asset('illustration.jpg') }}" alt="Lost and Found Illustration" class="hero-illustration mb-3">
                <h1 class="display-5 fw-bold mb-3" style="color:#f1f1f1;">Welcome to Lost & Found</h1>
                <p class="lead mb-4">Helping you reconnect with your lost belongings.</p>
                <a href="{{ route('lost.index') }}" class="btn btn-primary btn-lg px-4">View Lost Items</a>
            </div>
        </div>
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:linear-gradient(135deg,#28416e 0%,#22325a 100%);opacity:0.10;z-index:1;"></div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="about-card text-center">
            <div class="about-icon mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#f1f1f1" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.242 1.398a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                </svg>
            </div>
            <h2 class="mb-3" style="color:#f1f1f1;">About Lost & Found</h2>
            <p class="mb-0">
                Our Lost & Found system is designed to help individuals report and recover lost items.<br>
                Whether you've misplaced something or found an item, our platform makes it easy to connect with others and resolve the situation.
            </p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
