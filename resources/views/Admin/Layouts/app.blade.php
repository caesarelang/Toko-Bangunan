<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Toko')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0a0a;
            color: #fff;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        .grid-background {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFloat 15s infinite;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.4);
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0) scale(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(200px) scale(1.5) rotate(720deg);
                opacity: 0;
            }
        }

        /* Glowing Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: float 20s infinite ease-in-out;
            pointer-events: none;
        }

        .orb1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, #888888, #666666);
            top: -200px;
            left: -200px;
        }

        .orb2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(45deg, #aaaaaa, #888888);
            bottom: -250px;
            right: -250px;
        }

        .orb3 {
            width: 350px;
            height: 350px;
            background: linear-gradient(45deg, #777777, #555555);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(100px, -100px) scale(1.2);
            }
            66% {
                transform: translate(-100px, 100px) scale(0.9);
            }
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(17, 17, 17, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            color: #fff !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            font-size: 28px;
            animation: hammerSwing 2s infinite ease-in-out;
        }

        @keyframes hammerSwing {
            0%, 100% {
                transform: rotate(-15deg);
            }
            50% {
                transform: rotate(15deg);
            }
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            bottom: 0;
            width: 260px;
            background: rgba(17, 17, 17, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px 0;
            z-index: 999;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .nav-item {
            margin-bottom: 8px;
            padding: 0 20px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.6) !important;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-link i {
            font-size: 18px;
            width: 20px;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff !important;
            transform: translateX(5px);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 40px;
            min-height: calc(100vh - 70px);
            position: relative;
            z-index: 1;
        }

        /* Content Card */
        .content-card {
            background: rgba(17, 17, 17, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        /* Bootstrap Override */
        .card {
            background: rgba(17, 17, 17, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .table {
            color: #fff;
        }

        .table thead {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .table tbody {
            border-color: rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #aaaaaa 0%, #888888 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #bbbbbb 0%, #999999 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(170, 170, 170, 0.4);
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.3);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .top-navbar {
                padding: 15px 20px;
            }
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Animated Background -->
    <div class="grid-background">
        <!-- Particles (20 particles for performance) -->
        <div class="particle" style="left: 5%; animation-delay: 0s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 15%; animation-delay: 1s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 25%; animation-delay: 2s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 35%; animation-delay: 3s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 45%; animation-delay: 4s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 55%; animation-delay: 5s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 65%; animation-delay: 6s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 75%; animation-delay: 7s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 85%; animation-delay: 8s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 95%; animation-delay: 9s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 10%; animation-delay: 1.5s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 2.5s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 3.5s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 4.5s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 5.5s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 6.5s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 7.5s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 8.5s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 9.5s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 12%; animation-delay: 0.5s; animation-duration: 14s;"></div>
    </div>

    <!-- Glowing Orbs -->
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>

    <!-- Top Navbar -->
    <nav class="top-navbar">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-hammer"></i>
            Toko Bangunan
        </a>
        <div class="navbar-user">
            <span class="navbar-text">
                <i class="bi bi-person-circle"></i> {{ auth()->user()->name ?? 'Admin' }}
            </span>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories') }}" class="nav-link">
                    <i class="bi bi-tags"></i> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products') }}" class="nav-link">
                    <i class="bi bi-box-seam"></i> Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders') }}" class="nav-link">
                    <i class="bi bi-bag-check"></i> Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.transactions') }}" class="nav-link">
                    <i class="bi bi-receipt"></i> Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.reports') }}" class="nav-link">
                    <i class="bi bi-bar-chart"></i> Laporan
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Active link highlight
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>