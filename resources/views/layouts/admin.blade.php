<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - BEM UDINUS | Sistem Absensi Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .dashboard-card {
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .sidebar {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .nav-link.active {
            background: #007bff;
            color: white !important;
        }
        
        /* Fix untuk button yang terpotong */
        .btn-group-sm > .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            min-width: 40px;
            text-align: center;
        }
        
        /* Pastikan table responsive berfungsi dengan baik */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Fix untuk action buttons di mobile */
        @media (max-width: 768px) {
            .btn-group {
                display: flex;
                flex-wrap: nowrap;
            }
            
            .btn-group .btn {
                flex-shrink: 0;
                min-width: 35px;
                padding: 0.25rem 0.5rem;
            }
            
            th:last-child,
            td:last-child {
                min-width: 120px;
            }
        }
        
        /* Improve overall spacing */
        .card-body {
            padding: 1.5rem;
        }
        
        /* Better button styling */
        .btn-outline-primary:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Fix pagination styling */
        .pagination {
            margin-bottom: 0;
        }
        
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 0.25rem;
        }
        
        .pagination .page-link:hover {
            z-index: 2;
            color: #0056b3;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
        
        .pagination .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
        
        /* Responsive pagination */
        @media (max-width: 576px) {
            .pagination .page-link {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
                margin: 0 1px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4 p-3">
                        <img src="{{ asset('images/logo-bem.png') }}" alt="Logo BEM" class="img-fluid mb-2" style="max-width: 80px; height: auto;">
                        <h6 class="fw-bold text-primary mb-0">BEM UDINUS</h6>
                        <small class="text-muted">Sistem Absensi Digital</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('peserta.*') ? 'active' : '' }}" href="{{ route('peserta.index') }}">
                                <i class="bi bi-people me-2"></i>Kelola Peserta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}" href="{{ route('kegiatan.index') }}">
                                <i class="bi bi-calendar-event me-2"></i>Kelola Kegiatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('monitor.*') ? 'active' : '' }}" href="{{ route('monitor.index') }}">
                                <i class="bi bi-tv me-2"></i>Monitor Absensi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('scan.*') ? 'active' : '' }}" href="{{ route('scan.index') }}" target="_blank">
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
                @yield('content')
                
                <!-- Footer -->
                <footer class="mt-5 py-3 border-top">
                    <div class="text-center text-muted">
                        <small>&copy; {{ date('Y') }} Kementerian Kreativitas dan Inovasi BEM Keluarga Mahasiswa Universitas Dian Nuswantoro. All rights reserved.</small>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>