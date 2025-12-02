@extends('layouts.admin')

@section('title', 'Kelola Peserta')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Peserta</h1>
    <a href="{{ route('peserta.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Tambah Peserta
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
        @if($pesertas->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>UID</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Terdaftar</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesertas as $peserta)
                        <tr>
                            <td><code>{{ $peserta->uid }}</code></td>
                            <td>{{ $peserta->nama }}</td>
                            <td>{{ $peserta->jabatan ?? '-' }}</td>
                            <td>{{ $peserta->created_at instanceof \Carbon\Carbon ? $peserta->created_at->format('d/m/Y') : date('d/m/Y', strtotime($peserta->created_at)) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('peserta.edit', $peserta) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('peserta.destroy', $peserta) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus peserta {{ $peserta->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
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

            {{ $pesertas->links() }}
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