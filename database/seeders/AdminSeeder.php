<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = \App\Models\Admin::where('email', 'kreasi@bemkm.com')->first();
        
        if (!$existingAdmin) {
            \App\Models\Admin::create([
                'name' => 'kreasi',
                'email' => 'kreasi@bemkm.com',
                'password' => '$2y$12$RjMpHPSBW2SGMiJkHxWoreAdlAKBEeRpz60pZQ2xlVQ9nnDkdh7r.'
            ]);
            
            echo "Admin 'kreasi' created successfully.\n";
        } else {
            echo "Admin 'kreasi' already exists.\n";
        }
    }
}
