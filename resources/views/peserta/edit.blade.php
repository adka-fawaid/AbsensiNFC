@extends('layouts.admin')

@section('title', 'Edit Peserta')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Peserta</h1>
    <a href="{{ route('peserta.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-pencil me-2"></i>Form Edit Peserta</h5>
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

                <form action="{{ route('peserta.update', $pesertum) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="uid" class="form-label">UID Peserta</label>
                        <input type="text" class="form-control" id="uid" name="uid" 
                               value="{{ old('uid', $pesertum->uid) }}" placeholder="UID peserta (bisa dikosongkan)">
                        <div class="form-text">Unique ID yang tercetak di kartu atau tag RFID. Bisa dikosongkan dulu</div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="{{ old('nama', $pesertum->nama) }}" placeholder="Nama lengkap" required>
                    </div>

                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nim" name="nim" 
                               value="{{ old('nim', $pesertum->nim) }}" placeholder="Nomor Induk Mahasiswa" required>
                        <div class="form-text">Nomor Induk Mahasiswa yang unik</div>
                    </div>

                    <div class="mb-3">
                        <label for="fakultas" class="form-label">Fakultas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" 
                               value="{{ old('fakultas', $pesertum->fakultas) }}" placeholder="Nama fakultas atau jurusan" required>
                        <div class="form-text">Nama fakultas atau jurusan</div>
                    </div>

                    <div class="mb-4">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" 
                               value="{{ old('jabatan', $pesertum->jabatan) }}" placeholder="Jabatan (opsional)">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('peserta.index') }}" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Update Peserta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection