@extends('layouts.admin')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Kegiatan Baru</h1>
    <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-calendar-plus me-2"></i>Form Tambah Kegiatan</h5>
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

                <form action="{{ route('kegiatan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="{{ old('nama') }}" placeholder="Contoh: Rapat Bulanan, Training, dll" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                   value="{{ old('tanggal') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" 
                                   value="{{ old('jam_mulai') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="jam_batas_tepat" class="form-label">Batas Tepat Waktu <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="jam_batas_tepat" name="jam_batas_tepat" 
                                   value="{{ old('jam_batas_tepat') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" 
                               value="{{ old('lokasi') }}" placeholder="Contoh: Ruang Meeting, Aula, dll">
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Deskripsi atau catatan tambahan kegiatan (opsional)">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Kegiatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection