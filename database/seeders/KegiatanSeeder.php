<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use Carbon\Carbon;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kegiatans = [
            [
                'nama' => 'Rapat Koordinasi BEM UDINUS',
                'tanggal' => '2025-12-05',
                'jam_mulai' => '08:00:00',
                'jam_batas_tepat' => '08:15:00',
                'lokasi' => 'Ruang Rapat BEM UDINUS',
                'keterangan' => 'Rapat koordinasi mingguan pengurus BEM UDINUS'
            ],
            [
                'nama' => 'Training NFC Absensi System',
                'tanggal' => '2025-12-06',
                'jam_mulai' => '10:00:00',
                'jam_batas_tepat' => '10:10:00',
                'lokasi' => 'Lab Komputer UDINUS',
                'keterangan' => 'Pelatihan penggunaan sistem absensi NFC untuk pengurus'
            ],
            [
                'nama' => 'Workshop Kreativitas dan Inovasi',
                'tanggal' => '2025-12-07',
                'jam_mulai' => '09:00:00',
                'jam_batas_tepat' => '09:15:00',
                'lokasi' => 'Aula UDINUS',
                'keterangan' => 'Workshop dari Kementerian Kreativitas dan Inovasi BEM UDINUS'
            ]
        ];

        // Check if kegiatans already exist for today's date or later
        $existingCount = Kegiatan::where('tanggal', '>=', Carbon::today())->count();
        
        if ($existingCount > 0) {
            echo "Recent kegiatans already exist ({$existingCount} records). Skipping seeder.\n";
            return;
        }

        foreach ($kegiatans as $kegiatan) {
            Kegiatan::create($kegiatan);
        }
        
        echo "Created " . count($kegiatans) . " kegiatan records.\n";
    }
}