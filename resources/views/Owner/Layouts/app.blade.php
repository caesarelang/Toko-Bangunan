<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Toko Bangunan</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav  me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('owner.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('owner.products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('owner.revenue') }}">Revenue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('owner.customers') }}">Customers</a>
                    </li>
                </ul>
            </div>
            
        </div>
            <span class="navbar-text me-3">
                {{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
    </nav>  
    
    <div class="container">
        @yield('content')
    </div>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html> 