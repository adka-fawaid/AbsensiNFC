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
        .success-alert {
            animation: successBounce 0.6s ease-out;
        }
        @keyframes successBounce {
            0% { 
                transform: scale(0.3) rotate(-10deg);
                opacity: 0;
            }
            50% { 
                transform: scale(1.1) rotate(2deg);
                opacity: 0.8;
            }
            100% { 
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }
        .success-icon-animate {
            animation: successIcon 0.8s ease-out;
        }
        @keyframes successIcon {
            0% { transform: scale(0); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
        .error-alert {
            animation: errorShake 0.6s ease-out;
        }
        @keyframes errorShake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
    <div class="scan-container d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="scan-card p-4">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="text-center flex-grow-1">
                                <i class="bi bi-qr-code-scan display-4 text-primary" ></i>
                                <h3 class="mt-2">Admin Scan Absensi</h3>
                            </div>
                            <div>
                                @auth('admin')
                                    <!-- Jika sudah login, tampilkan tombol logout -->
                                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Logout">
                                            <i class="bi bi-box-arrow-right"></i>
                                        </button>
                                    </form>
                                @else
                                    <!-- Jika belum login, tampilkan tombol login -->
                                    <a href="{{ route('admin.login.form') }}" class="btn btn-sm" title="Login Admin">
                                        <i class="bi bi-person-circle"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show success-alert" role="alert" id="successAlert" style="background: linear-gradient(45deg, #28a745, #20c997); border: 3px solid #28a745; color: white; font-weight: bold; font-size: 1.2rem; box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); border-radius: 15px;">
                                <div class="text-center">
                                    <i class="bi bi-check-circle-fill success-icon-animate me-2" style="font-size: 2rem; color: #fff;"></i>
                                    <div class="mt-1">
                                        {{ session('success') }}
                                    </div>
                                    <div class="mt-2">
                                        <i class="bi bi-emoji-smile-fill" style="font-size: 1.2rem;"></i>
                                        <small class="d-block opacity-90">Absensi berhasil dicatat pada {{ now()->format('H:i:s') }}</small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show error-alert" role="alert" id="errorAlert" style="background: linear-gradient(45deg, #dc3545, #e74c3c); border: 3px solid #dc3545; color: white; font-weight: bold; font-size: 1.1rem; box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4); border-radius: 15px;">
                                <div class="text-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.8rem;"></i>
                                    <div class="mt-1">
                                        {{ session('error') }}
                                    </div>
                                    <div class="mt-2">
                                        <i class="bi bi-info-circle"></i>
                                        <small class="d-block opacity-90">Scan berulang terdeteksi pada {{ now()->format('H:i:s') }}</small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
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
                            
                            <!-- Dropdown Kegiatan (Initial Selection) -->
                            <div class="mb-4" id="kegiatanSelectionDiv">
                                <label for="kegiatan_id" class="form-label fw-bold">Pilih Kegiatan:</label>
                                <select class="form-select form-select-lg" id="kegiatan_id" name="kegiatan_id" required>
                                    <option value="">-- Pilih Kegiatan --</option>
                                    @foreach($kegiatans as $kegiatan)
                                        <option value="{{ $kegiatan->id }}" data-nama="{{ $kegiatan->nama }}" data-tanggal="{{ $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($kegiatan->tanggal)) }}" data-jam="{{ $kegiatan->jam_mulai }}" data-batas="{{ $kegiatan->jam_batas_tepat }}">
                                            {{ $kegiatan->nama }} - {{ $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($kegiatan->tanggal)) }} ({{ $kegiatan->jam_mulai }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kegiatan Info (After Selection) -->
                            <div class="mb-4" id="kegiatanInfoDiv" style="display: none;">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-calendar-event me-2"></i>
                                            <strong id="selectedKegiatanNama">Kegiatan</strong>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-light" onclick="changeKegiatan()">
                                            <i class="bi bi-pencil"></i> Ganti
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <i class="bi bi-calendar3 text-primary"></i>
                                                <div class="small text-muted">Tanggal</div>
                                                <strong id="selectedKegiatanTanggal">-</strong>
                                            </div>
                                            <div class="col-4">
                                                <i class="bi bi-clock text-success"></i>
                                                <div class="small text-muted">Jam Mulai</div>
                                                <strong id="selectedKegiatanJam">-</strong>
                                            </div>
                                            <div class="col-4">
                                                <i class="bi bi-stopwatch text-warning"></i>
                                                <div class="small text-muted">Batas Tepat Waktu</div>
                                                <strong id="selectedKegiatanBatas">-</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                        </div>
                                    </div>
                                    <div id="selectKegiatanMessage">
                                        <i class="bi bi-arrow-up-circle display-1 text-warning"></i>
                                        <p class="mt-2 text-warning">Silakan pilih kegiatan terlebih dahulu</p>
                                    </div>
                                </div>
                            </div>


                        </form>

                        <!-- Riwayat Absensi -->
                        <div class="mt-4" id="attendanceHistory">
                            <h6 class="text-muted">Riwayat Peserta Hadir:</h6>
                            <div class="small" id="attendanceList">
                                <p class="text-muted text-center py-2">Pilih kegiatan untuk melihat riwayat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
                    // Save selection to localStorage
                    localStorage.setItem('selected_kegiatan_id', this.value);
                    
                    // Get selected option data
                    const selectedOption = this.selectedOptions[0];
                    const nama = selectedOption.getAttribute('data-nama');
                    const tanggal = selectedOption.getAttribute('data-tanggal');
                    const jam = selectedOption.getAttribute('data-jam');
                    const batas = selectedOption.getAttribute('data-batas');
                    
                    // Update info display
                    document.getElementById('selectedKegiatanNama').textContent = nama;
                    document.getElementById('selectedKegiatanTanggal').textContent = tanggal;
                    document.getElementById('selectedKegiatanJam').textContent = jam;
                    document.getElementById('selectedKegiatanBatas').textContent = batas;
                    
                    // Hide dropdown, show info
                    document.getElementById('kegiatanSelectionDiv').style.display = 'none';
                    document.getElementById('kegiatanInfoDiv').style.display = 'block';
                    
                    isFormReady = true;
                    waitingMessage.style.display = 'block';
                    selectKegiatanMessage.style.display = 'none';
                    
                    // Load attendance history
                    loadAttendanceHistory(this.value);
                    
                    focusUidInput();
                } else {
                    // Remove from localStorage
                    localStorage.removeItem('selected_kegiatan_id');
                    
                    // Show dropdown, hide info
                    document.getElementById('kegiatanSelectionDiv').style.display = 'block';
                    document.getElementById('kegiatanInfoDiv').style.display = 'none';
                    
                    isFormReady = false;
                    waitingMessage.style.display = 'none';
                    selectKegiatanMessage.style.display = 'block';
                    
                    // Clear attendance history
                    document.getElementById('attendanceList').innerHTML = '<p class="text-muted text-center py-2">Pilih kegiatan untuk melihat riwayat</p>';
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

            // Restore selection from localStorage or session
            const sessionKegiatan = '{{ session("selected_kegiatan") }}';
            const savedKegiatan = localStorage.getItem('selected_kegiatan_id') || sessionKegiatan;
            
            if (savedKegiatan && savedKegiatan !== '') {
                kegiatanSelect.value = savedKegiatan;
                // Trigger change event to update display
                kegiatanSelect.dispatchEvent(new Event('change'));
            }
            
            // Focus when page loads if kegiatan is already selected
            else if (kegiatanSelect.value) {
                kegiatanSelect.dispatchEvent(new Event('change'));
            }

            // Clear UID input after success/error
            @if(session('success'))
                playSuccessSound();
                
                // Add celebratory effect
                setTimeout(function() {
                    // Flash green background
                    document.body.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                    setTimeout(function() {
                        document.body.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    }, 500);
                }, 100);
                
                // Auto-hide success alert after 5 seconds
                setTimeout(function() {
                    const successAlert = document.getElementById('successAlert');
                    if (successAlert) {
                        successAlert.style.transition = 'opacity 0.5s ease-out';
                        successAlert.style.opacity = '0';
                        setTimeout(function() {
                            successAlert.remove();
                        }, 500);
                    }
                }, 5000);
                
                // Refresh attendance history if kegiatan selected
                if (kegiatanSelect.value) {
                    loadAttendanceHistory(kegiatanSelect.value);
                }
                setTimeout(function() {
                    uidInput.value = '';
                    focusUidInput();
                }, 2000);
            @endif

            @if(session('error') || $errors->any())
                playErrorSound();
                
                // Add warning effect
                setTimeout(function() {
                    // Flash red background briefly
                    document.body.style.background = 'linear-gradient(135deg, #dc3545 0%, #e74c3c 100%)';
                    setTimeout(function() {
                        document.body.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    }, 300);
                }, 100);
                
                // Auto-hide error alert after 4 seconds
                setTimeout(function() {
                    const errorAlert = document.getElementById('errorAlert');
                    if (errorAlert) {
                        errorAlert.style.transition = 'opacity 0.5s ease-out';
                        errorAlert.style.opacity = '0';
                        setTimeout(function() {
                            errorAlert.remove();
                        }, 500);
                    }
                }, 4000);
                
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

        function loadAttendanceHistory(kegiatanId) {
            const attendanceList = document.getElementById('attendanceList');
            attendanceList.innerHTML = '<p class="text-muted text-center py-2"><i class="bi bi-arrow-clockwise"></i> Loading...</p>';
            
            fetch(`/scan/attendance-history/${kegiatanId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(attendance => {
                            const badgeClass = attendance.status === 'tepat_waktu' ? 'bg-success' : 'bg-warning';
                            const statusText = attendance.status === 'tepat_waktu' ? 'Tepat Waktu' : 'Terlambat';
                            html += `
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                    <div>
                                        <strong>${attendance.peserta.nama}</strong>
                                        <small class="text-muted d-block">${attendance.waktu_absen}</small>
                                    </div>
                                    <span class="badge ${badgeClass}">${statusText}</span>
                                </div>
                            `;
                        });
                        attendanceList.innerHTML = html;
                    } else {
                        attendanceList.innerHTML = '<p class="text-muted text-center py-2">Belum ada peserta yang hadir</p>';
                    }
                })
                .catch(error => {
                    console.error('Error loading attendance history:', error);
                    attendanceList.innerHTML = '<p class="text-muted text-center py-2">Error loading data</p>';
                });
        }

        function changeKegiatan() {
            // Clear localStorage
            localStorage.removeItem('selected_kegiatan_id');
            
            // Reset dropdown
            document.getElementById('kegiatan_id').value = '';
            
            // Show dropdown, hide info
            document.getElementById('kegiatanSelectionDiv').style.display = 'block';
            document.getElementById('kegiatanInfoDiv').style.display = 'none';
            
            // Reset scan state
            isFormReady = false;
            document.getElementById('waitingMessage').style.display = 'none';
            document.getElementById('selectKegiatanMessage').style.display = 'block';
            
            // Clear attendance history
            document.getElementById('attendanceList').innerHTML = '<p class="text-muted text-center py-2">Pilih kegiatan untuk melihat riwayat</p>';
        }


    </script>
</body>
</html>