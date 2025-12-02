@extends('layouts.admin')

@section('title', 'Tambah Peserta')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Peserta Baru</h1>
    <a href="{{ route('peserta.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-person-plus me-2"></i>Form Tambah Peserta</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li><i class="bi bi-x-circle me-1"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peserta.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="uid" class="form-label">UID Peserta</label>
                        <input type="text" class="form-control" id="uid" name="uid" 
                               value="{{ old('uid') }}" placeholder="UID kartu NFC (bisa dikosongkan dulu)" 
                               autofocus>
                        <div class="form-text">Unique ID yang tercetak di kartu atau tag RFID. Bisa dikosongkan dulu sampai kartu datang</div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nim" name="nim" 
                               value="{{ old('nim') }}" placeholder="Nomor Induk Mahasiswa" required>
                        <div class="form-text">Nomor Induk Mahasiswa yang unik</div>
                    </div>

                    <div class="mb-3">
                        <label for="fakultas" class="form-label">Fakultas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" 
                               value="{{ old('fakultas') }}" placeholder="Contoh: Teknik Informatika, Manajemen" required>
                        <div class="form-text">Nama fakultas atau jurusan</div>
                    </div>

                    <div class="mb-4">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" 
                               value="{{ old('jabatan') }}" placeholder="Contoh: Mahasiswa, Staff, Manager (opsional)">
                        <div class="form-text">Opsional - bisa dikosongkan jika tidak diperlukan</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('peserta.index') }}" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Peserta
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h6><i class="bi bi-info-circle me-2"></i>Tips</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li><strong>UID</strong> harus unik untuk setiap peserta</li>
                    <li>Gunakan <strong>scan kartu RFID</strong> untuk input UID otomatis</li>
                    <li>UID biasanya berupa angka atau kombinasi huruf-angka</li>
                    <li>Pastikan UID sesuai dengan yang tercetak di kartu fisik</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto focus ke input UID dan siap menerima scan
    document.addEventListener('DOMContentLoaded', function() {
        const uidInput = document.getElementById('uid');
        uidInput.focus();
        
        // Keep focus on UID input for easy scanning
        document.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON') {
                uidInput.focus();
            }
        });
    });
</script>
@endpush