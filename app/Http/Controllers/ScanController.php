<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Kegiatan;
use App\Models\Peserta;
use App\Models\Absensi;

class ScanController extends Controller
{
    public function index()
    {
        // Mengambil semua kegiatan yang belum lewat tanggal
        $kegiatans = Kegiatan::whereDate('tanggal', '>=', Carbon::today())
                            ->orderBy('tanggal', 'asc')
                            ->get();

        return view('scan', compact('kegiatans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'uid' => 'required|string',
            'kegiatan_id' => 'required|exists:kegiatans,id'
        ]);

        $uid = $request->uid;
        $kegiatanId = $request->kegiatan_id;

        // Cari peserta berdasarkan uid
        $peserta = Peserta::where('uid', $uid)->first();
        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta dengan UID tersebut tidak ditemukan!');
        }

        // Cek duplicate absensi
        $existingAbsensi = Absensi::where('peserta_id', $peserta->id)
                                 ->where('kegiatan_id', $kegiatanId)
                                 ->first();
        
        if ($existingAbsensi) {
            return redirect()->back()->with('error', 'Peserta ' . $peserta->nama . ' sudah melakukan absensi untuk kegiatan ini!');
        }

        // Ambil data kegiatan
        $kegiatan = Kegiatan::findOrFail($kegiatanId);

        // Hitung status tepat waktu atau telat
        $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('Y-m-d') : $kegiatan->tanggal;
        
        try {
            // Coba parse dengan format lengkap Y-m-d H:i:s
            $batasWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $tanggalKegiatan . ' ' . $kegiatan->jam_batas_tepat);
        } catch (\Exception $e) {
            // Jika gagal, coba dengan format Y-m-d H:i
            $batasWaktu = Carbon::createFromFormat('Y-m-d H:i', $tanggalKegiatan . ' ' . substr($kegiatan->jam_batas_tepat, 0, 5));
        }
        
        $waktuAbsen = Carbon::now();
        $status = $waktuAbsen->lte($batasWaktu) ? 'tepat_waktu' : 'telat';

        // Simpan absensi
        $absensi = Absensi::create([
            'peserta_id' => $peserta->id,
            'kegiatan_id' => $kegiatanId,
            'uid' => $uid,
            'waktu_absen' => $waktuAbsen,
            'status' => $status
        ]);

        // Logging
        Log::info('Absensi berhasil', [
            'peserta_id' => $peserta->id,
            'peserta_nama' => $peserta->nama,
            'kegiatan_id' => $kegiatanId,
            'kegiatan_nama' => $kegiatan->nama,
            'status' => $status,
            'waktu_absen' => $waktuAbsen->format('Y-m-d H:i:s')
        ]);

        $statusText = $status === 'tepat_waktu' ? 'TEPAT WAKTU' : 'TERLAMBAT';
        
        return redirect()->back()->with('success', 'Absensi berhasil! Peserta: ' . $peserta->nama . ' - Status: ' . $statusText);
    }
}
