<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kegiatan;
use App\Models\Peserta;
use App\Models\Absensi;

/**
 * ScanController
 * 
 * Controller untuk mengelola sistem absensi NFC BEM UDINUS.
 * Menangani scanning kartu NFC, validasi peserta, dan pencatatan absensi.
 */
class ScanController extends Controller
{
    /**
     * Tampilkan halaman scan absensi
     */
    public function index()
    {
        $kegiatans = Kegiatan::whereDate('tanggal', '>=', Carbon::today())
                            ->orderBy('tanggal', 'asc')
                            ->get();

        return view('scan', compact('kegiatans'));
    }

    /**
     * Proses scan absensi NFC
     */
    public function store(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'kegiatan_id' => 'required|exists:kegiatans,id'
        ]);

        $uid = $request->uid;
        $kegiatanId = $request->kegiatan_id;

        $peserta = Peserta::where('uid', $uid)->first();
        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta dengan UID tersebut tidak ditemukan!');
        }

        $kegiatan = Kegiatan::findOrFail($kegiatanId);

        $existingAbsensi = Absensi::where('peserta_id', $peserta->id)
                                 ->where('kegiatan_id', $kegiatanId)
                                 ->first();
        
        if ($existingAbsensi) {
            return $this->handleDuplicateScan($peserta, $kegiatan, $kegiatanId);
        }

        $status = $this->calculateAttendanceStatus($kegiatan);
        
        Absensi::create([
            'peserta_id' => $peserta->id,
            'kegiatan_id' => $kegiatanId,
            'uid' => $uid,
            'waktu_absen' => Carbon::now('Asia/Jakarta'),
            'status' => $status
        ]);

        $this->initializeScanCounter($peserta->id, $kegiatanId);

        return redirect()->route('scan.index')->with([
            'success' => 'Terimakasih ' . $peserta->nama . ' sudah absen!!',
            'selected_kegiatan' => $kegiatanId
        ]);
    }

    /**
     * Handle duplicate scan dengan toleransi
     */
    private function handleDuplicateScan($peserta, $kegiatan, $kegiatanId)
    {
        $sessionKey = 'scan_count_' . $peserta->id . '_' . $kegiatanId;
        $scanCount = session($sessionKey, 0) + 1;
        
        $lastScanTime = session('last_scan_time_' . $peserta->id . '_' . $kegiatanId);
        $currentTime = now();
        
        if ($lastScanTime && $currentTime->diffInSeconds($lastScanTime) > 30) {
            session([$sessionKey => 1]);
            $scanCount = 1;
        } else {
            session([$sessionKey => $scanCount]);
        }
        
        session(['last_scan_time_' . $peserta->id . '_' . $kegiatanId => $currentTime]);
        
        if ($scanCount <= 3) {
            return redirect()->route('scan.index')->with([
                'success' => 'Terimakasih ' . $peserta->nama . ' sudah absen!!',
                'selected_kegiatan' => $kegiatanId
            ]);
        }
        
        return redirect()->route('scan.index')->with([
            'error' => 'Peserta ' . $peserta->nama . ' sudah absen di kegiatan ' . $kegiatan->nama,
            'selected_kegiatan' => $kegiatanId
        ]);
    }

    /**
     * Hitung status absensi (tepat waktu/telat)
     */
    private function calculateAttendanceStatus($kegiatan)
    {
        $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon 
            ? $kegiatan->tanggal->format('Y-m-d') 
            : $kegiatan->tanggal;
        
        $jamBatas = $kegiatan->jam_batas_tepat;
        if (strlen($jamBatas) == 5) {
            $jamBatas .= ':00';
        }
        
        try {
            $batasWaktu = Carbon::parse($tanggalKegiatan . ' ' . $jamBatas, 'Asia/Jakarta');
        } catch (\Exception $e) {
            $batasWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $tanggalKegiatan . ' ' . $jamBatas, 'Asia/Jakarta');
        }
        
        return Carbon::now('Asia/Jakarta')->lte($batasWaktu) ? 'tepat_waktu' : 'telat';
    }

    /**
     * Initialize scan counter untuk peserta baru
     */
    private function initializeScanCounter($pesertaId, $kegiatanId)
    {
        $sessionKey = 'scan_count_' . $pesertaId . '_' . $kegiatanId;
        session([
            $sessionKey => 1,
            'last_scan_time_' . $pesertaId . '_' . $kegiatanId => now()
        ]);
    }

    /**
     * API untuk riwayat absensi kegiatan
     */
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
                'peserta' => ['nama' => $attendance->peserta->nama],
                'status' => $attendance->status,
                'waktu_absen' => Carbon::parse($attendance->waktu_absen)->format('H:i:s')
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
