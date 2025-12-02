@extends('layouts.admin')

@section('title', 'Monitor Absensi Real-time')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-tv me-2"></i>Monitor Absensi Real-time</h1>
    <div>
        <span id="currentTime" class="text-muted me-3"></span>
        <span id="autoRefresh" class="badge bg-success">Auto Refresh ON</span>
    </div>
</div>

<!-- Pilih Kegiatan & Scan NFC -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-calendar-event me-2"></i>Pilih Kegiatan & Scan NFC</h6>
            </div>
            <div class="card-body">
                <form id="monitorForm">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <select class="form-select" id="kegiatan_id" name="kegiatan_id">
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $keg)
                                    <option value="{{ $keg->id }}" {{ request('kegiatan_id') == $keg->id ? 'selected' : '' }}>
                                        {{ $keg->nama }} - {{ $keg->tanggal instanceof \Carbon\Carbon ? $keg->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($keg->tanggal)) }} ({{ $keg->jam_mulai }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="toggleScanMode" class="btn btn-outline-warning">
                                <i class="bi bi-qr-code-scan me-1"></i>Mode Scan
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Scan NFC Area -->
                <div id="scanArea" style="display: none;">
                    <hr>
                    <div class="text-center mb-3">
                        <div id="scanStatus">
                            <div class="pulse">
                                <i class="bi bi-credit-card display-4 text-success"></i>
                                <p class="mt-2 text-success fw-bold">Siap menerima scan NFC...</p>
                            </div>
                        </div>
                    </div>
                    <!-- AJAX Form -->
                    <form id="scanForm" onsubmit="event.preventDefault(); submitScan();">
                        <input type="hidden" id="scan_kegiatan_id" name="kegiatan_id">
                        <div class="mb-3">
                            <label for="uidInput" class="form-label"><strong>Scan NFC Card / Input UID:</strong></label>
                            <input type="text" id="uidInput" name="uid" class="form-control form-control-lg text-center" placeholder="Type UID here (e.g. 2921153879)..." autocomplete="off" style="font-size: 1.2em; padding: 15px; border: 3px solid #ffc107;">
                            <small class="form-text text-muted">Test dengan UID: <strong>2921153879</strong></small>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" id="manualScanBtn" class="btn btn-warning btn-lg">
                                <i class="bi bi-qr-code-scan me-2"></i>SUBMIT SCAN (AJAX)
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('uidInput').value='2921153879'">
                                <i class="bi bi-clipboard me-2"></i>Test dengan UID Sample
                            </button>
                        </div>
                    </form>
                    
                    <!-- Alternative: Regular Form Submission -->
                    <hr>
                    <form action="{{ route('monitor.scan') }}" method="POST" id="regularScanForm" target="hiddenFrame">
                        @csrf
                        <input type="hidden" name="kegiatan_id" id="regular_kegiatan_id">
                        <div class="mb-3">
                            <label class="form-label"><strong>Alternative: Regular Form Scan</strong></label>
                            <input type="text" name="uid" id="regularUidInput" class="form-control" placeholder="Type UID here..." value="2921153879">
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100" onclick="document.getElementById('regular_kegiatan_id').value = currentKegiatanId;">
                            <i class="bi bi-arrow-up-circle me-2"></i>SUBMIT SCAN (Regular Form)
                        </button>
                    </form>
                    
                    <!-- Hidden iframe for form submission -->
                    <iframe name="hiddenFrame" style="display: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row text-center" id="quickStats">
                    <div class="col-3">
                        <h4 class="text-primary" id="totalPeserta">{{ $totalPeserta }}</h4>
                        <small>Total Peserta</small>
                    </div>
                    <div class="col-3">
                        <h4 class="text-success" id="hadir">{{ $hadir }}</h4>
                        <small>Hadir</small>
                    </div>
                    <div class="col-3">
                        <h4 class="text-warning" id="terlambat">{{ $terlambat }}</h4>
                        <small>Terlambat</small>
                    </div>
                    <div class="col-3">
                        <h4 class="text-danger" id="belumHadir">{{ $totalPeserta - $hadir }}</h4>
                        <small>Belum Hadir</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($kegiatan)
<!-- Info Kegiatan Terpilih -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info">
            <div class="row">
                <div class="col-md-8">
                    <h5><i class="bi bi-info-circle me-2"></i>{{ $kegiatan->nama }}</h5>
                    <p class="mb-0">
                        <strong>Tanggal:</strong> {{ $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($kegiatan->tanggal)) }} |
                        <strong>Jam:</strong> {{ $kegiatan->jam_mulai }} |
                        <strong>Batas Tepat Waktu:</strong> {{ $kegiatan->jam_batas_tepat }}
                        @if($kegiatan->lokasi)
                            | <strong>Lokasi:</strong> {{ $kegiatan->lokasi }}
                        @endif
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="progress mb-2">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $totalPeserta > 0 ? ($hadir / $totalPeserta * 100) : 0 }}%"
                             id="progressBar">
                            {{ $totalPeserta > 0 ? round($hadir / $totalPeserta * 100, 1) : 0 }}%
                        </div>
                    </div>
                    <small class="text-muted">Tingkat Kehadiran</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Tabel Absensi Real-time -->
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h6><i class="bi bi-table me-2"></i>Daftar Absensi Real-time</h6>
        <div id="lastUpdate" class="text-muted small">
            @if($kegiatan)
                Last update: <span id="updateTime">{{ now()->format('H:i:s') }}</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if($kegiatan)
            <div class="table-responsive">
                <table class="table table-striped" id="absensiTable">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Waktu Absen</th>
                            <th width="120">Status</th>
                        </tr>
                    </thead>
                    <tbody id="absensiTableBody">
                        @if($absensis->count() > 0)
                            @foreach($absensis as $index => $absen)
                            <tr class="table-row-animate">
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $absen->peserta->nama }}</strong></td>
                                <td>{{ $absen->peserta->jabatan ?? '-' }}</td>
                                <td>{{ $absen->waktu_absen instanceof \Carbon\Carbon ? $absen->waktu_absen->format('H:i:s') : date('H:i:s', strtotime($absen->waktu_absen)) }}</td>
                                <td>
                                    <span class="badge bg-{{ $absen->status == 'tepat_waktu' ? 'success' : 'warning' }}">
                                        {{ $absen->status == 'tepat_waktu' ? 'Tepat Waktu' : 'Terlambat' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if($absensis->count() == 0)
                <div class="text-center py-5" id="noDataMessage">
                    <i class="bi bi-table display-1 text-muted"></i>
                    <h4 class="mt-3">Belum ada absensi untuk kegiatan ini</h4>
                    <p class="text-muted">Data akan muncul secara real-time saat peserta melakukan absensi</p>
                </div>
            @endif
        @else
            <div class="text-center py-5" id="noDataMessage">
                <i class="bi bi-table display-1 text-muted"></i>
                <h4 class="mt-3">Pilih kegiatan untuk memulai monitoring</h4>
                <p class="text-muted">Data akan muncul secara real-time saat peserta melakukan absensi</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<style>
.table-row-animate {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.pulse-new {
    animation: pulse 2s infinite;
    background-color: #d4edda !important;
}
</style>

<script>
let isRefreshing = true;
let refreshInterval;
let currentKegiatanId = '{{ request("kegiatan_id") }}';
let isScanReady = false;

// Audio notifications
const successSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmgfCCJ+zPLZiDgIDWS57+OZVA0PVqzn8bllHgg2jdXzzn0vBSF0xe/eizELElyx6OyrWBUIQ5zd8sFuIAUuhM/z24k2CRZiturqnVITC0ml4PK8aB4IMo/W8tGAMQYfcsLu45hSEQpRp+Xxu2kjBi+BzvPajjkJFGC16+OdUhIMUqPi8L5qIAcuhM7z3Yo3CRdiu+zmnVMSC0qj4PG9aCAGLYPO8tyJNgkVYbXs450SE...');
const errorSound = new Audio('data:audio/wav;base64,UklGRmwBAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YSABAAABBR1bnMDYJRm3Yl5Y/7VdEPmYuUj8y2ZD/M8IQAL+TCM+B/HQWjD4v1E//NSjNf/RwqP+0bJ3/N1LMv/G3xv8zYct/c2PPf7JN0b+yVY1/c9OM//Tqyj//z4C//4wA//8OAPM/8r1TP/JaUL+z1g2/c/CL//WpCb/zzQO//8pCP/8QwD/2Z8j/8tePP7UcCz/25gd/0c8+f7Vhyb/yWg8/ss9Av/9KQL/31wW/9GILD...');

document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);

    // Handle kegiatan selection
    document.getElementById('kegiatan_id').addEventListener('change', function() {
        const kegiatanId = this.value;
        if (kegiatanId) {
            currentKegiatanId = kegiatanId;
            document.getElementById('scan_kegiatan_id').value = kegiatanId;
            // Don't auto show scan area, wait for user to click Mode Scan
            document.getElementById('scanArea').style.display = 'none';
            isScanReady = false;
            window.location.href = `{{ route('monitor.index') }}?kegiatan_id=${kegiatanId}`;
        } else {
            currentKegiatanId = '';
            document.getElementById('scanArea').style.display = 'none';
            isScanReady = false;
            stopAutoRefresh();
        }
    });

    // Handle UID input for NFC scanning
    const uidInput = document.getElementById('uidInput');
    if (uidInput) {
        uidInput.addEventListener('input', function() {
            console.log('UID input changed:', this.value, 'length:', this.value.length, 'isScanReady:', isScanReady);
            if (isScanReady && this.value.length > 3) {
                // Auto submit when UID is scanned
                setTimeout(() => {
                    if (this.value.length > 3) {
                        console.log('Auto submitting scan...');
                        submitScan();
                    }
                }, 100);
            }
        });
        
        // Add keypress handler for manual testing
        uidInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (isScanReady && this.value.length > 0) {
                    console.log('Manual submit via Enter key');
                    submitScan();
                }
            }
        });
    }

    // Maintain focus on UID input
    document.addEventListener('click', function(e) {
        if (isScanReady && e.target !== uidInput && e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON' && e.target.tagName !== 'SELECT') {
            focusUidInput();
        }
    });

    // Setup initial state
    if (currentKegiatanId) {
        document.getElementById('scan_kegiatan_id').value = currentKegiatanId;
        // Don't auto show scan area on page load
        document.getElementById('scanArea').style.display = 'none';
        isScanReady = false;
        
        // Start auto refresh for monitoring
        startAutoRefresh();
    }

    // Handle regular form submission response
    document.getElementById('regularScanForm').addEventListener('submit', function(e) {
        showScanStatus('Mengirim data via form biasa...', 'info');
        
        // Set a timeout to refresh data after form submission
        setTimeout(() => {
            console.log('Refreshing after regular form submit...');
            fetchLatestData();
            showScanStatus('Form submitted - check console for any errors', 'success');
        }, 1000);
    });
});

    // Toggle scan mode
    document.getElementById('toggleScanMode').addEventListener('click', function() {
        const scanArea = document.getElementById('scanArea');
        const isCurrentlyScanning = scanArea.style.display === 'block';
        
        if (isCurrentlyScanning) {
            // Exit scan mode
            scanArea.style.display = 'none';
            isScanReady = false;
            this.innerHTML = '<i class="bi bi-qr-code-scan me-1"></i>Mode Scan';
            this.className = 'btn btn-outline-warning';
            
            // Resume auto refresh
            if (currentKegiatanId) {
                startAutoRefresh();
                document.getElementById('autoRefresh').textContent = 'Auto Refresh ON';
                document.getElementById('autoRefresh').className = 'badge bg-success';
            }
        } else {
            // Enter scan mode
            if (!currentKegiatanId) {
                alert('Pilih kegiatan terlebih dahulu!');
                return;
            }
            
            scanArea.style.display = 'block';
            isScanReady = true;
            this.innerHTML = '<i class="bi bi-x-circle me-1"></i>Exit Scan';
            this.className = 'btn btn-outline-danger';
            
            // Stop auto refresh during scan mode
            stopAutoRefresh();
            document.getElementById('autoRefresh').textContent = 'Scan Mode Active';
            document.getElementById('autoRefresh').className = 'badge bg-warning';
            
            // Focus on input
            focusUidInput();
        }
    });

    // Start auto refresh if kegiatan selected
    if (currentKegiatanId) {
        startAutoRefresh();
    }
});

function updateCurrentTime() {
    const now = new Date();
    document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID');
}

function focusUidInput() {
    const uidInput = document.getElementById('uidInput');
    if (uidInput && isScanReady) {
        uidInput.focus();
    }
}

function submitScan() {
    const uidInput = document.getElementById('uidInput');
    const scanStatus = document.getElementById('scanStatus');
    const uid = uidInput.value.trim();
    
    console.log('=== SUBMIT SCAN DEBUG ===');
    console.log('Submit scan called with UID:', uid);
    console.log('Current kegiatan ID:', currentKegiatanId);
    console.log('isScanReady:', isScanReady);
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
    
    if (!uid) {
        console.log('ERROR: UID kosong');
        showScanStatus('UID kosong', 'warning');
        return;
    }

    if (!currentKegiatanId) {
        console.log('ERROR: Kegiatan belum dipilih');
        showScanStatus('Pilih kegiatan terlebih dahulu', 'warning');
        return;
    }

    // Show scanning status
    console.log('Mengirim request scan...');
    showScanStatus('Memproses scan...', 'info');
    
    // Submit scan request
    fetch('{{ route("monitor.scan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            uid: uid,
            kegiatan_id: currentKegiatanId
        })
    })
    .then(async response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('HTTP Error:', response.status, errorText);
            throw new Error(`HTTP ${response.status}: ${errorText.substring(0, 100)}`);
        }
        
        const data = await response.json();
        console.log('Response data:', data);
        return data;
    })
    .then(data => {
        if (data.success) {
            showScanStatus(data.message, 'success');
            successSound.play().catch(() => {});
            // Refresh data immediately to show new entry in table
            console.log('Scan successful, refreshing data...');
            fetchLatestData();
        } else {
            showScanStatus(data.message, 'danger');
            errorSound.play().catch(() => {});
        }
        
        // Clear UID and refocus
        uidInput.value = '';
        setTimeout(() => focusUidInput(), 1000);
    })
    .catch(error => {
        console.error('Scan error:', error);
        showScanStatus('Error saat melakukan scan: ' + error.message, 'danger');
        errorSound.play().catch(() => {});
        uidInput.value = '';
        setTimeout(() => focusUidInput(), 1000);
    });
}

function showScanStatus(message, type) {
    const scanStatus = document.getElementById('scanStatus');
    scanStatus.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Auto hide after 3 seconds for success/info
    if (type === 'success' || type === 'info') {
        setTimeout(() => {
            const alert = scanStatus.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 3000);
    }
}

function startAutoRefresh() {
    if (!currentKegiatanId) return;
    
    isRefreshing = true;
    refreshInterval = setInterval(fetchLatestData, 3000); // Refresh every 3 seconds
}

function stopAutoRefresh() {
    isRefreshing = false;
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
}

function fetchLatestData() {
    if (!currentKegiatanId) {
        console.log('fetchLatestData: No kegiatan selected');
        return;
    }

    console.log('Fetching latest data for kegiatan:', currentKegiatanId);

    fetch(`{{ route('monitor.data') }}?kegiatan_id=${currentKegiatanId}`)
        .then(response => {
            console.log('Data fetch response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Latest data received:', data);
            updateStats(data.stats);
            updateTable(data.absensis);
            document.getElementById('updateTime').textContent = new Date().toLocaleTimeString('id-ID');
            
            // Update progress bar
            const percentage = data.stats.total_peserta > 0 ? (data.stats.hadir / data.stats.total_peserta * 100) : 0;
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = percentage + '%';
            progressBar.textContent = Math.round(percentage * 10) / 10 + '%';
            
            console.log('Data fetch completed successfully');
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

function updateStats(stats) {
    document.getElementById('totalPeserta').textContent = stats.total_peserta;
    document.getElementById('hadir').textContent = stats.hadir;
    document.getElementById('terlambat').textContent = stats.terlambat;
    document.getElementById('belumHadir').textContent = stats.belum_hadir;
}

function updateTable(absensis) {
    console.log('=== UPDATE TABLE DEBUG ===');
    console.log('Received absensis data:', absensis);
    
    const tbody = document.getElementById('absensiTableBody');
    const noDataMessage = document.getElementById('noDataMessage');
    
    console.log('tbody element:', tbody);
    console.log('noDataMessage element:', noDataMessage);
    console.log('absensis length:', absensis.length);
    
    if (absensis.length === 0) {
        console.log('No data - showing empty state');
        if (tbody) tbody.innerHTML = '';
        if (noDataMessage) noDataMessage.style.display = 'block';
        return;
    }

    console.log('Data found - updating table');
    if (noDataMessage) noDataMessage.style.display = 'none';
    
    let html = '';
    absensis.forEach((absen, index) => {
        console.log(`Processing absen ${index}:`, absen);
        const badgeClass = absen.status === 'tepat_waktu' ? 'success' : 'warning';
        const isNew = index === 0; // Assume first item is newest
        
        html += `
            <tr class="table-row-animate ${isNew ? 'pulse-new' : ''}">
                <td>${index + 1}</td>
                <td><strong>${absen.peserta_nama}</strong></td>
                <td>${absen.peserta_jabatan || '-'}</td>
                <td>${absen.waktu_absen}</td>
                <td>
                    <span class="badge bg-${badgeClass}">
                        ${absen.status_text}
                    </span>
                </td>
            </tr>
        `;
    });
    
    console.log('Generated HTML:', html);
    
    if (tbody) {
        tbody.innerHTML = html;
        console.log('Table updated successfully');
        
        // Remove pulse effect after animation
        setTimeout(() => {
            const pulseElements = document.querySelectorAll('.pulse-new');
            pulseElements.forEach(el => el.classList.remove('pulse-new'));
        }, 2000);
    } else {
        console.error('tbody element not found!');
    }
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    stopAutoRefresh();
});
</script>
@endpush