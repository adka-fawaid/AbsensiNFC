<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pesertas = [
            [
                'nama' => 'John Doe',
                'nim' => '2021001001',
                'fakultas' => 'Teknik Informatika',
                'jabatan' => 'Manager',
                'uid' => '2921153879'
            ],
            [
                'nama' => 'Jane Smith',
                'nim' => '2021001002', 
                'fakultas' => 'Manajemen',
                'jabatan' => 'Staff',
                'uid' => '1234567890'
            ],
            [
                'nama' => 'Bob Johnson',
                'nim' => '2021001003',
                'fakultas' => 'Akuntansi',
                'jabatan' => 'Supervisor', 
                'uid' => '9876543210'
            ],
            [
                'nama' => 'Alice Brown',
                'nim' => '2021001004',
                'fakultas' => 'Psikologi',
                'jabatan' => 'Staff',
                'uid' => '5555666677'
            ],
            [
                'nama' => 'Charlie Wilson',
                'nim' => '2021001005',
                'fakultas' => 'Hukum',
                'jabatan' => 'Assistant Manager',
                'uid' => '1111222233'
            ]
        ];

        foreach ($pesertas as $peserta) {
            \App\Models\Peserta::create($peserta);
        }
    }
}
