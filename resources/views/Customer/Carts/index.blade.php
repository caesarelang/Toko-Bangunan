@extends('Customer.Layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="page-header mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="display-5 fw-bold mb-2">
                    <span class="gradient-text">Keranjang Belanja</span>
                </h2>
                <p class="text-secondary fs-5">Kelola produk yang akan Anda beli</p>
            </div>
            <a href="{{ route('customer.products') }}" class="btn btn-gradient">
                <i class="fas fa-shopping-bag me-2"></i>Lanjut Belanja
            </a>
        </div>
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

    <!-- Cart Content -->
    @if(!$cart || $cart->items->isEmpty())
        <div class="empty-state-large">
            <div class="empty-icon-large mb-4">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h4 class="text-secondary mb-3">Keranjang Belanja Kosong</h4>
            <p class="text-muted mb-4">Belum ada produk di keranjang Anda. Yuk mulai belanja sekarang!</p>
            <a href="{{ route('customer.products') }}" class="btn btn-gradient">
                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
            </a>
        </div>
    @else
        <!-- Cart Items -->
        <div class="cart-items-wrapper mb-4">
            @php $grandTotal = 0; @endphp
            @foreach($cart->items as $item)
                @php
                    $subtotal = $item->price * $item->quantity;
                    $grandTotal += $subtotal;
                @endphp
                <div class="cart-item-card mb-3">
                    <div class="row align-items-center g-3">
                        <!-- Product Image & Info -->
                        <div class="col-lg-5">
                            <div class="d-flex align-items-center gap-3">
                                <div class="product-image-cart">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                                </div>
                                <div class="product-info-cart">
                                    <h6 class="product-name-cart mb-1">{{ $item->product->name }}</h6>
                                    <span class="product-category-cart">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $item->product->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="col-lg-2 col-6">
                            <div class="price-section-cart">
                                <div class="price-label-cart">Harga Satuan</div>
                                <div class="price-value-cart">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="col-lg-2 col-6">
                            <form action="{{ route('customer.cart.update', $item->id) }}" method="POST" class="quantity-form">
                                @csrf
                                @method('PUT')
                                <div class="quantity-control">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                           min="1" max="{{ $item->product->stock }}" class="quantity-input">
                                    <button type="submit" class="btn-update-qty" title="Update Jumlah">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Subtotal -->
                        <div class="col-lg-2 col-6">
                            <div class="subtotal-section-cart">
                                <div class="subtotal-label-cart">Subtotal</div>
                                <div class="subtotal-value-cart">Rp{{ number_format($subtotal, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <!-- Delete -->
                        <div class="col-lg-1 col-6">
                            <form action="{{ route('customer.cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-cart" 
                                        onclick="return confirm('Hapus produk ini dari keranjang?')"
                                        title="Hapus dari Keranjang">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total & Checkout Section -->
        <div class="checkout-section">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <div class="total-info">
                        <div class="total-label">Total Pembayaran:</div>
                        <div class="total-value">Rp{{ number_format($grandTotal, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex gap-3 justify-content-lg-end">
                        <a href="{{ route('customer.products') }}" class="btn btn-outline-continue">
                            <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
                        </a>
                        <button type="button" class="btn btn-checkout" data-bs-toggle="modal" data-bs-target="#locationModal">
                            <i class="fas fa-check-circle me-2"></i>Lanjut ke Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal Lokasi Pengiriman -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-modern">
                <div>
                    <h5 class="modal-title-modern mb-1" id="locationModalLabel">
                        <i class="fas fa-map-marker-alt me-2"></i>Pilih Lokasi Pengiriman
                    </h5>
                    <p class="modal-subtitle-modern">Tandai lokasi pengiriman Anda pada peta</p>
                </div>
                <button type="button" class="btn-close-modern" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="checkoutForm" action="{{ route('customer.checkout') }}" method="POST">
                @csrf
                <div class="modal-body-modern">
                    <div class="location-controls mb-3">
                        <button type="button" id="useLocationBtn" class="btn btn-use-location">
                            <i class="fas fa-location-arrow me-2"></i>Gunakan Lokasi Saya Saat Ini
                        </button>
                        <div class="location-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <span>Klik pada peta atau geser marker untuk memilih lokasi</span>
                        </div>
                    </div>
                    
                    <div id="map" class="location-map"></div>
                    
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>
                
                <div class="modal-footer-modern">
                    <button type="button" class="btn btn-cancel-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-confirm-modal">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi & Checkout
                    </button>
                </div>
            </form>
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
/* Fix z-index untuk modal dan leaflet */
.modal {
    z-index: 1055 !important;
}

/* Biarkan backdrop tidak menghalangi klik */
.modal-backdrop {
    pointer-events: none !important;
}

/* Modal dialog tetap bisa diklik */
.modal.show .modal-dialog {
    pointer-events: auto !important;
}

/* Semua konten dalam modal bisa diinteraksi */
.modal-content {
    pointer-events: auto !important;
    position: relative;
    z-index: 1056 !important;
}

.modal-dialog {
    z-index: 1056 !important;
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

    /* Cart Items */
    .cart-items-wrapper {
        display: flex;
        flex-direction: column;
    }

    .cart-item-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .cart-item-card:hover {
        border-color: rgba(255, 255, 255, 0.12);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Product Image & Info */
    .product-image-cart {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .product-image-cart img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info-cart {
        flex: 1;
    }

    .product-name-cart {
        color: #f3f4f6;
        font-weight: 600;
        font-size: 1rem;
    }

    .product-category-cart {
        display: inline-flex;
        align-items: center;
        background: rgba(156, 163, 175, 0.15);
        color: var(--primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.875rem;
    }

    /* Price Section */
    .price-section-cart {
        text-align: left;
    }

    .price-label-cart {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }

    .price-value-cart {
        font-size: 1rem;
        font-weight: 600;
        color: #f3f4f6;
    }

    /* Quantity Control */
    .quantity-form {
        display: flex;
    }

    .quantity-control {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .quantity-input {
        width: 70px;
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: #fff;
        text-align: center;
        font-weight: 600;
    }

    .quantity-input:focus {
        outline: none;
        border-color: var(--primary-color);
        background: rgba(255, 255, 255, 0.08);
    }

    .btn-update-qty {
        width: 36px;
        height: 36px;
        background: rgba(156, 163, 175, 0.15);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-update-qty:hover {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }

    /* Subtotal Section */
    .subtotal-section-cart {
        text-align: left;
    }

    .subtotal-label-cart {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }

    .subtotal-value-cart {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Delete Button */
    .btn-delete-cart {
        width: 40px;
        height: 40px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 10px;
        color: #EF4444;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-delete-cart:hover {
        background: #EF4444;
        color: #fff;
        border-color: #EF4444;
        transform: scale(1.05);
    }

    /* Checkout Section */
    .checkout-section {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
    }

    .total-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .total-label {
        font-size: 1.125rem;
        color: var(--text-secondary);
    }

    .total-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .btn-outline-continue {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-continue:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-color);
        color: #fff;
    }

    .btn-checkout {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
        color: #fff;
    }

    /* Modal Modern */
    .modal-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }

    .modal-header-modern {
        padding: 2rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .modal-title-modern {
        font-size: 1.5rem;
        font-weight: 700;
        color: #f3f4f6;
        margin: 0;
    }

    .modal-subtitle-modern {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0;
    }

    .btn-close-modern {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-close-modern:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: #EF4444;
        color: #EF4444;
    }

    .modal-body-modern {
        padding: 2rem;
    }

    /* Location Controls */
    .location-controls {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .btn-use-location {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: fit-content;
    }

    .btn-use-location:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
    }

    .location-info {
        display: flex;
        align-items: center;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #3B82F6;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
    }

    /* Location Map */
    .location-map {
        height: 400px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    /* Modal Footer */
    .modal-footer-modern {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-cancel-modal {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel-modal:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-color);
        color: #fff;
    }

    .btn-confirm-modal {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-confirm-modal:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .cart-item-card .row > div {
            margin-bottom: 1rem;
        }

        .cart-item-card .row > div:last-child {
            margin-bottom: 0;
        }

        .price-section-cart,
        .subtotal-section-cart {
            text-align: center;
        }

        .quantity-control {
            justify-content: center;
        }

        .btn-delete-cart {
            margin: 0 auto;
        }

        .checkout-section {
            text-align: center;
        }

        .total-info {
            flex-direction: column;
            gap: 0.5rem;
        }

        .checkout-section .d-flex {
            flex-direction: column;
        }

        .btn-outline-continue,
        .btn-checkout {
            width: 100%;
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

        .product-image-cart {
            width: 60px;
            height: 60px;
        }

        .product-name-cart {
            font-size: 0.9rem;
        }

        .modal-header-modern,
        .modal-body-modern,
        .modal-footer-modern {
            padding: 1.5rem;
        }

        .location-map {
            height: 300px;
        }

        .btn-use-location {
            width: 100%;
        }

        .modal-footer-modern {
            flex-direction: column;
        }

        .btn-cancel-modal,
        .btn-confirm-modal {
            width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let map, marker;

    const modal = document.getElementById('locationModal');
    modal.addEventListener('shown.bs.modal', function () {
        if (!map) {
            // Inisialisasi peta
            map = L.map('map').setView([-7.8019419, 111.9799224], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Marker yang bisa di-drag
            marker = L.marker([-7.8019419, 111.9799224], {draggable: true}).addTo(map);

            // Set initial values
            document.getElementById('latitude').value = (-7.8019419).toFixed(7);
            document.getElementById('longitude').value = (111.9799224).toFixed(7);

            // Event saat marker di-drag
            marker.on('dragend', function() {
                const pos = marker.getLatLng();
                document.getElementById('latitude').value = pos.lat.toFixed(7);
                document.getElementById('longitude').value = pos.lng.toFixed(7);
            });

            // Event saat peta di-click
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat.toFixed(7);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(7);
            });

            // Tombol gunakan lokasi saat ini
            document.getElementById('useLocationBtn').addEventListener('click', function() {
                if (navigator.geolocation) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendapatkan Lokasi...';
                    this.disabled = true;

                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 15);
                        document.getElementById('latitude').value = lat.toFixed(7);
                        document.getElementById('longitude').value = lng.toFixed(7);
                        
                        const btn = document.getElementById('useLocationBtn');
                        btn.innerHTML = '<i class="fas fa-check me-2"></i>Lokasi Berhasil Didapatkan';
                        setTimeout(() => {
                            btn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Gunakan Lokasi Saya Saat Ini';
                            btn.disabled = false;
                        }, 2000);
                    }, function(error) {
                        const btn = document.getElementById('useLocationBtn');
                        btn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Gunakan Lokasi Saya Saat Ini';
                        btn.disabled = false;
                        
                        let message = 'Tidak dapat mengakses lokasi.';
                        if (error.code === error.PERMISSION_DENIED) {
                            message = 'Izin akses lokasi ditolak. Silakan aktifkan GPS dan izinkan akses lokasi.';
                        } else if (error.code === error.POSITION_UNAVAILABLE) {
                            message = 'Informasi lokasi tidak tersedia.';
                        } else if (error.code === error.TIMEOUT) {
                            message = 'Waktu permintaan lokasi habis.';
                        }
                        alert(message);
                    });
                } else {
                    alert('Browser Anda tidak mendukung geolokasi.');
                }
            });
        } else {
            // Refresh peta jika sudah ada
            map.invalidateSize();
        }
    });
});
</script>
@endsection