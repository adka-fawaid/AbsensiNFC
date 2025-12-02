@extends('layouts.admin')

@section('title', 'Monitor Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-tv me-2"></i>Monitor Absensi</h1>
    <div>
        <span id="currentTime" class="text-muted me-3"></span>
        @if($kegiatan)
            <span class="badge bg-success">Auto Refresh ON</span>
        @endif
    </div>
</div>

<!-- Simple Controls -->
<div class="row mb-4">
    <div class="col-md-8">
        <select class="form-select form-select-lg" id="kegiatan_id">
            <option value="">-- Pilih Kegiatan untuk Monitoring --</option>
            @foreach($kegiatans as $keg)
                <option value="{{ $keg->id }}" {{ request('kegiatan_id') == $keg->id ? 'selected' : '' }}>
                    {{ $keg->nama }} - {{ $keg->tanggal instanceof \Carbon\Carbon ? $keg->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($keg->tanggal)) }} ({{ $keg->jam_mulai }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        @if($kegiatan)
            <div class="btn-group w-100" role="group">
                <a href="{{ route('monitor.export.pdf', ['kegiatan_id' => $kegiatan->id]) }}" class="btn btn-danger btn-lg">
                    <i class="bi bi-filetype-pdf me-1"></i>Export PDF
                </a>
                <a href="{{ route('monitor.export.excel', ['kegiatan_id' => $kegiatan->id]) }}" class="btn btn-success btn-lg">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
                </a>
            </div>
        @else
            <a href="{{ route('scan.index') }}" class="btn btn-primary btn-lg w-100" target="_blank">
                <i class="bi bi-qr-code-scan me-1"></i>Buka Halaman Scan
            </a>
        @endif
    </div>
</div>

@if($kegiatan)
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h2 id="totalPeserta">{{ $totalPeserta }}</h2>
                <p class="mb-0">Total Peserta</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h2 id="hadir">{{ $hadir }}</h2>
                <p class="mb-0">Hadir</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h2 id="terlambat">{{ $terlambat ?? 0 }}</h2>
                <p class="mb-0">Terlambat</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h2 id="belumHadir">{{ $totalPeserta - $hadir }}</h2>
                <p class="mb-0">Belum Hadir</p>
            </div>
        </div>
    </div>
</div>

<!-- Kegiatan Info -->
<div class="alert alert-info mb-4">
    <h5 class="mb-1">{{ $kegiatan->nama }}</h5>
    <small>
        {{ $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($kegiatan->tanggal)) }} 
        {{ $kegiatan->jam_mulai }} 
        @if($kegiatan->lokasi)| {{ $kegiatan->lokasi }}@endif
    </small>
</div>
@endif

<!-- Tabel Absensi -->
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h6><i class="bi bi-table me-2"></i>Data Absensi Real-time</h6>
        @if($kegiatan)
            <small class="text-muted">Update: <span id="updateTime">{{ now()->setTimezone('Asia/Jakarta')->format('H:i:s') }}</span></small>
        @endif
    </div>
    <div class="card-body">
        @if($kegiatan)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Waktu Absen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="absensiTableBody">
                        @if($absensis->count() > 0)
                            @foreach($absensis as $index => $absen)
                            <tr>
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
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <p class="mt-2">Belum ada data absensi</p>
                                    <a href="{{ route('scan.index') }}" class="btn btn-success btn-sm" target="_blank">
                                        <i class="bi bi-qr-code-scan me-1"></i>Mulai Scan
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-check display-1 text-muted"></i>
                <h4 class="mt-3">Pilih Kegiatan untuk Monitoring</h4>
                <p class="text-muted">Pilih kegiatan dari dropdown di atas</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentKegiatanId = '{{ request("kegiatan_id") }}';
let refreshInterval;

document.addEventListener('DOMContentLoaded', function() {
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);

    // Handle kegiatan selection
    document.getElementById('kegiatan_id').addEventListener('change', function() {
        const kegiatanId = this.value;
        if (kegiatanId) {
            window.location.href = `{{ route('monitor.index') }}?kegiatan_id=${kegiatanId}`;
        } else {
            window.location.href = `{{ route('monitor.index') }}`;
        }
    });

    // Start auto refresh
    if (currentKegiatanId) {
        startAutoRefresh();
    }
});

function updateCurrentTime() {
    const now = new Date();
    const jakartaTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Jakarta"}));
    document.getElementById('currentTime').textContent = jakartaTime.toLocaleTimeString('id-ID');
}

function startAutoRefresh() {
    if (!currentKegiatanId) return;
    refreshInterval = setInterval(fetchLatestData, 3000);
}

function fetchLatestData() {
    if (!currentKegiatanId) return;

    fetch(`{{ route('monitor.data') }}?kegiatan_id=${currentKegiatanId}`)
        .then(response => response.json())
        .then(data => {
            updateStats(data.stats);
            updateTable(data.absensis);
            const updateNow = new Date();
            const jakartaUpdateTime = new Date(updateNow.toLocaleString("en-US", {timeZone: "Asia/Jakarta"}));
            document.getElementById('updateTime').textContent = jakartaUpdateTime.toLocaleTimeString('id-ID');
        })
        .catch(error => console.error('Error:', error));
}

function updateStats(stats) {
    document.getElementById('totalPeserta').textContent = stats.total_peserta;
    document.getElementById('hadir').textContent = stats.hadir;
    document.getElementById('terlambat').textContent = stats.terlambat;
    document.getElementById('belumHadir').textContent = stats.belum_hadir;
}

function updateTable(absensis) {
    const tbody = document.getElementById('absensiTableBody');
    if (!tbody) return;
    
    if (absensis.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <p class="mt-2">Belum ada data absensi</p>
                    <a href="{{ route('scan.index') }}" class="btn btn-success btn-sm" target="_blank">
                        <i class="bi bi-qr-code-scan me-1"></i>Mulai Scan
                    </a>
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    absensis.forEach((absen, index) => {
        const badgeClass = absen.status === 'tepat_waktu' ? 'success' : 'warning';
        html += `
            <tr>
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
    
    tbody.innerHTML = html;
}

window.addEventListener('beforeunload', function() {
    if (refreshInterval) clearInterval(refreshInterval);
});
</script>
@endpush