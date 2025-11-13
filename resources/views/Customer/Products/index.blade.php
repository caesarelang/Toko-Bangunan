@extends('Customer.Layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="page-header mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="display-5 fw-bold mb-2">
                    <span class="gradient-text">Katalog Produk</span>
                </h2>
                <p class="text-secondary fs-5">Temukan produk terbaik untuk kebutuhan Anda</p>
            </div>
            <a href="{{ route('customer.cart') }}" class="btn btn-gradient">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </a>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('customer.products') }}">
            <div class="d-flex gap-3 align-items-center flex-wrap">
                <div class="filter-icon">
                    <i class="fas fa-filter"></i>
                </div>
                
                <select name="category" class="form-select-modern">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" class="form-input-modern" 
                       placeholder="Cari produk..." value="{{ request('search') }}">

                <button type="submit" class="btn btn-filter">
                    <i class="fas fa-search me-2"></i>Cari Produk
                </button>
                
                <a href="{{ route('customer.products') }}" class="btn btn-reset">
                    <i class="fas fa-undo me-2"></i>Reset Filter
                </a>
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    @if(session('success') || session('error'))
        <div class="alert-modern alert-{{ session('success') ? 'success' : 'danger' }} mb-4">
            <div class="alert-icon">
                <i class="fas fa-{{ session('success') ? 'check-circle' : 'exclamation-circle' }}"></i>
            </div>
            <div class="alert-content">
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    @endif

    <!-- Daftar Produk -->
    @if($products->isEmpty())
        <div class="empty-state-large">
            <div class="empty-icon-large mb-4">
                <i class="fas fa-box-open"></i>
            </div>
            <h4 class="text-secondary mb-3">Produk Tidak Ditemukan</h4>
            <p class="text-muted mb-4">Coba ubah pencarian atau filter kategori lainnya</p>
            <a href="{{ route('customer.products') }}" class="btn btn-gradient">
                <i class="fas fa-undo me-2"></i>Reset Pencarian
            </a>
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card h-100">
                        <!-- Product Image -->
                        <div class="product-image-wrapper">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image">
                            <div class="product-overlay">
                                <span class="category-badge">
                                    <i class="fas fa-tag me-2"></i>{{ $product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Body -->
                        <div class="product-body">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            
                            <p class="product-description">
                                {{ Str::limit($product->description, 100) }}
                            </p>

                            <!-- Stock Info -->
                            <div class="stock-info mb-3">
                                <i class="fas fa-boxes me-2"></i>
                                <span class="stock-label">Stok Tersedia:</span>
                                @if($product->stock > 0)
                                    <span class="stock-value stock-available">{{ $product->stock }} Unit</span>
                                @else
                                    <span class="stock-value stock-empty">Habis</span>
                                @endif
                            </div>

                            <!-- Price & Action -->
                            <div class="product-footer">
                                <div class="price-section">
                                    <div class="price-label">Harga</div>
                                    <div class="price-value">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                                </div>
                                
                                <form action="{{ route('customer.cart.add') }}" method="POST" class="w-100">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-add-cart w-100" 
                                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus me-2"></i>
                                        {{ $product->stock > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    @endif
</div>

<style>
    :root {
        --primary-color: #9ca3af;
        --secondary-color: #6b7280;
        --card-bg: rgba(17, 17, 17, 0.6);
        --border-color: rgba(255, 255, 255, 0.08);
        --text-secondary: #9ca3af;
    }

    body {
        background: #0a0a0a;
        color: #fff;
    }

    .container {
        margin-top: 0 !important;
    }

    /* Header */
    .page-header {
        position: relative;
        padding: 2rem 0;
    }

    .gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-gradient {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
        color: #fff;
    }

    /* Filter Card */
    .filter-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .filter-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .form-select-modern {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        min-width: 200px;
        transition: all 0.3s ease;
    }

    .form-select-modern:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(156, 163, 175, 0.1);
        background: rgba(255, 255, 255, 0.08);
    }

    .form-select-modern option {
        background: #1a1a1a;
        color: #fff;
    }

    .form-input-modern {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        flex: 1;
        min-width: 250px;
        transition: all 0.3s ease;
    }

    .form-input-modern:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(156, 163, 175, 0.1);
        background: rgba(255, 255, 255, 0.08);
    }

    .form-input-modern::placeholder {
        color: var(--text-secondary);
    }

    .btn-filter {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-filter:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .btn-reset {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-reset:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-color);
        color: #fff;
    }

    /* Alert Modern */
    .alert-modern {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        border: 1px solid;
    }

    .alert-modern.alert-success {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.3);
        color: #10B981;
    }

    .alert-modern.alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.3);
        color: #EF4444;
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .alert-success .alert-icon {
        background: rgba(16, 185, 129, 0.15);
    }

    .alert-danger .alert-icon {
        background: rgba(239, 68, 68, 0.15);
    }

    /* Empty State */
    .empty-state-large {
        text-align: center;
        padding: 5rem 2rem;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
    }

    .empty-icon-large {
        width: 120px;
        height: 120px;
        margin: 0 auto;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        opacity: 0.8;
    }

    /* Product Card */
    .product-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(10px);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 255, 255, 0.12);
    }

    /* Product Image */
    .product-image-wrapper {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.02);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: linear-gradient(to bottom, rgba(0,0,0,0.5), transparent);
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(156, 163, 175, 0.9);
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    /* Product Body */
    .product-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #f3f4f6;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .product-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        flex: 1;
    }

    /* Stock Info */
    .stock-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .stock-label {
        color: var(--text-secondary);
    }

    .stock-value {
        font-weight: 700;
        margin-left: auto;
    }

    .stock-available {
        color: #10B981;
    }

    .stock-empty {
        color: #EF4444;
    }

    /* Product Footer */
    .product-footer {
        margin-top: auto;
    }

    .price-section {
        background: linear-gradient(135deg, rgba(156, 163, 175, 0.1), rgba(107, 114, 128, 0.1));
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        text-align: center;
    }

    .price-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }

    .price-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Add to Cart Button */
    .btn-add-cart {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
        color: #fff;
    }

    .btn-add-cart:disabled {
        background: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Pagination */
    .pagination {
        gap: 0.5rem;
    }

    .pagination .page-link {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: #fff;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-color: var(--primary-color);
    }

    .pagination .page-item.disabled .page-link {
        background: rgba(255, 255, 255, 0.02);
        border-color: var(--border-color);
        color: var(--text-secondary);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .filter-card form {
            flex-direction: column;
            align-items: stretch !important;
        }

        .filter-icon {
            display: none;
        }

        .form-select-modern,
        .form-input-modern,
        .btn-filter,
        .btn-reset {
            width: 100%;
            min-width: unset;
        }
    }

    @media (max-width: 768px) {
        .page-header .d-flex {
            flex-direction: column;
            gap: 1rem !important;
            text-align: center;
        }

        .page-header .btn-gradient {
            width: 100%;
        }

        .product-image-wrapper {
            height: 220px;
        }

        .price-value {
            font-size: 1.25rem;
        }
    }
</style>
@endsection