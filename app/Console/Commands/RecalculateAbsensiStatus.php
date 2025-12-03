<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecalculateAbsensiStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:recalculate-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate all absensi status based on new logic (jam_mulai + 15 minutes tolerance)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Recalculating all absensi status...');
        
        $absensis = \App\Models\Absensi::with('kegiatan')->get();
        $updated = 0;
        $tepat_waktu = 0;
        $terlambat = 0;
        
        foreach ($absensis as $absensi) {
            $kegiatan = $absensi->kegiatan;
            
            // Get tanggal kegiatan
            $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon ? 
                              $kegiatan->tanggal->format('Y-m-d') : 
                              $kegiatan->tanggal;
            
            // Get jam mulai
            $jamMulai = $kegiatan->jam_mulai;
            if (strlen($jamMulai) == 5) {
                $jamMulai = $jamMulai . ':00';
            }
            
            try {
                // Batas waktu adalah 15 menit setelah jam mulai kegiatan
                $waktuMulai = \Carbon\Carbon::parse($tanggalKegiatan . ' ' . $jamMulai, 'Asia/Jakarta');
                $batasWaktu = $waktuMulai->copy()->addMinutes(15);
            } catch (\Exception $e) {
                $waktuMulai = \Carbon\Carbon::today('Asia/Jakarta')->setTimeFromTimeString($jamMulai);
                $batasWaktu = $waktuMulai->copy()->addMinutes(15);
            }
            
            // Parse waktu absen
            $waktuAbsen = $absensi->waktu_absen instanceof \Carbon\Carbon ? 
                         $absensi->waktu_absen : 
                         \Carbon\Carbon::parse($absensi->waktu_absen);
            
            // Calculate new status
            $newStatus = $waktuAbsen->lte($batasWaktu) ? 'tepat_waktu' : 'terlambat';
            
            // Update if different
            if ($absensi->status !== $newStatus) {
                $absensi->update(['status' => $newStatus]);
                $updated++;
            }
            
            // Count totals
            if ($newStatus === 'tepat_waktu') {
                $tepat_waktu++;
            } else {
                $terlambat++;
            }
        }
        
        // Show debug info for first few records
        $this->info("\nDebug info for first 3 records:");
        $debugAbsensis = \App\Models\Absensi::with('kegiatan')->limit(3)->get();
        
        foreach ($debugAbsensis as $absensi) {
            $kegiatan = $absensi->kegiatan;
            $tanggalKegiatan = $kegiatan->tanggal instanceof \Carbon\Carbon ? 
                              $kegiatan->tanggal->format('Y-m-d') : 
                              $kegiatan->tanggal;
            
            $jamMulai = $kegiatan->jam_mulai;
            if (strlen($jamMulai) == 5) {
                $jamMulai = $jamMulai . ':00';
            }
            
            $waktuMulai = \Carbon\Carbon::parse($tanggalKegiatan . ' ' . $jamMulai, 'Asia/Jakarta');
            $batasWaktu = $waktuMulai->copy()->addMinutes(15);
            $waktuAbsen = $absensi->waktu_absen instanceof \Carbon\Carbon ? 
                         $absensi->waktu_absen : 
                         \Carbon\Carbon::parse($absensi->waktu_absen);
            
            $this->info("Kegiatan: {$kegiatan->nama}");
            $this->info("Jam mulai: {$jamMulai}");
            $this->info("Batas waktu: " . $batasWaktu->format('Y-m-d H:i:s'));
            $this->info("Waktu absen: " . $waktuAbsen->format('Y-m-d H:i:s'));
            $this->info("Status: {$absensi->status}");
            $this->info("---");
        }
        
        $this->info("Recalculation completed!");
        $this->info("Total records: " . $absensis->count());
        $this->info("Updated records: $updated");
        $this->info("Final status distribution:");
        $this->info("- Tepat waktu: $tepat_waktu");
        $this->info("- Terlambat: $terlambat");
        
        return Command::SUCCESS;
    }
}
