<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Scan Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .scan-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .scan-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        #uidInput {
            opacity: 0;
            position: absolute;
            left: -9999px;
        }
        .scan-status {
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .device-info {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="scan-container d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="scan-card p-4">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="text-center flex-grow-1">
                                <i class="bi bi-qr-code-scan display-4 text-primary"></i>
                                <h3 class="mt-2">Admin Scan Absensi</h3>
                                <div class="device-info">
                                    Device: <span id="deviceName">{{ request()->cookie('device_name', 'Unknown') }}</span>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="setDeviceName()">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Logout">
                                        <i class="bi bi-box-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger" id="errorAlert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                @foreach($errors->all() as $error)
                                    {{ $error }}@if(!$loop->last)<br>@endif
                                @endforeach
                            </div>
                        @endif

                        <!-- Form -->
                        <form id="scanForm" action="{{ route('scan.store') }}" method="POST">
                            @csrf
                            
                            <!-- Dropdown Kegiatan -->
                            <div class="mb-4">
                                <label for="kegiatan_id" class="form-label fw-bold">Pilih Kegiatan:</label>
                                <select class="form-select form-select-lg" id="kegiatan_id" name="kegiatan_id" required>
                                    <option value="">-- Pilih Kegiatan --</option>
                                    @foreach($kegiatans as $kegiatan)
                                        <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>
                                            {{ $kegiatan->nama }} - {{ $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($kegiatan->tanggal)) }} ({{ $kegiatan->jam_mulai }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hidden UID Input -->
                            <input type="text" id="uidInput" name="uid" autocomplete="off">
                            
                            <!-- Hidden Device Name -->
                            <input type="hidden" name="device_name" id="deviceNameInput">

                            <!-- Scan Status -->
                            <div class="scan-status">
                                <div id="scanStatus" class="text-center">
                                    <div id="waitingMessage" style="display: none;">
                                        <div class="pulse">
                                            <i class="bi bi-credit-card display-1 text-success"></i>
                                            <p class="mt-2 text-success fw-bold">Siap menerima scan kartu...</p>
                                            <a href="" id="monitorLink" class="btn btn-outline-info btn-sm mt-2" style="display: none;">
                                                <i class="bi bi-tv me-1"></i>Lihat Monitor Real-time
                                            </a>
                                        </div>
                                    </div>
                                    <div id="selectKegiatanMessage">
                                        <i class="bi bi-arrow-up-circle display-1 text-warning"></i>
                                        <p class="mt-2 text-warning">Silakan pilih kegiatan terlebih dahulu</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Manual Submit Button (Hidden by default) -->
                            <div class="d-grid mt-3" id="manualSubmit" style="display: none;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Submit Manual
                                </button>
                            </div>
                        </form>

                        <!-- Info Kegiatan -->
                        @if($kegiatans->count() > 0)
                        <div class="mt-4">
                            <h6 class="text-muted">Kegiatan Hari Ini:</h6>
                            <div class="small">
                                @foreach($kegiatans->take(3) as $kegiatan)
                                <div class="d-flex justify-content-between border-bottom py-1">
                                    <span>{{ $kegiatan->nama }}</span>
                                    <span class="text-muted">{{ $kegiatan->jam_mulai }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Audio notifications
        const successSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmgfCCJ+zPLZiDgIDWS57+OZVA0PVqzn8bllHgg2jdXzzn0vBSF0xe/eizELElyx6OyrWBUIQ5zd8sFuIAUuhM/z24k2CRZiturqnVITC0ml4PK8aB4IMo/W8tGAMQYfcsLu45hSEQpRp+Xxu2kjBi+BzvPajjkJFGC16+OdUhIMUqPi8L5qIAcuhM7z3Yo3CRdiu+zmnVMSC0qj4PG9aCAGLYPO8tyJNgkVYbXs450SE...');
        const errorSound = new Audio('data:audio/wav;base64,UklGRmwBAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YSABAAABBR1bnMDYJRm3Yl5Y/7VdEPmYuUj8y2ZD/M8IQAL+TCM+B/HQWjD4v1E//NSjNf/RwqP+0bJ3/N1LMv/G3xv8zYct/c2PPf7JN0b+yVY1/c9OM//Tqyj//z4C//4wA//8OAPM/8r1TP/JaUL+z1g2/c/CL//WpCb/zzQO//8pCP/8QwD/2Z8j/8tePP7UcCz/25gd/0c8+f7Vhyb/yWg8/ss9Av/9KQL/31wW/9GILD...');

        let isFormReady = false;

        document.addEventListener('DOMContentLoaded', function() {
            const kegiatanSelect = document.getElementById('kegiatan_id');
            const uidInput = document.getElementById('uidInput');
            const scanForm = document.getElementById('scanForm');
            const waitingMessage = document.getElementById('waitingMessage');
            const selectKegiatanMessage = document.getElementById('selectKegiatanMessage');
            const deviceNameInput = document.getElementById('deviceNameInput');

            // Set device name from cookie
            deviceNameInput.value = getCookie('device_name') || 'Unknown Device';

            // Handle kegiatan selection
            kegiatanSelect.addEventListener('change', function() {
                if (this.value) {
                    isFormReady = true;
                    waitingMessage.style.display = 'block';
                    selectKegiatanMessage.style.display = 'none';
                    
                    // Show monitor link
                    const monitorLink = document.getElementById('monitorLink');
                    monitorLink.href = `/monitor?kegiatan_id=${this.value}`;
                    monitorLink.style.display = 'inline-block';
                    
                    focusUidInput();
                } else {
                    isFormReady = false;
                    waitingMessage.style.display = 'none';
                    selectKegiatanMessage.style.display = 'block';
                    
                    // Hide monitor link
                    document.getElementById('monitorLink').style.display = 'none';
                }
            });

            // Handle UID input
            uidInput.addEventListener('input', function() {
                if (isFormReady && this.value.length > 3) {
                    // Auto submit when UID is scanned
                    setTimeout(() => {
                        if (this.value.length > 3) {
                            scanForm.submit();
                        }
                    }, 100);
                }
            });

            // Maintain focus on UID input
            function focusUidInput() {
                if (isFormReady) {
                    uidInput.focus();
                }
            }

            // Keep focus on UID input
            document.addEventListener('click', focusUidInput);
            document.addEventListener('keydown', function(e) {
                if (isFormReady && e.target !== uidInput) {
                    uidInput.focus();
                }
            });

            // Focus when page loads if kegiatan is already selected
            if (kegiatanSelect.value) {
                isFormReady = true;
                waitingMessage.style.display = 'block';
                selectKegiatanMessage.style.display = 'none';
                focusUidInput();
            }

            // Clear UID input after success/error
            @if(session('success'))
                playSuccessSound();
                setTimeout(function() {
                    uidInput.value = '';
                    focusUidInput();
                }, 2000);
            @endif

            @if(session('error') || $errors->any())
                playErrorSound();
                setTimeout(function() {
                    uidInput.value = '';
                    focusUidInput();
                }, 2000);
            @endif

            // Prevent form submission if not ready
            scanForm.addEventListener('submit', function(e) {
                if (!isFormReady || !uidInput.value.trim()) {
                    e.preventDefault();
                    return false;
                }
            });
        });

        function playSuccessSound() {
            successSound.play().catch(e => console.log('Could not play success sound'));
        }

        function playErrorSound() {
            errorSound.play().catch(e => console.log('Could not play error sound'));
        }

        function setDeviceName() {
            const currentName = getCookie('device_name') || 'Unknown Device';
            const newName = prompt('Masukkan nama device/laptop:', currentName);
            if (newName && newName.trim()) {
                setCookie('device_name', newName.trim(), 365);
                document.getElementById('deviceName').textContent = newName.trim();
                document.getElementById('deviceNameInput').value = newName.trim();
            }
        }

        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
        }

        function getCookie(name) {
            return document.cookie.split('; ').reduce((r, v) => {
                const parts = v.split('=');
                return parts[0] === name ? decodeURIComponent(parts[1]) : r;
            }, '');
        }
    </script>
</body>
</html>