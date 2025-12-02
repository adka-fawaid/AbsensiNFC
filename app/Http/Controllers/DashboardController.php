<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Kegiatan;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeserta = Peserta::count();
        $totalKegiatan = Kegiatan::count();
        $totalAbsensi = Absensi::count();
        $kegiatanHariIni = Kegiatan::whereDate('tanggal', now()->format('Y-m-d'))->count();

        $recentAbsensi = Absensi::with(['peserta', 'kegiatan'])
                               ->orderBy('created_at', 'desc')
                               ->take(5)
                               ->get();

        return view('dashboard', compact(
            'totalPeserta', 
            'totalKegiatan', 
            'totalAbsensi', 
            'kegiatanHariIni',
            'recentAbsensi'
        ));
    }
}
