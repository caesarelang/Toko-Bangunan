@extends('Customer.Layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="page-header mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="display-5 fw-bold mb-2">
                    <span class="gradient-text">Pesanan Saya</span>
                </h2>
                <p class="text-secondary fs-5">Kelola dan pantau semua pesananmu</p>
            </div>
            <a href="{{ route('customer.products') }}" class="btn btn-gradient">
                <i class="fas fa-shopping-cart me-2"></i>Belanja Lagi
            </a>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="filter-card mb-4">
        <form action="{{ route('customer.orders') }}" method="GET" class="d-flex gap-3 align-items-center flex-wrap">
            <div class="filter-icon">
                <i class="fas fa-filter"></i>
            </div>
            <select name="status" class="form-select-modern">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="processing" {{ request('status')=='processing' ? 'selected' : '' }}>Diproses</option>
                <option value="delivering" {{ request('status')=='delivering' ? 'selected' : '' }}>Dikirim</option>
                <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                <option value="cancellation_requested" {{ request('status')=='cancellation_requested' ? 'selected' : '' }}>Menunggu Pembatalan</option>
            </select>
            <button type="submit" class="btn btn-filter">
                <i class="fas fa-check me-2"></i>Terapkan Filter
            </button>
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

    <!-- Daftar Pesanan -->
    @if($orders->isEmpty())
        <div class="empty-state-large">
            <div class="empty-icon-large mb-4">
                <i class="fas fa-box-open"></i>
            </div>
            <h4 class="text-secondary mb-3">Belum Ada Pesanan</h4>
            <p class="text-muted mb-4">Yuk mulai belanja dan lihat pesananmu di sini!</p>
            <a href="{{ route('customer.products') }}" class="btn btn-gradient">
                <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja
            </a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card mb-4">
                <!-- Order Header -->
                <div class="order-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="order-id-badge">
                                <i class="fas fa-receipt me-2"></i>
                                <span>#{{ $order->id }}</span>
                            </div>
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
                            <span class="status-badge-modern status-{{ $status['color'] }}">
                                <i class="fas fa-{{ $status['icon'] }} me-2"></i>
                                {{ $status['text'] }}
                            </span>
                        </div>
                        <div class="order-date">
                            <i class="far fa-calendar-alt me-2"></i>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Order Body -->
                <div class="order-body">
                    <!-- Products Table -->
                    <div class="products-table-wrapper">
                        <table class="products-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center" width="120">Jumlah</th>
                                    <th class="text-end" width="150">Harga</th>
                                    <th class="text-end" width="150">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <i class="fas fa-box me-2 text-secondary"></i>
                                                <span>{{ $item->product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="quantity-badge">{{ $item->quantity }}x</span>
                                        </td>
                                        <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Price -->
                    <div class="total-section">
                        <div class="total-label">Total Pembayaran:</div>
                        <div class="total-price">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
                    </div>

                    <!-- Map Section -->
                    @if($order->latitude && $order->longitude)
                        <div class="map-section">
                            <div class="map-header">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Lokasi Pengiriman
                            </div>
                            <div id="map-{{ $order->id }}" class="order-map"></div>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if($order->status === 'processing')
                        <div class="order-actions">
                            <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengajukan pembatalan pesanan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-cancel">
                                    <i class="fas fa-times-circle me-2"></i>
                                    Ajukan Pembatalan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
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
    }

    .form-select-modern {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        min-width: 250px;
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

    .btn-filter {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
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

    /* Order Card */
    .order-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 255, 255, 0.12);
    }

    /* Order Header */
    .order-header {
        background: rgba(255, 255, 255, 0.02);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .order-id-badge {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
    }

    .status-badge-modern {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid;
    }

    .status-warning { background: rgba(234,179,8,0.15); color: #EAB308; border-color: rgba(234,179,8,0.3); }
    .status-primary { background: rgba(59,130,246,0.15); color: #3B82F6; border-color: rgba(59,130,246,0.3); }
    .status-info { background: rgba(139,92,246,0.15); color: #8B5CF6; border-color: rgba(139,92,246,0.3); }
    .status-success { background: rgba(16,185,129,0.15); color: #10B981; border-color: rgba(16,185,129,0.3); }
    .status-danger { background: rgba(239,68,68,0.15); color: #EF4444; border-color: rgba(239,68,68,0.3); }

    .order-date {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    /* Order Body */
    .order-body {
        padding: 1.5rem;
    }

    /* Products Table */
    .products-table-wrapper {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .products-table {
        width: 100%;
        margin: 0;
    }

    .products-table thead th {
        background: rgba(255, 255, 255, 0.05);
        color: #f3f4f6;
        font-weight: 600;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .products-table tbody td {
        color: #e5e7eb;
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }

    .products-table tbody tr:last-child td {
        border-bottom: none;
    }

    .products-table tbody tr:hover td {
        background: rgba(255, 255, 255, 0.03);
        color: #ffffff;
    }

    .product-info {
        display: flex;
        align-items: center;
    }

    .quantity-badge {
        background: rgba(156, 163, 175, 0.15);
        padding: 0.25rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Total Section */
    .total-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, rgba(156, 163, 175, 0.1), rgba(107, 114, 128, 0.1));
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .total-label {
        font-size: 1.125rem;
        color: var(--text-secondary);
    }

    .total-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Map Section */
    .map-section {
        margin-bottom: 1.5rem;
    }

    .map-header {
        display: flex;
        align-items: center;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #f3f4f6;
    }

    .order-map {
        height: 250px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    /* Order Actions */
    .order-actions {
        display: flex;
        justify-content: flex-end;
    }

    .btn-cancel {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #EF4444;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #EF4444;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .order-header .d-flex {
            flex-direction: column;
            gap: 1rem !important;
        }

        .form-select-modern {
            min-width: 100%;
        }

        .products-table {
            font-size: 0.875rem;
        }

        .total-section {
            flex-direction: column;
            gap: 0.5rem;
            text-align: center;
        }
    }
</style>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($orders as $order)
        @if($order->latitude && $order->longitude)
            var map{{ $order->id }} = L.map('map-{{ $order->id }}').setView([{{ $order->latitude }}, {{ $order->longitude }}], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map{{ $order->id }});
            L.marker([{{ $order->latitude }}, {{ $order->longitude }}]).addTo(map{{ $order->id }});
        @endif
    @endforeach
});
</script>
@endsection