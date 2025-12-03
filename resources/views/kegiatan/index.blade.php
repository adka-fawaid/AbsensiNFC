@extends('layouts.admin')

@section('title', 'Kelola Kegiatan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Kegiatan</h1>
    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">
        <i class="bi bi-calendar-plus me-2"></i>Tambah Kegiatan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($kegiatans->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Nama Kegiatan</th>
                            <th style="min-width: 100px;">Tanggal</th>
                            <th style="min-width: 120px;">Jam</th>
                            <th style="min-width: 120px;">Lokasi</th>
                            <th style="min-width: 100px;">Status</th>
                            <th style="width: 120px; min-width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatans as $kegiatan)
                        <tr>
                            <td>
                                <strong>{{ $kegiatan->nama }}</strong>
                                @if($kegiatan->keterangan)
                                    <br><small class="text-muted">{{ Str::limit($kegiatan->keterangan, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($kegiatan->tanggal)) }}</td>
                            <td>
                                {{ $kegiatan->jam_mulai }}<br>
                                <small class="text-muted">Batas: {{ $kegiatan->jam_batas_tepat }}</small>
                            </td>
                            <td>{{ $kegiatan->lokasi ?? '-' }}</td>
                            <td>
                                @php
                                    $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('Y-m-d') : $kegiatan->tanggal;
                                    $today = now()->format('Y-m-d');
                                @endphp
                                @if($tanggalKegiatan < $today)
                                    <span class="badge bg-secondary">Selesai</span>
                                @elseif($tanggalKegiatan == $today)
                                    <span class="badge bg-success">Hari Ini</span>
                                @else
                                    <span class="badge bg-primary">Mendatang</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('kegiatan.edit', $kegiatan) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Edit Kegiatan">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kegiatan {{ $kegiatan->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus Kegiatan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $kegiatans->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <h4 class="mt-3">Belum ada kegiatan</h4>
                <p class="text-muted">Silakan tambah kegiatan untuk memulai sistem absensi</p>
                <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">
                    <i class="bi bi-calendar-plus me-2"></i>Tambah Kegiatan Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection