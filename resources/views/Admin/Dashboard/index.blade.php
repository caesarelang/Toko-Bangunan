@extends('Admin.Layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header Sambutan -->
    <div class="page-header mb-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="display-5 fw-bold mb-2">
                    Beranda <span class="gradient-text">Admin</span>
                </h2>
                <p class="text-secondary fs-5">Kelola toko bangunan Anda dengan mudah</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products') }}" class="btn btn-gradient">
                    <i class="fas fa-box-open me-2"></i>Kelola Produk
                </a>
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary-custom">
                    <i class="fas fa-list-ul me-2"></i>Semua Pesanan
                </a>
            </div>
        </div>
    </div>

    <!-- Kartu Status Pesanan -->
    <div class="row g-4 mb-5">
        @foreach($ordersByStatus as $status => $count)
            @php
                $statusConfig = [
                    'pending' => [
                        'icon' => 'clock',
                        'label' => 'Menunggu',
                        'class' => 'pending',
                        'color' => 'warning'
                    ],
                    'processing' => [
                        'icon' => 'spinner',
                        'label' => 'Diproses',
                        'class' => 'processing',
                        'color' => 'primary'
                    ],
                    'delivering' => [
                        'icon' => 'truck',
                        'label' => 'Dikirim',
                        'class' => 'delivering',
                        'color' => 'info'
                    ],
                    'completed' => [
                        'icon' => 'check-circle',
                        'label' => 'Selesai',
                        'class' => 'completed',
                        'color' => 'success'
                    ],
                    'cancelled' => [
                        'icon' => 'times-circle',
                        'label' => 'Dibatalkan',
                        'class' => 'cancelled',
                        'color' => 'danger'
                    ],
                    'cancellation_requested' => [
                        'icon' => 'exclamation-triangle',
                        'label' => 'Pengajuan Batal',
                        'class' => 'requests',
                        'color' => 'danger'
                    ]
                ];
                $config = $statusConfig[$status] ?? [
                    'icon' => 'question',
                    'label' => ucfirst($status),
                    'class' => 'secondary',
                    'color' => 'secondary'
                ];
            @endphp
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="summary-card {{ $config['class'] }}">
                    <div class="summary-header">
                        <div class="icon-wrapper">
                            <i class="fas fa-{{ $config['icon'] }}"></i>
                        </div>
                        <div class="card-glow {{ $config['class'] }}-glow"></div>
                    </div>
                    <div class="summary-body">
                        <h3 class="summary-count">{{ $count }}</h3>
                        <p class="summary-label">{{ $config['label'] }}</p>
                    </div>
                    <div class="summary-footer">
                        <span class="summary-badge {{ $config['class'] }}-badge">
                            <i class="fas fa-circle me-1"></i>{{ ucfirst($status) }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-5">
        <!-- Total Pendapatan -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card revenue-card">
                <div class="stats-icon-wrapper">
                    <div class="stats-icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                </div>
                <div class="stats-content">
                    <div class="stats-label">Total Pendapatan</div>
                    <div class="stats-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="stats-footer">
                        <span class="stats-badge success-badge">
                            <i class="fas fa-arrow-up me-1"></i>Revenue
                        </span>
                    </div>
                </div>
                <div class="stats-glow revenue-glow"></div>
            </div>
        </div>

        <!-- Total Pelanggan -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card customers-card">
                <div class="stats-icon-wrapper">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stats-content">
                    <div class="stats-label">Total Pelanggan</div>
                    <div class="stats-value">{{ number_format($totalCustomers, 0, ',', '.') }}</div>
                    <div class="stats-footer">
                        <span class="stats-badge info-badge">
                            <i class="fas fa-user-friends me-1"></i>Customers
                        </span>
                    </div>
                </div>
                <div class="stats-glow customers-glow"></div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card products-card">
                <div class="stats-icon-wrapper">
                    <div class="stats-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
                <div class="stats-content">
                    <div class="stats-label">Total Produk</div>
                    <div class="stats-value">{{ number_format($totalProducts, 0, ',', '.') }}</div>
                    <div class="stats-footer">
                        <span class="stats-badge primary-badge">
                            <i class="fas fa-box-open me-1"></i>Products
                        </span>
                    </div>
                </div>
                <div class="stats-glow products-glow"></div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-card">
        <div class="quick-actions-header">
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <h5 class="mb-1 fw-bold">Aksi Cepat</h5>
                    <p class="text-secondary mb-0" style="font-size: 0.875rem;">Kelola toko Anda dengan cepat</p>
                </div>
            </div>
        </div>
        <div class="quick-actions-body">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.orders') }}" class="action-card">
                        <div class="action-icon orders-action">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="action-content">
                            <h6 class="action-title">Kelola Pesanan</h6>
                            <p class="action-desc">Proses pesanan pelanggan</p>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.products') }}" class="action-card">
                        <div class="action-icon products-action">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="action-content">
                            <h6 class="action-title">Kelola Produk</h6>
                            <p class="action-desc">Tambah & edit produk</p>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.categories') }}" class="action-card">
                        <div class="action-icon categories-action">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="action-content">
                            <h6 class="action-title">Kelola Kategori</h6>
                            <p class="action-desc">Atur kategori produk</p>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
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
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
        color: #fff;
    }

    .btn-outline-primary-custom {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-outline-primary-custom:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-color);
        color: #fff;
    }

    /* Summary Cards */
    .summary-card {
        position: relative;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .summary-card:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 255, 255, 0.12);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .summary-header {
        position: relative;
        margin-bottom: 1rem;
    }

    .icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .summary-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    .summary-body {
        margin-bottom: 1rem;
    }

    .summary-count {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #f3f4f6;
    }

    .summary-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .summary-footer {
        margin-top: auto;
    }

    .summary-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Card Glow Effects */
    .card-glow {
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .summary-card:hover .card-glow {
        opacity: 0.15;
    }

    /* Status Colors */
    .summary-card.pending .icon-wrapper {
        background: rgba(234, 179, 8, 0.15);
        color: #EAB308;
    }
    .pending-badge {
        background: rgba(234, 179, 8, 0.15);
        color: #EAB308;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }
    .pending-glow {
        background: radial-gradient(circle, #EAB308 0%, transparent 70%);
    }

    .summary-card.processing .icon-wrapper {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
    }
    .processing-badge {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .processing-glow {
        background: radial-gradient(circle, #3B82F6 0%, transparent 70%);
    }

    .summary-card.delivering .icon-wrapper {
        background: rgba(139, 92, 246, 0.15);
        color: #8B5CF6;
    }
    .delivering-badge {
        background: rgba(139, 92, 246, 0.15);
        color: #8B5CF6;
        border: 1px solid rgba(139, 92, 246, 0.3);
    }
    .delivering-glow {
        background: radial-gradient(circle, #8B5CF6 0%, transparent 70%);
    }

    .summary-card.completed .icon-wrapper {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
    }
    .completed-badge {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .completed-glow {
        background: radial-gradient(circle, #10B981 0%, transparent 70%);
    }

    .summary-card.cancelled .icon-wrapper,
    .summary-card.requests .icon-wrapper {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
    }
    .cancelled-badge,
    .requests-badge {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .cancelled-glow,
    .requests-glow {
        background: radial-gradient(circle, #EF4444 0%, transparent 70%);
    }

    /* Stats Cards */
    .stats-card {
        position: relative;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 2rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 255, 255, 0.12);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .stats-icon-wrapper {
        flex-shrink: 0;
    }

    .stats-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .stats-content {
        flex: 1;
    }

    .stats-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stats-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #f3f4f6;
        margin-bottom: 0.75rem;
    }

    .stats-footer .stats-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid;
    }

    .stats-glow {
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .stats-card:hover .stats-glow {
        opacity: 0.15;
    }

    /* Revenue Card */
    .revenue-card .stats-icon {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
    }
    .success-badge {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border-color: rgba(16, 185, 129, 0.3);
    }
    .revenue-glow {
        background: radial-gradient(circle, #10B981 0%, transparent 70%);
    }

    /* Customers Card */
    .customers-card .stats-icon {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
    }
    .info-badge {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
        border-color: rgba(59, 130, 246, 0.3);
    }
    .customers-glow {
        background: radial-gradient(circle, #3B82F6 0%, transparent 70%);
    }

    /* Products Card */
    .products-card .stats-icon {
        background: rgba(139, 92, 246, 0.15);
        color: #8B5CF6;
    }
    .primary-badge {
        background: rgba(139, 92, 246, 0.15);
        color: #8B5CF6;
        border-color: rgba(139, 92, 246, 0.3);
    }
    .products-glow {
        background: radial-gradient(circle, #8B5CF6 0%, transparent 70%);
    }

    /* Quick Actions Card */
    .quick-actions-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
    }

    .quick-actions-header {
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid var(--border-color);
        padding: 2rem;
    }

    .header-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .quick-actions-body {
        padding: 2rem;
    }

    /* Action Cards */
    .action-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .action-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.12);
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        color: #fff;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .orders-action {
        background: rgba(234, 179, 8, 0.15);
        color: #EAB308;
    }

    .products-action {
        background: rgba(139, 92, 246, 0.15);
        color: #8B5CF6;
    }

    .categories-action {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
    }

    .customers-action {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
    }

    .action-content {
        flex: 1;
    }

    .action-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #f3f4f6;
    }

    .action-desc {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .action-arrow {
        font-size: 1rem;
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }

    .action-card:hover .action-arrow {
        transform: translateX(5px);
        color: #fff;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .page-header .d-flex {
            flex-direction: column;
            text-align: center;
        }

        .page-header .d-flex > div:last-child {
            width: 100%;
        }

        .page-header .btn-gradient,
        .page-header .btn-outline-primary-custom {
            width: 100%;
        }

        .stats-card {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .summary-card {
            padding: 1.25rem;
        }

        .summary-count {
            font-size: 1.75rem;
        }

        .icon-wrapper {
            width: 45px;
            height: 45px;
            font-size: 1.25rem;
        }

        .stats-card {
            padding: 1.5rem;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            font-size: 1.75rem;
        }

        .stats-value {
            font-size: 1.5rem;
        }

        .quick-actions-header,
        .quick-actions-body {
            padding: 1.5rem;
        }

        .action-card {
            padding: 1.25rem;
        }
    }
</style>
@endsection