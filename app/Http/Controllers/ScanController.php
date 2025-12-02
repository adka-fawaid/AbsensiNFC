<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Kegiatan;
use App\Models\Peserta;
use App\Models\Absensi;

/**
 * Controller untuk mengelola proses scanning NFC dan absensi.
 * 
 * Menangani pembacaan UID kartu NFC, validasi peserta,
 * pencatatan absensi, dan mencegah duplikasi absensi.
 * 
 * @package App\Http\Controllers
 * @author Sistem Absensi NFC
 * @version 1.0.0
 */
class ScanController extends Controller
{
    /**
     * Menampilkan halaman scan absensi dengan daftar kegiatan aktif.
     * 
     * @return \Illuminate\View\View
     */
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

        // Ambil data kegiatan dulu untuk keperluan notifikasi
        $kegiatan = Kegiatan::findOrFail($kegiatanId);

        // Cek duplicate absensi
        $existingAbsensi = Absensi::where('peserta_id', $peserta->id)
                                 ->where('kegiatan_id', $kegiatanId)
                                 ->first();
        
        if ($existingAbsensi) {
            return redirect()->route('scan.index')->with([
                'error' => 'Peserta ' . $peserta->nama . ' sudah absen di kegiatan ' . $kegiatan->nama,
                'selected_kegiatan' => $kegiatanId
            ]);
        }

        // Kegiatan sudah diambil di atas

        // Hitung status tepat waktu atau telat
        $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('Y-m-d') : $kegiatan->tanggal;
        
        // Format jam_batas_tepat dengan robust parsing
        $jamBatas = $kegiatan->jam_batas_tepat;
        // Pastikan format HH:MM
        if (strlen($jamBatas) == 5) {
            $jamBatas = $jamBatas . ':00'; // Tambah detik jika tidak ada
        } elseif (strlen($jamBatas) == 8) {
            // Sudah format HH:MM:SS
        } else {
            // Default ke format yang aman
            $jamBatas = '07:00:00';
        }
        
        try {
            $batasWaktu = Carbon::parse($tanggalKegiatan . ' ' . $jamBatas, 'Asia/Jakarta');
        } catch (\Exception $e) {
            // Fallback parsing
            $batasWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $tanggalKegiatan . ' ' . $jamBatas, 'Asia/Jakarta');
        }
        
        $waktuAbsen = Carbon::now('Asia/Jakarta');
        

        
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

        return redirect()->route('scan.index')->with([
            'success' => 'Terimakasih ' . $peserta->nama . ' sudah absen!!',
            'selected_kegiatan' => $kegiatanId
        ]);
    }

    public function attendanceHistory(Kegiatan $kegiatan)
    {
        $attendances = Absensi::with('peserta')
            ->where('kegiatan_id', $kegiatan->id)
            ->orderBy('waktu_absen', 'desc')
            ->limit(10)
            ->get();

        $data = $attendances->map(function($attendance) {
            return [
                'id' => $attendance->id,
                'peserta' => [
                    'nama' => $attendance->peserta->nama
                ],
                'status' => $attendance->status,
                'waktu_absen' => \Carbon\Carbon::parse($attendance->waktu_absen)->format('H:i:s')
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
