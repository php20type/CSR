<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Finance Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .carousel-item img {
            width: 100%; /* Full width */
            height: 500px; /* Fixed height */
            object-fit: cover; /* Ensures proper fit */
        }
    </style>

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light p-3">
        <a class="navbar-brand" href="#">NGO Finance</a>
        <div>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            {{-- <a href="{{ route('register') }}" class="btn btn-success">Register</a> --}}
        </div>
    </nav>

    <!-- Image Slider -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/slider1.png') }}" class="d-block w-100" alt="NGO 1">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- About NGOs -->
    <div class="container text-center mt-5">
        <h1>Support NGOs & Manage Finances</h1>
        <p>Our system helps track NGO funding and manage donations efficiently.</p>
    </div>

</body>
</html>
