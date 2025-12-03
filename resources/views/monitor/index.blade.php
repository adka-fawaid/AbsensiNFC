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

<!-- Info Alert -->
<div class="alert alert-info mb-3">
    <div class="d-flex">
        <div class="flex-shrink-0">
            <i class="bi bi-info-circle-fill"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <strong>Monitoring Semua Kegiatan</strong><br>
            <small>Kamu bisa memantau dan export data dari semua kegiatan (selesai, berlangsung, atau akan datang)</small>
        </div>
    </div>
</div>

<!-- Simple Controls -->
<div class="row mb-4">
    <div class="col-md-8">
        <select class="form-select form-select-lg" id="kegiatan_id">
            <option value="">-- Pilih Kegiatan untuk Monitoring --</option>
            @foreach($kegiatans as $keg)
                @php
                    $tanggalKegiatan = $keg->tanggal instanceof \Carbon\Carbon ? $keg->tanggal->format('Y-m-d') : $keg->tanggal;
                    $waktuSekarang = now()->format('Y-m-d');
                    
                    if ($tanggalKegiatan < $waktuSekarang) {
                        $statusKegiatan = 'SELESAI';
                        $statusClass = 'success';
                    } elseif ($tanggalKegiatan == $waktuSekarang) {
                        $statusKegiatan = 'BERLANGSUNG';
                        $statusClass = 'danger';
                    } else {
                        $statusKegiatan = 'AKAN DATANG';
                        $statusClass = 'warning';
                    }
                @endphp
                <option value="{{ $keg->id }}" {{ request('kegiatan_id') == $keg->id ? 'selected' : '' }}>
                    [{{ $statusKegiatan }}] {{ $keg->nama }} - {{ $keg->tanggal instanceof \Carbon\Carbon ? $keg->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($keg->tanggal)) }} ({{ $keg->jam_mulai }})
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
            <div class="card-body text-center" >
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
        <div class="card bg-warning text-white filter-card" 
             data-filter="terlambat" 
             onclick="filterData('terlambat')" 
             style="cursor: pointer; transition: transform 0.2s;" 
             onmouseover="this.style.transform='translateY(-2px)'" 
             onmouseout="this.style.transform='translateY(0)'">
            <div class="card-body text-center">
                <h2 id="terlambat">{{ $terlambat ?? 0 }}</h2>
                <p class="mb-0">
                    Terlambat
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white filter-card" 
             data-filter="belum-hadir" 
             onclick="filterData('belum-hadir')" 
             style="cursor: pointer; transition: transform 0.2s;" 
             onmouseover="this.style.transform='translateY(-2px)'" 
             onmouseout="this.style.transform='translateY(0)'">
            <div class="card-body text-center">
                <h2 id="belumHadir">{{ $totalPeserta - $hadir }}</h2>
                <p class="mb-0">
                    Belum Hadir
                </p>
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

<!-- Filter Controls -->
@if($kegiatan)
<div id="filterControls" class="mb-3" style="display: none;">
    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-funnel me-2"></i>
            <span id="filterStatus">Menampilkan semua data</span>
        </div>
        <button class="btn btn-sm btn-outline-primary" onclick="clearFilter()">
            <i class="bi bi-x-circle me-1"></i>Hapus Filter
        </button>
    </div>
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
let currentFilter = null;
let allAbsensis = [];
let allPesertas = @json($kegiatan ? $kegiatan->pesertas : []);

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
            
            // Update peserta data for belum hadir filter
            if (data.pesertas) {
                allPesertas = data.pesertas;
            }
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
    allAbsensis = absensis; // Store for filtering
    const tbody = document.getElementById('absensiTableBody');
    if (!tbody) return;
    
    // Apply current filter
    let displayData = currentFilter ? applyFilter(absensis) : absensis;
    
    if (displayData.length === 0) {
        const emptyMessage = currentFilter ? 
            `<tr><td colspan="5" class="text-center py-4"><i class="bi bi-inbox display-4 text-muted"></i><p class="mt-2">Tidak ada data untuk filter ini</p></td></tr>` :
            `<tr><td colspan="5" class="text-center py-4"><i class="bi bi-inbox display-4 text-muted"></i><p class="mt-2">Belum ada data absensi</p><a href="{{ route('scan.index') }}" class="btn btn-success btn-sm" target="_blank"><i class="bi bi-qr-code-scan me-1"></i>Mulai Scan</a></td></tr>`;
        tbody.innerHTML = emptyMessage;
        return;
    }

    let html = '';
    displayData.forEach((absen, index) => {
        const badgeClass = absen.status === 'tepat_waktu' ? 'success' : 'warning';
        html += `
            <tr>
                <td>${index + 1}</td>
                <td><strong>${absen.peserta_nama}</strong></td>
                <td>${absen.peserta_jabatan || '-'}</td>
                <td>${absen.waktu_absen || '-'}</td>
                <td>
                    <span class="badge bg-${badgeClass}">
                        ${absen.status_text || 'Belum Hadir'}
                    </span>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function filterData(filterType) {
    currentFilter = filterType;
    
    // Update visual feedback
    document.querySelectorAll('.filter-card').forEach(card => {
        card.style.boxShadow = '';
    });
    
    const activeCard = document.querySelector(`[data-filter="${filterType}"]`);
    if (activeCard) {
        activeCard.style.boxShadow = '0 0 15px rgba(255,255,255,0.5)';
    }
    
    // Show filter controls
    const filterControls = document.getElementById('filterControls');
    if (filterControls) {
        filterControls.style.display = 'block';
        
        const filterStatus = document.getElementById('filterStatus');
        if (filterType === 'terlambat') {
            filterStatus.textContent = 'Menampilkan peserta yang terlambat';
        } else if (filterType === 'belum-hadir') {
            filterStatus.textContent = 'Menampilkan peserta yang belum hadir';
        }
    }
    
    // Apply filter to current data
    updateTable(allAbsensis);
}

function clearFilter() {
    currentFilter = null;
    
    // Remove visual feedback
    document.querySelectorAll('.filter-card').forEach(card => {
        card.style.boxShadow = '';
    });
    
    // Hide filter controls
    const filterControls = document.getElementById('filterControls');
    if (filterControls) {
        filterControls.style.display = 'none';
    }
    
    // Show all data
    updateTable(allAbsensis);
}

function applyFilter(absensis) {
    if (!currentFilter) return absensis;
    
    if (currentFilter === 'terlambat') {
        return absensis.filter(absen => absen.status === 'terlambat');
    } else if (currentFilter === 'belum-hadir') {
        // Show people who haven't attended
        const attendedIds = absensis.map(absen => absen.peserta_id);
        const belumHadirPesertas = allPesertas.filter(peserta => !attendedIds.includes(peserta.id));
        
        return belumHadirPesertas.map(peserta => ({
            peserta_nama: peserta.nama,
            peserta_jabatan: peserta.jabatan,
            waktu_absen: null,
            status: 'belum_hadir',
            status_text: 'Belum Hadir',
            peserta_id: peserta.id
        }));
    }
    
    return absensis;
}

window.addEventListener('beforeunload', function() {
    if (refreshInterval) clearInterval(refreshInterval);
});
</script>
@endpush