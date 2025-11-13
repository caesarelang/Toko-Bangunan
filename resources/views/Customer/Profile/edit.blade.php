@extends('Customer.Layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="page-header mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="display-5 fw-bold mb-2">
                    <span class="gradient-text">Edit Profil</span>
                </h2>
                <p class="text-secondary fs-5">Perbarui informasi profil Anda</p>
            </div>
            <a href="{{ route('customer.profile') }}" class="btn btn-outline-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-modern alert-success mb-4">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-modern alert-danger mb-4">
            <div class="alert-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="alert-content">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Edit Form -->
    <form action="{{ route('customer.profile.update') }}" method="POST">
        @csrf
        
        <div class="row g-4">
            <!-- Form Fields -->
            <div class="col-lg-6">
                <div class="form-card">
                    <div class="form-card-header">
                        <i class="fas fa-user-edit me-2"></i>Informasi Pribadi
                    </div>
                    <div class="form-card-body">
                        <!-- Name -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control-modern @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   placeholder="Masukkan nama lengkap Anda">
                            @error('name')
                                <div class="invalid-feedback-modern">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control-modern @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   placeholder="nama@email.com">
                            @error('email')
                                <div class="invalid-feedback-modern">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- WhatsApp -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fab fa-whatsapp me-2"></i>Nomor WhatsApp
                            </label>
                            <input type="text" 
                                   name="whatsapp" 
                                   class="form-control-modern @error('whatsapp') is-invalid @enderror" 
                                   value="{{ old('whatsapp', $user->whatsapp) }}"
                                   placeholder="08xxxxxxxxxx">
                            <small class="form-text-modern">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: 08xxxxxxxxxx (Opsional)
                            </small>
                            @error('whatsapp')
                                <div class="invalid-feedback-modern">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Latitude -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-map-pin me-2"></i>Latitude
                            </label>
                            <input type="text" 
                                   id="latitude" 
                                   name="latitude" 
                                   class="form-control-modern" 
                                   value="{{ old('latitude', $user->latitude) }}"
                                   readonly
                                   placeholder="Akan terisi otomatis dari peta">
                        </div>

                        <!-- Longitude -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-map-pin me-2"></i>Longitude
                            </label>
                            <input type="text" 
                                   id="longitude" 
                                   name="longitude" 
                                   class="form-control-modern" 
                                   value="{{ old('longitude', $user->longitude) }}"
                                   readonly
                                   placeholder="Akan terisi otomatis dari peta">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="col-lg-6">
                <div class="map-form-card">
                    <div class="map-form-header">
                        <div class="map-form-title">
                            <i class="fas fa-map-marked-alt me-2"></i>Pilih Lokasi Anda
                        </div>
                        <button type="button" id="useLocationBtn" class="btn btn-use-location-small">
                            <i class="fas fa-location-arrow me-2"></i>Gunakan Lokasi Saya
                        </button>
                    </div>
                    
                    <div class="location-info-box">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>Klik pada peta atau geser marker untuk memilih lokasi Anda</span>
                    </div>

                    <div id="map" class="location-map-edit"></div>

                    <div class="coordinates-display">
                        <div class="coord-item">
                            <span class="coord-label">Lat:</span>
                            <span class="coord-value" id="displayLat">{{ $user->latitude ?? '-7.8019419' }}</span>
                        </div>
                        <div class="coord-separator">|</div>
                        <div class="coord-item">
                            <span class="coord-label">Long:</span>
                            <span class="coord-value" id="displayLng">{{ $user->longitude ?? '111.9799224' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('customer.profile') }}" class="btn btn-cancel-form">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-submit-form">
                <i class="fas fa-save me-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
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

    .btn-outline-back {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-back:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-color);
        color: #fff;
    }

    /* Alert Modern */
    .alert-modern {
        display: flex;
        align-items: flex-start;
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

    .alert-content ul {
        padding-left: 1.25rem;
    }

    /* Form Card */
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
    }

    .form-card-header {
        padding: 1.5rem 2rem;
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid var(--border-color);
        font-size: 1.25rem;
        font-weight: 700;
        color: #f3f4f6;
    }

    .form-card-body {
        padding: 2rem;
    }

    /* Form Group Modern */
    .form-group-modern {
        margin-bottom: 1.5rem;
    }

    .form-group-modern:last-child {
        margin-bottom: 0;
    }

    .form-label-modern {
        display: block;
        margin-bottom: 0.75rem;
        color: #f3f4f6;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .form-control-modern {
        width: 100%;
        padding: 0.875rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: #fff;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: var(--primary-color);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 3px rgba(156, 163, 175, 0.1);
    }

    .form-control-modern::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .form-control-modern[readonly] {
        background: rgba(255, 255, 255, 0.02);
        cursor: not-allowed;
        color: var(--text-secondary);
    }

    .form-control-modern.is-invalid {
        border-color: #EF4444;
    }

    .form-text-modern {
        display: block;
        margin-top: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .invalid-feedback-modern {
        display: block;
        margin-top: 0.5rem;
        color: #EF4444;
        font-size: 0.875rem;
    }

    /* Map Form Card */
    .map-form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
    }

    .map-form-header {
        padding: 1.5rem 2rem;
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .map-form-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #f3f4f6;
    }

    .btn-use-location-small {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-use-location-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(156, 163, 175, 0.3);
    }

    .btn-use-location-small:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .location-info-box {
        display: flex;
        align-items: center;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-left: 4px solid #3B82F6;
        color: #3B82F6;
        padding: 0.875rem 1.5rem;
        margin: 1.5rem 2rem;
        border-radius: 10px;
        font-size: 0.875rem;
    }

    .location-map-edit {
        height: 400px;
        border: none;
    }

    .coordinates-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 1.5rem 2rem;
        background: rgba(255, 255, 255, 0.02);
        border-top: 1px solid var(--border-color);
    }

    .coord-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .coord-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 600;
    }

    .coord-value {
        color: var(--primary-color);
        font-size: 0.95rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
    }

    .coord-separator {
        color: var(--border-color);
        font-size: 1.25rem;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-cancel-form {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-cancel-form:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-color);
        color: #fff;
    }

    .btn-submit-form {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: #fff;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit-form:hover {
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

        .page-header .btn-outline-back {
            width: 100%;
        }

        .form-card {
            margin-bottom: 2rem;
        }

        .location-map-edit {
            height: 350px;
        }

        .map-form-header {
            flex-direction: column;
            text-align: center;
        }

        .btn-use-location-small {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .form-card-header,
        .form-card-body,
        .map-form-header {
            padding: 1.25rem 1.5rem;
        }

        .location-info-box {
            margin: 1.25rem 1.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
        }

        .location-map-edit {
            height: 300px;
        }

        .coordinates-display {
            padding: 1.25rem 1.5rem;
            flex-wrap: wrap;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel-form,
        .btn-submit-form {
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
    // Koordinat awal
    var lat = parseFloat('{{ $user->latitude ?? -7.8019419 }}');
    var lng = parseFloat('{{ $user->longitude ?? 111.9799224 }}');

    // Inisialisasi peta
    var map = L.map('map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Marker draggable
    var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

    // Custom icon untuk marker
    var customIcon = L.divIcon({
        className: 'custom-marker',
        html: '<i class="fas fa-map-marker-alt" style="color: #9ca3af; font-size: 2rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>',
        iconSize: [30, 42],
        iconAnchor: [15, 42]
    });
    marker.setIcon(customIcon);

    // Fungsi update koordinat
    function updateCoordinates(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(7);
        document.getElementById('longitude').value = lng.toFixed(7);
        document.getElementById('displayLat').textContent = lat.toFixed(6);
        document.getElementById('displayLng').textContent = lng.toFixed(6);
    }

    // Set koordinat awal
    updateCoordinates(lat, lng);

    // Update saat marker digeser
    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
    });

    // Update saat peta diklik
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
    });

    // Tombol "Gunakan Lokasi Saya"
    document.getElementById('useLocationBtn').addEventListener('click', function() {
        if (navigator.geolocation) {
            // Ubah tampilan tombol
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendapatkan Lokasi...';
            this.disabled = true;

            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                
                // Update marker dan peta
                marker.setLatLng([userLat, userLng]);
                map.setView([userLat, userLng], 15);
                updateCoordinates(userLat, userLng);

                // Kembalikan tombol
                var btn = document.getElementById('useLocationBtn');
                btn.innerHTML = '<i class="fas fa-check me-2"></i>Lokasi Berhasil Didapatkan!';
                
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Gunakan Lokasi Saya';
                    btn.disabled = false;
                }, 2000);

            }, function(error) {
                var btn = document.getElementById('useLocationBtn');
                btn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Gunakan Lokasi Saya';
                btn.disabled = false;

                let message = 'Tidak dapat mengakses lokasi.';
                if (error.code === error.PERMISSION_DENIED) {
                    message = 'Izin akses lokasi ditolak. Silakan aktifkan GPS dan izinkan akses lokasi di browser Anda.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    message = 'Informasi lokasi tidak tersedia saat ini.';
                } else if (error.code === error.TIMEOUT) {
                    message = 'Waktu permintaan lokasi habis. Silakan coba lagi.';
                }
                
                alert(message);
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        } else {
            alert('Browser Anda tidak mendukung fitur geolokasi.');
        }
    });

    // Refresh map size
    setTimeout(function() {
        map.invalidateSize();
    }, 250);
});
</script>
@endsection