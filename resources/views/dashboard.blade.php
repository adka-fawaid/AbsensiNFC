<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BEM UDINUS | Sistem Absensi Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .dashboard-card {
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .sidebar {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .nav-link.active {
            background: #007bff;
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <nav class="navbar navbar-expand-md navbar-light bg-light d-md-none">
        <div class="container-fluid">
            <span class="navbar-brand">
                <img src="{{ asset('images/logo-bem.png') }}" alt="Logo BEM" style="width: 30px; height: 30px;" class="me-2">BEM UDINUS
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Mobile Sidebar -->
            <div class="col-12 d-md-none">
                <div class="collapse navbar-collapse" id="mobileSidebar">
                    <div class="bg-light p-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('peserta.index') }}">
                                    <i class="bi bi-people me-2"></i>Kelola Peserta
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kegiatan.index') }}">
                                    <i class="bi bi-calendar-event me-2"></i>Kelola Kegiatan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('monitor.index') }}">
                                    <i class="bi bi-tv me-2"></i>Monitor Absensi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('scan.index') }}" target="_blank">
                                    <i class="bi bi-qr-code-scan me-2"></i>Halaman Scan
                                </a>
                            </li>
                            <li class="nav-item mt-2">
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Desktop Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                        <img src="{{ asset('images/logo-bem.png') }}" alt="Logo BEM" style="width: 100px; height: 120px;" >
                        <h5>BEM</h5>
                    </div>                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('peserta.index') }}">
                                <i class="bi bi-people me-2"></i>Kelola Peserta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kegiatan.index') }}">
                                <i class="bi bi-calendar-event me-2"></i>Kelola Kegiatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('monitor.index') }}">
                                <i class="bi bi-tv me-2"></i>Monitor Absensi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('scan.index') }}" target="_blank">
                                <i class="bi bi-qr-code-scan me-2"></i>Halaman Scan
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div>
                        <span class="text-muted">{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card dashboard-card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-people display-4 mb-3"></i>
                                <h3>{{ $totalPeserta }}</h3>
                                <p class="mb-0">Total Peserta</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card dashboard-card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-event display-4 mb-3"></i>
                                <h3>{{ $totalKegiatan }}</h3>
                                <p class="mb-0">Total Kegiatan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card dashboard-card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-check-circle display-4 mb-3"></i>
                                <h3>{{ $totalAbsensi }}</h3>
                                <p class="mb-0">Total Absensi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card dashboard-card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-day display-4 mb-3"></i>
                                <h3>{{ $kegiatanHariIni }}</h3>
                                <p class="mb-0">Kegiatan Hari Ini</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="card dashboard-card h-100">
                            <div class="card-header">
                                <h5><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('peserta.create') }}" class="btn btn-primary">
                                        <i class="bi bi-person-plus me-2"></i>Tambah Peserta Baru
                                    </a>
                                    <a href="{{ route('kegiatan.create') }}" class="btn btn-success">
                                        <i class="bi bi-calendar-plus me-2"></i>Tambah Kegiatan Baru
                                    </a>
                                    <a href="{{ route('monitor.index') }}" class="btn btn-warning">
                                        <i class="bi bi-tv me-2"></i>Monitor & Scan Absensi
                                    </a>
                                    <a href="{{ route('monitor.index') }}" class="btn btn-info">
                                        <i class="bi bi-tv me-2"></i>Monitor Real-time
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card dashboard-card h-100">
                            <div class="card-header">
                                <h5><i class="bi bi-clock-history me-2"></i>Absensi Terbaru</h5>
                            </div>
                            <div class="card-body">
                                @if($recentAbsensi->count() > 0)
                                    @foreach($recentAbsensi as $absen)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong>{{ $absen->peserta->nama }}</strong><br>
                                            <small class="text-muted">{{ $absen->kegiatan->nama }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $absen->status == 'tepat_waktu' ? 'success' : 'warning' }}">
                                                {{ $absen->status == 'tepat_waktu' ? 'Tepat Waktu' : 'Terlambat' }}
                                            </span><br>
                                            <small class="text-muted">{{ $absen->waktu_absen instanceof \Carbon\Carbon ? $absen->waktu_absen->format('H:i') : date('H:i', strtotime($absen->waktu_absen)) }}</small>
                                        </div>
                                    </div>
                                    @if(!$loop->last) <hr> @endif
                                    @endforeach
                                @else
                                    <div class="text-center text-muted">
                                        <i class="bi bi-inbox display-4"></i>
                                        <p class="mt-2">Belum ada absensi</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>