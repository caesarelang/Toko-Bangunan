@extends('Customer.Layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header Sambutan -->
    <div class="page-header mb-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="display-5 fw-bold mb-2">
                    Selamat Datang, <span class="gradient-text">{{ auth()->user()->name }}</span>
                </h2>
                <p class="text-secondary fs-5">Berikut ringkasan pesanan Anda hari ini</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.products') }}" class="btn btn-gradient">
                    <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                </a>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary-custom">
                    <i class="fas fa-list-ul me-2"></i>Semua Pesanan
                </a>
            </div>
        </div>
    </div>

    <!-- Kartu Ringkasan Pesanan -->
    <div class="row g-4 mb-5">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="summary-card pending">
                <div class="summary-header">
                    <div class="icon-wrapper">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-glow pending-glow"></div>
                </div>
                <div class="summary-body">
                    <h3 class="summary-count">{{ $summary['pending'] }}</h3>
                    <p class="summary-label">Menunggu Konfirmasi</p>
                </div>
                <div class="summary-footer">
                    <span class="summary-badge pending-badge">
                        <i class="fas fa-circle me-1"></i>Pending
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="summary-card processing">
                <div class="summary-header">
                    <div class="icon-wrapper">
                        <i class="fas fa-spinner fa-pulse"></i>
                    </div>
                    <div class="card-glow processing-glow"></div>
                </div>
                <div class="summary-body">
                    <h3 class="summary-count">{{ $summary['processing'] }}</h3>
                    <p class="summary-label">Sedang Diproses</p>
                </div>
                <div class="summary-footer">
                    <span class="summary-badge processing-badge">
                        <i class="fas fa-circle me-1"></i>Processing
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="summary-card delivering">
                <div class="summary-header">
                    <div class="icon-wrapper">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="card-glow delivering-glow"></div>
                </div>
                <div class="summary-body">
                    <h3 class="summary-count">{{ $summary['delivering'] }}</h3>
                    <p class="summary-label">Dalam Pengiriman</p>
                </div>
                <div class="summary-footer">
                    <span class="summary-badge delivering-badge">
                        <i class="fas fa-circle me-1"></i>Delivering
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="summary-card completed">
                <div class="summary-header">
                    <div class="icon-wrapper">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-glow completed-glow"></div>
                </div>
                <div class="summary-body">
                    <h3 class="summary-count">{{ $summary['completed'] }}</h3>
                    <p class="summary-label">Pesanan Selesai</p>
                </div>
                <div class="summary-footer">
                    <span class="summary-badge completed-badge">
                        <i class="fas fa-circle me-1"></i>Completed
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="summary-card cancelled">
                <div class="summary-header">
                    <div class="icon-wrapper">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="card-glow cancelled-glow"></div>
                </div>
                <div class="summary-body">
                    <h3 class="summary-count">{{ $summary['cancelled'] }}</h3>
                    <p class="summary-label">Pesanan Dibatalkan</p>
                </div>
                <div class="summary-footer">
                    <span class="summary-badge cancelled-badge">
                        <i class="fas fa-circle me-1"></i>Cancelled
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="summary-card requests">
                <div class="summary-header">
                    <div class="icon-wrapper">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="card-glow requests-glow"></div>
                </div>
                <div class="summary-body">
                    <h3 class="summary-count">{{ $summary['cancellation_requests'] }}</h3>
                    <p class="summary-label">Pengajuan Batal</p>
                </div>
                <div class="summary-footer">
                    <span class="summary-badge requests-badge">
                        <i class="fas fa-circle me-1"></i>Requested
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Pesanan Terbaru -->
    <div class="orders-card">
        <div class="orders-card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">Pesanan Terbaru</h5>
                        <p class="text-secondary mb-0" style="font-size: 0.875rem;">Transaksi terbaru Anda</p>
                    </div>
                </div>
                <a href="{{ route('customer.orders') }}" class="btn btn-view-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <div class="orders-card-body">
            @if($recentOrders->isEmpty())
                <div class="empty-state-orders">
                    <div class="empty-icon-orders mb-4">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h5 class="text-secondary mb-2">Belum Ada Pesanan</h5>
                    <p class="text-muted mb-4">Mulai belanja dan lihat pesanan Anda di sini</p>
                    <a href="{{ route('customer.products') }}" class="btn btn-gradient">
                        <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja
                    </a>
                </div>
            @else
                <div class="orders-list">
                    @foreach($recentOrders as $order)
                        <div class="order-item">
                            <div class="row align-items-center g-3">
                                <!-- Order ID -->
                                <div class="col-lg-2 col-md-3 col-6">
                                    <div class="order-id-section">
                                        <div class="order-id-label">ID Pesanan</div>
                                        <div class="order-id-value">
                                            <i class="fas fa-receipt me-2"></i>#{{ $order->id }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="col-lg-2 col-md-3 col-6">
                                    <div class="order-date-section">
                                        <div class="order-date-label">Tanggal</div>
                                        <div class="order-date-value">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            {{ $order->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Price -->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="order-price-section">
                                        <div class="order-price-label">Total Pembayaran</div>
                                        <div class="order-price-value">
                                            Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-3 col-md-6 col-6">
                                    <div class="order-status-section">
                                        <div class="order-status-label">Status</div>
                                        @php
                                            $statusData = [
                                                'pending' => ['color' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu'],
                                                'processing' => ['color' => 'primary', 'icon' => 'spinner', 'text' => 'Diproses'],
                                                'delivering' => ['color' => 'info', 'icon' => 'truck', 'text' => 'Dikirim'],
                                                'completed' => ['color' => 'success', 'icon' => 'check-circle', 'text' => 'Selesai'],
                                                'cancelled' => ['color' => 'danger', 'icon' => 'times-circle', 'text' => 'Dibatalkan'],
                                                'cancellation_requested' => ['color' => 'danger', 'icon' => 'exclamation-triangle', 'text' => 'Menunggu Pembatalan'],
                                            ];
                                            $status = $statusData[$order->status] ?? ['color' => 'secondary', 'icon' => 'question', 'text' => ucfirst($order->status)];
                                        @endphp
                                        <span class="order-status-badge status-{{ $status['color'] }}">
                                            <i class="fas fa-{{ $status['icon'] }} me-2"></i>
                                            {{ $status['text'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Action -->
                                <div class="col-lg-2 col-md-6 col-12">
                                    <a href="{{ route('customer.orders') }}" class="btn btn-view-detail w-100">
                                        <i class="fas fa-eye me-2"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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

    /* Status Colors - Pending */
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

    /* Status Colors - Processing */
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

    /* Status Colors - Delivering */
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

    /* Status Colors - Completed */
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

    /* Status Colors - Cancelled */
    .summary-card.cancelled .icon-wrapper {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
    }
    .cancelled-badge {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .cancelled-glow {
        background: radial-gradient(circle, #EF4444 0%, transparent 70%);
    }

    /* Status Colors - Requests */
    .summary-card.requests .icon-wrapper {
        background: rgba(249, 115, 22, 0.15);
        color: #F97316;
    }
    .requests-badge {
        background: rgba(249, 115, 22, 0.15);
        color: #F97316;
        border: 1px solid rgba(249, 115, 22, 0.3);
    }
    .requests-glow {
        background: radial-gradient(circle, #F97316 0%, transparent 70%);
    }

    /* Orders Card */
    .orders-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
    }

    .orders-card-header {
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

    .btn-view-all {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-view-all:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        color: #fff;
    }

    .orders-card-body {
        padding: 2rem;
    }

    /* Empty State */
    .empty-state-orders {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-icon-orders {
        width: 100px;
        height: 100px;
        margin: 0 auto;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        opacity: 0.8;
    }

    /* Orders List */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .order-item {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.12);
        transform: translateX(4px);
    }

    /* Order Sections */
    .order-id-section,
    .order-date-section,
    .order-price-section,
    .order-status-section {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .order-id-label,
    .order-date-label,
    .order-price-label,
    .order-status-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-id-value {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1rem;
    }

    .order-date-value {
        font-weight: 600;
        color: #e5e7eb;
        font-size: 0.9rem;
    }

    .order-price-value {
        font-weight: 700;
        color: #f3f4f6;
        font-size: 1.125rem;
    }

    /* Order Status Badge */
    .order-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid;
        width: fit-content;
    }

    .status-warning {
        background: rgba(234, 179, 8, 0.15);
        color: #EAB308;
        border-color: rgba(234, 179, 8, 0.3);
    }
    .status-primary {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
        border-color: rgba(59, 130, 246, 0.3);
    }
    .status-info {
        background: rgba(139, 92, 246, 0.15);
        color: #8B5CF6;
        border-color: rgba(139, 92, 246, 0.3);
    }
    .status-success {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border-color: rgba(16, 185, 129, 0.3);
    }
    .status-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border-color: rgba(239, 68, 68, 0.3);
    }

    /* View Detail Button */
    .btn-view-detail {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-view-detail:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
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

        .orders-card-header .d-flex {
            flex-direction: column;
            text-align: center;
        }

        .btn-view-all {
            width: 100%;
            justify-content: center;
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

        .orders-card-header,
        .orders-card-body {
            padding: 1.5rem;
        }

        .order-item {
            padding: 1rem;
        }

        .order-id-section,
        .order-date-section,
        .order-price-section,
        .order-status-section {
            text-align: center;
        }

        .order-status-badge {
            margin: 0 auto;
        }
    }
</style>
@endsection