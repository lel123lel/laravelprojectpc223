<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lost & Found</a> <!-- Lost & Found text -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav" style="margin-right: 55px;">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lost.index') }}">Lost Items</a>
                    </li>
                </ul>
            </div>
              <a class="btn btn-primary ms-3" href="{{ route('login') }}">Log in</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-light text-center py-5">
        <div class="container">
            <h1 class="display-4">Welcome to Lost & Found</h1>
            <p class="lead">Helping you reconnect with your lost belongings.</p>
            <a href="{{ route('lost.index') }}" class="btn btn-primary btn-lg">View Lost Items</a>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">About Lost & Found</h2>
            <p class="text-center">
                Our Lost & Found system is designed to help individuals report and recover lost items. 
                Whether you've misplaced something or found an item, our platform makes it easy to connect with others and resolve the situation.
            </p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
