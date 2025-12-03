@extends('layouts.admin')

@section('title', 'Kelola Peserta')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Peserta</h1>
    <div>
        <a href="{{ route('peserta.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-2"></i>Tambah Peserta
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($pesertas->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 120px;">UID</th>
                            <th style="min-width: 150px;">Nama</th>
                            <th style="min-width: 100px;">NIM</th>
                            <th style="min-width: 120px;">Fakultas</th>
                            <th style="min-width: 120px;">Jabatan</th>
                            <th style="min-width: 100px;">Terdaftar</th>
                            <th style="width: 120px; min-width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesertas as $peserta)
                        <tr>
                            <td>
                                @if($peserta->uid)
                                    <code>{{ $peserta->uid }}</code>
                                @else
                                    <span class="text-muted fst-italic">Belum ada UID</span>
                                @endif
                            </td>
                            <td>{{ $peserta->nama }}</td>
                            <td><code>{{ $peserta->nim ?? '-' }}</code></td>
                            <td>{{ $peserta->fakultas ?? '-' }}</td>
                            <td>{{ $peserta->jabatan ?? '-' }}</td>
                            <td>{{ $peserta->created_at instanceof \Carbon\Carbon ? $peserta->created_at->format('d/m/Y') : date('d/m/Y', strtotime($peserta->created_at)) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('peserta.edit', $peserta) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Edit Peserta">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('peserta.destroy', $peserta) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus peserta {{ $peserta->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus Peserta">
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
                {{ $pesertas->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people display-1 text-muted"></i>
                <h4 class="mt-3">Belum ada peserta</h4>
                <p class="text-muted">Silakan tambah peserta untuk memulai sistem absensi</p>
                <a href="{{ route('peserta.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus me-2"></i>Tambah Peserta Pertama
                </a>
            </div>
        @endif
    </div>
</div>


@endsection