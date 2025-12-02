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
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $kegiatans = [
            [
                'nama' => 'Rapat Bulanan',
                'tanggal' => $today->format('Y-m-d'),
                'jam_mulai' => '08:00:00',
                'jam_batas_tepat' => '08:15:00',
                'lokasi' => 'Ruang Meeting A',
                'keterangan' => 'Rapat evaluasi bulanan'
            ],
            [
                'nama' => 'Training NFC System',
                'tanggal' => $today->format('Y-m-d'),
                'jam_mulai' => '10:00:00',
                'jam_batas_tepat' => '10:10:00',
                'lokasi' => 'Ruang Training',
                'keterangan' => 'Pelatihan penggunaan sistem NFC'
            ],
            [
                'nama' => 'Workshop Development',
                'tanggal' => $tomorrow->format('Y-m-d'),
                'jam_mulai' => '09:00:00',
                'jam_batas_tepat' => '09:15:00',
                'lokasi' => 'Lab Computer',
                'keterangan' => 'Workshop pengembangan aplikasi'
            ]
        ];

        foreach ($kegiatans as $kegiatan) {
            Kegiatan::create($kegiatan);
        }
    }
}