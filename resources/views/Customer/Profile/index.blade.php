@extends('Customer.Layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="page-header mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="display-5 fw-bold mb-2">
                    <span class="gradient-text">Profil Saya</span>
                </h2>
                <p class="text-secondary fs-5">Kelola informasi profil Anda</p>
            </div>
            <a href="{{ route('customer.profile.edit') }}" class="btn btn-gradient">
                <i class="fas fa-edit me-2"></i>Edit Profil
            </a>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="row g-4">
        <!-- Profile Info Card -->
        <div class="col-lg-5">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4 class="profile-name">{{ $user->name }}</h4>
                    <p class="profile-subtitle">Member sejak {{ $user->created_at->format('d M Y') }}</p>
                </div>

                <div class="profile-details">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">WhatsApp</div>
                            <div class="detail-value">{{ $user->whatsapp ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Bergabung Pada</div>
                            <div class="detail-value">{{ $user->created_at->translatedFormat('d F Y') }}</div>
                        </div>
                    </div>

                    @if($user->latitude && $user->longitude)
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Lokasi</div>
                            <div class="detail-value">{{ number_format($user->latitude, 6) }}, {{ number_format($user->longitude, 6) }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="profile-actions">
                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-edit-full">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Map Card -->
        <div class="col-lg-7">
            <div class="map-card">
                <div class="map-header">
                    <div class="map-title">
                        <i class="fas fa-map-marked-alt me-2"></i>Lokasi Anda
                    </div>
                    @if($user->latitude && $user->longitude)
                    <div class="map-badge">
                        <i class="fas fa-check-circle me-1"></i>Lokasi Tersimpan
                    </div>
                    @else
                    <div class="map-badge map-badge-warning">
                        <i class="fas fa-exclamation-circle me-1"></i>Belum Ada Lokasi
                    </div>
                    @endif
                </div>
                <div id="map" class="location-map-profile"></div>
                @if(!$user->latitude || !$user->longitude)
                <div class="map-empty-state">
                    <i class="fas fa-map-marker-alt mb-3"></i>
                    <p>Anda belum mengatur lokasi</p>
                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-set-location">
                        <i class="fas fa-plus-circle me-2"></i>Atur Lokasi
                    </a>
                </div>
                @endif
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
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
        color: #fff;
    }

    /* Profile Card */
    .profile-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
    }

    .profile-header {
        text-align: center;
        padding: 3rem 2rem 2rem;
        background: linear-gradient(135deg, rgba(156, 163, 175, 0.1), rgba(107, 114, 128, 0.1));
        border-bottom: 1px solid var(--border-color);
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 24px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 3rem;
        color: #fff;
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.2);
    }

    .profile-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: #f3f4f6;
        margin-bottom: 0.5rem;
    }

    .profile-subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }

    /* Profile Details */
    .profile-details {
        padding: 2rem;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 255, 255, 0.12);
    }

    .detail-item:last-child {
        margin-bottom: 0;
    }

    .detail-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: rgba(156, 163, 175, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .detail-content {
        flex: 1;
        min-width: 0;
    }

    .detail-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-size: 1rem;
        font-weight: 600;
        color: #f3f4f6;
        word-break: break-word;
    }

    /* Profile Actions */
    .profile-actions {
        padding: 1.5rem 2rem 2rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-edit-full {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-edit-full:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
        color: #fff;
    }

    /* Map Card */
    .map-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .map-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.02);
    }

    .map-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #f3f4f6;
        display: flex;
        align-items: center;
    }

    .map-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .map-badge-warning {
        background: rgba(245, 158, 11, 0.15);
        color: #F59E0B;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .location-map-profile {
        height: 100%;
        min-height: 500px;
        border: none;
        position: relative;
    }

    .map-empty-state {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 1000;
        background: var(--card-bg);
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        backdrop-filter: blur(10px);
    }

    .map-empty-state i {
        font-size: 3rem;
        color: var(--text-secondary);
        opacity: 0.5;
    }

    .map-empty-state p {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .btn-set-location {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-set-location:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
        color: #fff;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .page-header .d-flex {
            flex-direction: column;
            gap: 1rem !important;
            text-align: center;
        }

        .page-header .btn-gradient {
            width: 100%;
        }

        .profile-card {
            margin-bottom: 2rem;
        }

        .location-map-profile {
            min-height: 400px;
        }

        .map-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .profile-avatar {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }

        .profile-name {
            font-size: 1.5rem;
        }

        .profile-details {
            padding: 1.5rem;
        }

        .detail-item {
            padding: 1rem;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .location-map-profile {
            min-height: 300px;
        }

        .map-header {
            padding: 1rem 1.5rem;
        }

        .map-title {
            font-size: 1.125rem;
        }

        .map-badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.75rem;
        }
    }
</style>
@endsection

@section('scripts')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var latitude = {{ $user->latitude ?? -7.8019419 }};
    var longitude = {{ $user->longitude ?? 111.9799224 }};
    var hasLocation = {{ ($user->latitude && $user->longitude) ? 'true' : 'false' }};

    // Inisialisasi peta
    var map = L.map('map').setView([latitude, longitude], hasLocation ? 15 : 13);

    // Tambahkan tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan marker jika ada lokasi
    if (hasLocation) {
        var marker = L.marker([latitude, longitude]).addTo(map);
        
        // Custom popup
        var popupContent = `
            <div style="text-align: center; padding: 0.5rem;">
                <strong style="color: #111; font-size: 1rem;">📍 {{ $user->name }}</strong><br>
                <small style="color: #666;">Lokasi Anda</small>
            </div>
        `;
        
        marker.bindPopup(popupContent).openPopup();

        // Tambahkan circle untuk radius
        L.circle([latitude, longitude], {
            color: '#9ca3af',
            fillColor: '#9ca3af',
            fillOpacity: 0.2,
            radius: 500
        }).addTo(map);
    }

    // Refresh map size setelah semua dimuat
    setTimeout(function() {
        map.invalidateSize();
    }, 250);
});
</script>
@endsection