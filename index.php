<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Jambo Hotel Reservations</title>
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Link to your CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">JAMBO RESERVATIONS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="views/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="views/register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="views/dashboard.php">Dashboard</a></li>
                    
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Bootstrap Carousel -->
<section id="hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/images/best-pink-hotels-Cobblers-Cove-hotel.jpg." class="d-block w-100" alt="Hotel View 1">
            <div class="carousel-caption">
                <h2>WELCOME TO JAMBO HOTEL</h2>
                <p>Experience luxury like never before</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/Top-10-Luxury-Hotels.jpg" class="d-block w-100" alt="Hotel View 2">
            <div class="carousel-caption">
                <h2>RELAX & ENJOY</h2>
                <p>Unwind in our world-class rooms</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images\karibu.jpg" class="d-block w-100" alt="Hotel View 3">
            <div class="carousel-caption">
                <h2>BOOK YOUR STAY</h2>
                <p>Reserve your perfect getaway today</p>
            </div>
        </div>
    </div>

    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</section>

    <!-- About Us Section -->
    <section class="about-us py-5">
        <div class="container text-center">
            <h2>About Us</h2>
            <p>
                Jambo Hotel is a premier destination for luxury and comfort. We provide world-class accommodation 
                with top-notch services to ensure your stay is unforgettable. 
            </p>
        </div>
    </section>
    <!-- Contact Section -->
    <section class="contact bg-light py-4">
        <div class="container text-center">
            <h2>Contact Us</h2>
            <p><i class="fa fa-phone"></i> Phone: +254 712 345 675</p>
            <p><i class="fa fa-envelope"></i> Email: info@jambohotel.com</p>
            <p><i class="fa fa-map-marker"></i> Address: Nairobi, Kenya</p>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
