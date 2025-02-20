<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8">
                    <h1 class="display-4 mb-3">Welcome to Our Platform</h1>
                    <p class="lead mb-4">Discover amazing posts from our community</p>
                    @guest
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 gap-3">Get Started</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4">Sign In</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Section -->
    <div class="container py-5">
        <!-- Search and Filter (optional) -->
        <div class="row mb-4">
            <div class="col-md-6">
                <form action="{{ route('welcome') }}" method="GET" class="d-flex">
                    <input type="search" name="search" class="form-control me-2" placeholder="Search posts..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </form>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($posts as $post)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $post->title }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-tag"></i> {{ $post->category->nom }}
                            </p>
                            <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                            @if($post->price)
                                <p class="card-text">
                                    <strong>Price: </strong>${{ number_format($post->price, 2) }}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Posted {{ $post->created_at->diffForHumans() }}
                                </small>
                                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('Mohammed Abdeljalil', 'Mohammed Abdeljalil') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>