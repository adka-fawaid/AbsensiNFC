<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Absensi;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitorController extends Controller
{
    public function index(Request $request)
    {
        $kegiatanId = $request->get('kegiatan_id');
        $kegiatan = null;
        $absensis = collect();
        $totalPeserta = Peserta::count();
        $hadir = 0;
        $tepatWaktu = 0;
        $terlambat = 0;

        if ($kegiatanId) {
            $kegiatan = Kegiatan::findOrFail($kegiatanId);
            $absensis = Absensi::with('peserta')
                             ->where('kegiatan_id', $kegiatanId)
                             ->orderBy('waktu_absen', 'desc')
                             ->get();
            
            $hadir = $absensis->count();
            $tepatWaktu = $absensis->where('status', 'tepat_waktu')->count();
            $terlambat = $absensis->where('status', 'telat')->count();
        }

        $kegiatans = Kegiatan::where('tanggal', '>=', now()->format('Y-m-d'))
                            ->orderBy('tanggal', 'asc')
                            ->get();

        return view('monitor.index', compact(
            'kegiatans', 'kegiatan', 'absensis', 
            'totalPeserta', 'hadir', 'terlambat'
        ));
    }

    public function scan(Request $request)
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
            return response()->json([
                'success' => false,
                'message' => 'Peserta dengan UID tersebut tidak ditemukan!'
            ], 404);
        }

        // Ambil data kegiatan dulu
        $kegiatan = Kegiatan::findOrFail($kegiatanId);

        // Cek duplicate absensi
        $existingAbsensi = Absensi::where('peserta_id', $peserta->id)
                                 ->where('kegiatan_id', $kegiatanId)
                                 ->first();
        
        if ($existingAbsensi) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta ' . $peserta->nama . ' sudah absen di kegiatan ' . $kegiatan->nama
            ], 400);
        }

        // Hitung status tepat waktu atau telat
        $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('Y-m-d') : $kegiatan->tanggal;
        
        // Format jam_batas_tepat dengan robust parsing
        $jamBatas = $kegiatan->jam_batas_tepat;
        // Pastikan format HH:MM:SS
        if (strlen($jamBatas) == 5) {
            $jamBatas = $jamBatas . ':00'; // Tambah detik jika HH:MM
        }
        
        try {
            // Gunakan Carbon::parse yang lebih fleksibel
            $batasWaktu = \Carbon\Carbon::parse($tanggalKegiatan . ' ' . $jamBatas, 'Asia/Jakarta');
        } catch (\Exception $e) {
            // Fallback jika parse gagal
            $batasWaktu = \Carbon\Carbon::today('Asia/Jakarta')->setTimeFromTimeString($jamBatas);
        }
        
        $waktuAbsen = \Carbon\Carbon::now('Asia/Jakarta');
        

        
        $status = $waktuAbsen->lte($batasWaktu) ? 'tepat_waktu' : 'telat';

        // Simpan absensi
        Absensi::create([
            'peserta_id' => $peserta->id,
            'kegiatan_id' => $kegiatanId,
            'uid' => $uid,
            'waktu_absen' => $waktuAbsen,
            'status' => $status
        ]);

        // Logging
        \Log::info('Absensi berhasil', [
            'peserta_id' => $peserta->id,
            'peserta_nama' => $peserta->nama,
            'kegiatan_id' => $kegiatanId,
            'kegiatan_nama' => $kegiatan->nama,
            'status' => $status,
            'waktu_absen' => $waktuAbsen->format('Y-m-d H:i:s')
        ]);

        $statusText = $status === 'tepat_waktu' ? 'TEPAT WAKTU' : 'TERLAMBAT';
        
        return response()->json([
            'success' => true,
            'message' => 'Terimakasih ' . $peserta->nama . ' sudah absen!!',
            'data' => [
                'peserta_nama' => $peserta->nama,
                'status' => $status,
                'status_text' => $statusText,
                'waktu_absen' => $waktuAbsen->format('H:i:s')
            ]
        ]);
    }

    public function getData(Request $request)
    {
        $kegiatanId = $request->get('kegiatan_id');
        
        if (!$kegiatanId) {
            return response()->json(['error' => 'Kegiatan ID required'], 400);
        }

        $kegiatan = Kegiatan::findOrFail($kegiatanId);
        $absensis = Absensi::with('peserta')
                          ->where('kegiatan_id', $kegiatanId)
                          ->orderBy('waktu_absen', 'desc')
                          ->get();

        $totalPeserta = Peserta::count();
        $hadir = $absensis->count();
        $tepatWaktu = $absensis->where('status', 'tepat_waktu')->count();
        $terlambat = $absensis->where('status', 'telat')->count();

        return response()->json([
            'kegiatan' => $kegiatan,
            'absensis' => $absensis->map(function($absen) {
                return [
                    'id' => $absen->id,
                    'peserta_nama' => $absen->peserta->nama,
                    'peserta_jabatan' => $absen->peserta->jabatan,
                    'waktu_absen' => $absen->waktu_absen instanceof \Carbon\Carbon ? $absen->waktu_absen->format('H:i:s') : date('H:i:s', strtotime($absen->waktu_absen)),
                    'status' => $absen->status,
                    'status_text' => $absen->status == 'tepat_waktu' ? 'Tepat Waktu' : 'Terlambat'
                ];
            }),
            'stats' => [
                'total_peserta' => $totalPeserta,
                'hadir' => $hadir,
                'tepat_waktu' => $tepatWaktu,
                'terlambat' => $terlambat,
                'belum_hadir' => $totalPeserta - $hadir
            ]
        ]);
    }

    public function exportPdf(Request $request)
    {
        $kegiatanId = $request->get('kegiatan_id');
        if (!$kegiatanId) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan');
        }

        $kegiatan = Kegiatan::findOrFail($kegiatanId);
        $absensis = Absensi::with('peserta')
                          ->where('kegiatan_id', $kegiatanId)
                          ->orderBy('waktu_absen', 'asc')
                          ->get();

        $totalPeserta = Peserta::count();
        $hadir = $absensis->count();
        $tepatWaktu = $absensis->where('status', 'tepat_waktu')->count();
        $terlambat = $absensis->where('status', 'telat')->count();

        // Prepare data for PDF template
        $data = [
            'kegiatan' => $kegiatan,
            'absensis' => $absensis,
            'stats' => [
                'total_peserta' => $totalPeserta,
                'hadir' => $hadir,
                'tepat_waktu' => $tepatWaktu,
                'terlambat' => $terlambat,
                'belum_hadir' => $totalPeserta - $hadir
            ]
        ];

        // Generate PDF using custom template
        $pdf = Pdf::loadView('pdf.absensi-report', $data);
        
        // Set paper orientation and size
        $pdf->setPaper('A4', 'portrait');

        // Generate filename
        $filename = 'Laporan_Absensi_' . str_replace(' ', '_', $kegiatan->nama) . '_' . now('Asia/Jakarta')->format('Y-m-d') . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $kegiatanId = $request->get('kegiatan_id');
        if (!$kegiatanId) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan');
        }

        $kegiatan = Kegiatan::findOrFail($kegiatanId);
        $absensis = Absensi::with('peserta')
                          ->where('kegiatan_id', $kegiatanId)
                          ->orderBy('waktu_absen', 'asc')
                          ->get();

        $totalPeserta = Peserta::count();
        $hadir = $absensis->count();
        $tepatWaktu = $absensis->where('status', 'tepat_waktu')->count();
        $terlambat = $absensis->where('status', 'telat')->count();

        // Simple CSV export
        $csv = "LAPORAN ABSENSI\n";
        $csv .= "Kegiatan: {$kegiatan->nama}\n";
        $csv .= "Tanggal: " . ($kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($kegiatan->tanggal))) . "\n";
        $csv .= "Jam: {$kegiatan->jam_mulai}\n\n";
        
        $csv .= "STATISTIK:\n";
        $csv .= "Total Peserta,{$totalPeserta}\n";
        $csv .= "Hadir,{$hadir}\n";
        $csv .= "Tepat Waktu,{$tepatWaktu}\n";
        $csv .= "Terlambat,{$terlambat}\n";
        $csv .= "Belum Hadir," . ($totalPeserta - $hadir) . "\n\n";
        
        $csv .= "DATA ABSENSI:\n";
        $csv .= "No,Nama,Jabatan,Waktu Absen,Status\n";

        foreach ($absensis as $index => $absen) {
            $waktuAbsen = $absen->waktu_absen instanceof \Carbon\Carbon ? $absen->waktu_absen->format('H:i:s') : date('H:i:s', strtotime($absen->waktu_absen));
            $statusText = $absen->status == 'tepat_waktu' ? 'Tepat Waktu' : 'Terlambat';
            $csv .= ($index + 1) . ",\"{$absen->peserta->nama}\",\"" . ($absen->peserta->jabatan ?? '-') . "\",{$waktuAbsen},{$statusText}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="Laporan_Absensi_' . str_replace(' ', '_', $kegiatan->nama) . '_' . now('Asia/Jakarta')->format('Y-m-d') . '.csv"');
    }
}
