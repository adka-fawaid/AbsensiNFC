<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:add {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menambah administrator baru ke sistem';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== SISTEM ABSENSI NFC - ADD ADMIN ===');
        $this->newLine();

        // Get arguments or ask for input
        $name = $this->argument('name') ?: $this->ask('Nama admin');
        $email = $this->argument('email') ?: $this->ask('Email admin');
        $password = $this->argument('password') ?: $this->secret('Password (minimal 6 karakter)');

        // Validation
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $this->error('Data tidak valid:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('- ' . $error);
            }
            return 1;
        }

        // Konfirmasi
        $this->newLine();
        $this->info("Data admin baru:");
        $this->line("Nama: {$name}");
        $this->line("Email: {$email}");
        $this->line("Password: " . str_repeat("*", strlen($password)));
        $this->newLine();

        if (!$this->confirm('Simpan admin ini?')) {
            $this->warn('Dibatalkan!');
            return 0;
        }

        // Create admin
        try {
            Admin::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->newLine();
            $this->info('✅ Admin berhasil ditambahkan!');
            $this->line("📧 Nama: {$name}");
            $this->line("📧 Email: {$email}");
            $this->line("💡 Admin dapat login menggunakan email dan password yang telah dibuat.");
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Gagal menambahkan admin: ' . $e->getMessage());
            return 1;
        }
    }
}
