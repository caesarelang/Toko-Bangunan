<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Customer Dashboard')</title>

    <!-- optional: tetap pake bootstrap untuk komponen, styling tambahan override di bawah -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- Global / Theme (diadaptasi dari login) --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root{
            --bg-dark: #0a0a0a;
            --card-bg: rgba(17,17,17,0.6);
            --muted: rgba(255,255,255,0.5);
            --glass-border: rgba(255,255,255,0.08);
            --accent-grad: linear-gradient(135deg,#aaaaaa 0%,#888888 100%);
            --primary-text: #ffffff;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: var(--bg-dark);
            color: var(--primary-text);
            overflow-x: hidden;
            position: relative;
        }

        /* --- Grid background, particles, orbs (copied/adapted from login) --- */
        .grid-background{ position: absolute; width:100%; height:100%; overflow:hidden; top:0; left:0; z-index:0; }
        .particle{ position:absolute; width:4px; height:4px; background: rgba(255,255,255,0.7); border-radius:50%; animation: particleFloat 15s infinite; box-shadow:0 0 10px rgba(255,255,255,0.4); }
        @keyframes particleFloat { 0%{transform:translateY(100vh) translateX(0) scale(0); opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-100vh) translateX(200px) scale(1.5) rotate(720deg); opacity:0} }

        .line{ position:absolute; width:2px; height:150px; background:linear-gradient(to bottom,transparent, rgba(255,255,255,0.6), transparent); animation: lineMove 12s infinite linear; }
        @keyframes lineMove{ 0%{transform:translateY(-100%) rotate(0); opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(100vh) rotate(180deg); opacity:0} }

        .diagonal-line{ position:absolute; width:300px; height:2px; background:linear-gradient(to right, transparent, rgba(200,200,200,0.25), transparent); animation: diagonalMove 20s infinite linear; }
        @keyframes diagonalMove{ 0%{transform:translate(-100%,-100%) rotate(45deg); opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translate(200vw,200vh) rotate(45deg); opacity:0} }

        .circle{ position:absolute; border:2px solid rgba(255,255,255,0.12); border-radius:50%; animation: circleExpand 8s infinite ease-out; }
        @keyframes circleExpand{ 0%{width:20px;height:20px;opacity:1}100%{width:300px;height:300px;opacity:0} }

        .star{ position:absolute; width:3px; height:3px; background: rgba(255,255,255,0.9); border-radius:50%; animation: starTwinkle 3s infinite; box-shadow:0 0 12px rgba(255,255,255,0.6); }
        @keyframes starTwinkle{ 0%,100%{opacity:0.3; transform:scale(1)}50%{opacity:1; transform:scale(1.5)} }

        .orb{ position:absolute; border-radius:50%; filter: blur(60px); opacity:0.45; animation: float 20s infinite ease-in-out; }
        .orb1{ width:500px; height:500px; background: linear-gradient(45deg,#888888,#666666); top:-250px; left:-250px; }
        .orb2{ width:600px; height:600px; background: linear-gradient(45deg,#aaaaaa,#888888); bottom:-300px; right:-300px; }
        .orb3{ width:450px; height:450px; background: linear-gradient(45deg,#777777,#555555); top:50%; left:50%; transform:translate(-50%,-50%); }
        .orb4{ width:350px; height:350px; background: linear-gradient(45deg,#cccccc,#999999); top:20%; right:10%; }

        @keyframes float{ 0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(150px,-150px) scale(1.1)}50%{transform:translate(0,-80px) scale(0.9)}75%{transform:translate(-150px,150px) scale(1.05)} }

        /* --- Navbar (glass, dark) --- */
        .navbar {
            background: transparent !important;
            border-bottom: 1px solid var(--glass-border);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 5;
        }
        .navbar .container-fluid { position:relative; z-index:5; }

        .navbar-brand {
            display:flex;
            align-items:center;
            gap:10px;
            font-weight:700;
            color:var(--primary-text);
            text-decoration:none;
        }
        .logo-circle-sm{
            width:40px; height:40px; border-radius:50%;
            background: linear-gradient(135deg,#ffffff,#e5e5e5);
            display:flex; align-items:center; justify-content:center;
            box-shadow: 0 8px 28px rgba(255,255,255,0.08);
            font-size:18px;
        }

        .nav-link { color: var(--muted) !important; font-weight:600; margin:0 0.5rem; transition: all .2s ease; }
        .nav-link:hover{ color: var(--primary-text) !important; transform:translateY(-2px); }

        .navbar-text { color: var(--muted); font-weight:600; background: rgba(255,255,255,0.03); padding:6px 12px; border-radius:20px; }

        /* Buttons override */
        .btn-outline-primary {
            border: 1.5px solid var(--glass-border);
            color: var(--primary-text);
            background: transparent;
            font-weight:600;
            border-radius:10px;
            padding:6px 12px;
            transition:all .2s ease;
        }
        .btn-outline-primary:hover { background: rgba(255,255,255,0.04); }

        .btn-outline-danger {
            border:1.5px solid rgba(239,68,68,0.18);
            color: #ffdddd;
            background: transparent;
        }

        /* --- Main container / cards --- */
        .container {
            position: relative;
            z-index: 5;
            padding-top: 36px;
            padding-bottom: 60px;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            color: var(--primary-text);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.6);
            overflow: hidden;
        }
        .card-header{ background: transparent; border-bottom:1px solid rgba(255,255,255,0.03); color:var(--muted); font-weight:700; }

        .table thead th { background: rgba(255,255,255,0.02); color: var(--muted); border-bottom:1px solid rgba(255,255,255,0.03); }
        .table tbody tr:hover { background: rgba(255,255,255,0.02); }

        /* small responsive tweaks */
        @media (max-width:768px){
            .navbar .navbar-collapse{ background: transparent !important; }
            .logo-circle-sm{ width:36px; height:36px; font-size:16px; }
        }

    </style>
</head>
<body>
    <!-- Animated background elements (copied/adapted) -->
    <div class="grid-background" aria-hidden="true">
        <!-- particles: keep fairly sparse for dashboard to avoid perf issues -->
        <div class="particle" style="left:6%; top:90%; animation-delay:0s; animation-duration:13s;"></div>
        <div class="particle" style="left:18%; top:85%; animation-delay:1.2s; animation-duration:15s;"></div>
        <div class="particle" style="left:30%; top:80%; animation-delay:2.1s; animation-duration:14s;"></div>
        <div class="particle" style="left:44%; top:75%; animation-delay:3.4s; animation-duration:16s;"></div>
        <div class="particle" style="left:60%; top:78%; animation-delay:4.7s; animation-duration:12s;"></div>
        <div class="particle" style="left:72%; top:82%; animation-delay:5.8s; animation-duration:17s;"></div>
        <div class="particle" style="left:86%; top:88%; animation-delay:6.3s; animation-duration:15s;"></div>

        <!-- vertical lines -->
        <div class="line" style="left:10%; animation-delay:0s;"></div>
        <div class="line" style="left:30%; animation-delay:2s;"></div>
        <div class="line" style="left:50%; animation-delay:4s;"></div>
        <div class="line" style="left:70%; animation-delay:6s;"></div>
        <div class="line" style="left:90%; animation-delay:8s;"></div>

        <!-- diagonal lines -->
        <div class="diagonal-line" style="top:12%; animation-delay:0s;"></div>
        <div class="diagonal-line" style="top:36%; animation-delay:6s;"></div>
        <div class="diagonal-line" style="top:60%; animation-delay:12s;"></div>

        <!-- circles -->
        <div class="circle" style="left:20%; top:30%; animation-delay:0s;"></div>
        <div class="circle" style="left:70%; top:20%; animation-delay:3s;"></div>

        <!-- stars -->
        <div class="star" style="left:15%; top:15%; animation-delay:0s;"></div>
        <div class="star" style="left:85%; top:25%; animation-delay:1s;"></div>

    </div>

    <!-- soft glowing orbs -->
    <div class="orb orb1" aria-hidden="true"></div>
    <div class="orb orb2" aria-hidden="true"></div>
    <div class="orb orb3" aria-hidden="true"></div>
    <div class="orb orb4" aria-hidden="true"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
                <div class="logo-circle-sm">🔨</div>
                <span style="margin-left:6px;">Toko Bangunan</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="color:var(--primary-text)"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.dashboard') }}"><i class="fas fa-home me-1"></i>Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.products') }}"><i class="fas fa-box me-1"></i>Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.cart') }}"><i class="fas fa-shopping-cart me-1"></i>Keranjang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.orders') }}"><i class="fas fa-receipt me-1"></i>Pesanan</a></li>
                </ul>

                <div class="d-flex ms-auto align-items-center">
                    <span class="navbar-text me-3"><i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name ?? 'Customer' }}</span>
                    <a href="{{ route('customer.profile') }}" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-user-cog me-1"></i>Profile</a>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- main container -->
    <div class="container mt-4">
        <!-- content area: keep existing yield so pages can inject content -->
        @yield('content')
    </div>

    <!-- keep scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
