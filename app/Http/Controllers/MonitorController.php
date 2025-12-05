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
            $terlambat = $absensis->where('status', 'terlambat')->count();
        }

        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')
                            ->orderBy('jam_mulai', 'desc')
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

        // Hitung status tepat waktu atau terlambat
        $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon ? $kegiatan->tanggal->format('Y-m-d') : $kegiatan->tanggal;
        
        // Gunakan jam_mulai sebagai batas, lebih logis daripada jam_batas_tepat
        $jamMulai = $kegiatan->jam_mulai;
        // Pastikan format HH:MM:SS
        if (strlen($jamMulai) == 5) {
            $jamMulai = $jamMulai . ':00'; // Tambah detik jika HH:MM
        }
        
        try {
            // Batas waktu adalah 15 menit setelah jam mulai kegiatan
            $waktuMulai = \Carbon\Carbon::parse($tanggalKegiatan . ' ' . $jamMulai, 'Asia/Jakarta');
            $batasWaktu = $waktuMulai->copy()->addMinutes(15); // Toleransi 15 menit
        } catch (\Exception $e) {
            // Fallback jika parse gagal
            $waktuMulai = \Carbon\Carbon::today('Asia/Jakarta')->setTimeFromTimeString($jamMulai);
            $batasWaktu = $waktuMulai->copy()->addMinutes(15);
        }
        
        $waktuAbsen = \Carbon\Carbon::now('Asia/Jakarta');
        
        // Logic: 
        // - Tepat waktu: absen sebelum/pada batas waktu (jam_mulai + 15 menit)
        // - Terlambat: absen setelah batas waktu
        $status = $waktuAbsen->lte($batasWaktu) ? 'tepat_waktu' : 'terlambat';

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
            'jam_mulai' => $kegiatan->jam_mulai,
            'batas_waktu' => $batasWaktu->format('Y-m-d H:i:s'),
            'waktu_absen' => $waktuAbsen->format('Y-m-d H:i:s'),
            'status' => $status
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
        $terlambat = $absensis->where('status', 'terlambat')->count();

        // Get all peserta for filter functionality
        $allPesertas = Peserta::select('id', 'nama', 'jabatan')->get();

        return response()->json([
            'kegiatan' => $kegiatan,
            'absensis' => $absensis->map(function($absen) {
                return [
                    'id' => $absen->id,
                    'peserta_id' => $absen->peserta->id,
                    'peserta_nama' => $absen->peserta->nama,
                    'peserta_jabatan' => $absen->peserta->jabatan,
                    'waktu_absen' => $absen->waktu_absen instanceof \Carbon\Carbon ? $absen->waktu_absen->format('H:i:s') : date('H:i:s', strtotime($absen->waktu_absen)),
                    'status' => $absen->status,
                    'status_text' => $absen->status == 'tepat_waktu' ? 'Tepat Waktu' : 'Terlambat'
                ];
            }),
            'pesertas' => $allPesertas,
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

        // Generate PDF using DomPDF with custom template
        $pdf = Pdf::loadView('pdf.daftar-hadir-bem', [
            'kegiatan' => $kegiatan,
            'absensis' => $absensis
        ]);

        // Bersihkan nama kegiatan dari karakter tidak valid untuk nama file
        $cleanName = preg_replace('/[\/\\\\:*?"<>|]/', '_', $kegiatan->nama);
        $cleanName = str_replace(' ', '_', $cleanName);
        $fileName = 'Daftar_Hadir_' . $cleanName . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($fileName);

        $html .= "
                </tbody>
            </table>
        </body>
        </html>";

        // Bersihkan nama kegiatan dari karakter tidak valid untuk nama file
        $cleanName = preg_replace('/[\/\\\\:*?"<>|]/', '_', $kegiatan->nama);
        $cleanName = str_replace(' ', '_', $cleanName);
        
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="Laporan_Absensi_' . $cleanName . '_' . now('Asia/Jakarta')->format('Y-m-d') . '.html"');
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

        // Bersihkan nama kegiatan dari karakter tidak valid untuk nama file
        $cleanName = preg_replace('/[\/\\\\:*?"<>|]/', '_', $kegiatan->nama);
        $cleanName = str_replace(' ', '_', $cleanName);
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="Laporan_Absensi_' . $cleanName . '_' . now('Asia/Jakarta')->format('Y-m-d') . '.csv"');
    }
}
