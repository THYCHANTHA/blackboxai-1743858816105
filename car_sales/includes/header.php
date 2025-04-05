<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- Tesla-inspired styling -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.pexels.com/photos/120049/pexels-photo-120049.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .nav-link {
            position: relative;
            padding-bottom: 5px;
        }
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        .nav-link:hover:after {
            width: 100%;
        }
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    <!-- Tesla-style minimalist header -->
    <header class="fixed w-full bg-white bg-opacity-90 z-50 shadow-sm">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="<?php echo SITE_URL; ?>/index.php" class="text-2xl font-bold text-blue-500">
                    <span class="text-black">ELITE</span>MOTORS
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="<?php echo SITE_URL; ?>/cars.php" class="nav-link">Inventory</a>
                    <a href="<?php echo SITE_URL; ?>/index.php#features" class="nav-link">Features</a>
                    <a href="<?php echo SITE_URL; ?>/index.php#testimonials" class="nav-link">Testimonials</a>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="nav-link">Contact</a>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/admin/" class="nav-link">Dashboard</a>
                        <a href="<?php echo SITE_URL; ?>/includes/logout.php" class="nav-link">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/login.php" class="nav-link">Login</a>
                    <?php endif; ?>
                </nav>

                <!-- Mobile menu button -->
                <button class="md:hidden focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden hidden py-4" id="mobile-menu">
                <a href="<?php echo SITE_URL; ?>/cars.php" class="block py-2">Inventory</a>
                <a href="<?php echo SITE_URL; ?>/index.php#features" class="block py-2">Features</a>
                <a href="<?php echo SITE_URL; ?>/index.php#testimonials" class="block py-2">Testimonials</a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="block py-2">Contact</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo SITE_URL; ?>/admin/" class="block py-2">Dashboard</a>
                    <a href="<?php echo SITE_URL; ?>/includes/logout.php" class="block py-2">Logout</a>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>/login.php" class="block py-2">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Mobile menu script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    <main class="pt-16"> <!-- Padding to account for fixed header -->