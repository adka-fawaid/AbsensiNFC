<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
    @page { margin: 20px 30px; }

    body {
        font-family: 'Times New Roman', serif;
        font-size: 16px;
        margin-top: 200px; /* ruang untuk header */
    }

    /* HEADER FIXED */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 140px;
        text-align: center;
    }

    .header img.logo-left {
        position: absolute;
        left: 25px;
        top: 5px;
        width: 105px;
        height: 105px;
    }

    .header img.logo-right {
        position: absolute;
        right: 25px;
        width: 125px;
        height: 145px;
        bottom: 5px;
    }

    .kop-title {
        font-weight: bold;
        font-size: 16px;
        margin-top: 0;
        padding-top: 5px;
    }

    .kop-sub {
        font-size: 16px;
        margin-top: 3px;
        line-height: 1.2;
    }

    .line {
        margin-top: 5px;
        border-bottom: 2px solid black;
        width: 100%;
    }

    .pdf-title {
        text-align: center;
        margin-top: 8px;
        font-weight: bold;
        font-size: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th, table td {
        border: 1px solid black;
        padding: 6px 4px;
        vertical-align: middle;
    }

    table th {
        text-align: center;
        font-weight: bold;
        background-color: #f5f5f5;
        font-size: 14px;
    }
    
    table td {
        font-size: 14px;
    }
    
    .ttd-col {
        height: 25px;
    }
</style>

</head>
<body>

<!-- HEADER (AKAN REPEAT) -->
<div class="header">

    <!-- LOGO KIRI -->
    <img src="{{ public_path('images/logo-udinus.png') }}" class="logo-left">

    <!-- LOGO KANAN -->
    <img src="{{ public_path('images/logo-bem.png') }}" class="logo-right">

    <!-- TULISAN HEADER -->
    <div class="kop-title">
        BADAN EKSEKUTIF MAHASISWA <br>
        KELUARGA MAHASISWA <br>
        UNIVERSITAS DIAN NUSWANTORO
    </div>

    <div class="kop-sub">
        Sekretariat: Kompleks Pusat Kegiatan Mahasiswa F.1.2 <br>
        Jl. Nakula 1 No. 5-11 | Kota Semarang, Jawa Tengah 50131 <br>
        Telp: 0895710034499 | Email: bemkm@orma.dinus.ac.id | Web: bem.dinus.ac.id
    </div>

    <div class="line mb-2"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="pdf-title">
        DAFTAR HADIR <br>
        {{ strtoupper($kegiatan->nama) }} <br>
        {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('Y') }}/{{ \Carbon\Carbon::parse($kegiatan->tanggal)->addYear()->format('Y') }}
    </div>
</div>


<!-- ==== ISI TABEL ==== -->

<table>
    <thead>
        <tr>
            <th style="width:35px;">No.</th>
            <th style="width:140px;">NAMA</th>
            <th style="width:110px;">NIM</th>
            <th style="width:130px;">KEMENTERIAN/BIRO</th>
            <th style="width:80px;">WAKTU HADIR</th>
            <th style="width:60px;">TTD</th>
        </tr>
    </thead>

    <tbody>
        @if($absensis->count() > 0)
            @foreach ($absensis as $i => $a)
            <tr>
                <td style="text-align:center;">{{ $i+1 }}.</td>
                <td>{{ $a->peserta->nama }}</td>
                <td style="text-align:center;">{{ $a->peserta->nim ?? '-' }}</td>
                <td>{{ $a->peserta->jabatan ?? '-' }}</td>
                <td style="text-align:center;">{{ \Carbon\Carbon::parse($a->waktu_absen)->format('H:i:s') }}</td>
                <td class="ttd-col"></td>   
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" style="text-align: center; color: #666;">Belum ada data absensi</td>
            </tr>
        @endif
    </tbody>
</table>

</body>
</html>