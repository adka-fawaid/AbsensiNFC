<?php
/**
 * Script untuk melihat daftar administrator
 * Sistem Absensi NFC
 * 
 * Cara pakai:
 * php lihat_admin.php
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin;

function clearScreen() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}

// Main script
clearScreen();

echo "╔══════════════════════════════════════════╗" . PHP_EOL;
echo "║        SISTEM ABSENSI NFC - ADMIN        ║" . PHP_EOL;
echo "║           DAFTAR ADMINISTRATOR           ║" . PHP_EOL;
echo "╚══════════════════════════════════════════╝" . PHP_EOL;
echo PHP_EOL;

$admins = Admin::orderBy('created_at', 'desc')->get();

if ($admins->count() === 0) {
    echo "📭 Tidak ada administrator." . PHP_EOL;
    echo "   Jalankan: php tambah_admin.php untuk menambah admin pertama." . PHP_EOL;
} else {
    echo "📊 Total Administrator: " . $admins->count() . PHP_EOL;
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
    echo PHP_EOL;
    
    foreach ($admins as $i => $admin) {
        echo "👤 Admin #" . ($i + 1) . PHP_EOL;
        echo "   📧 Nama     : " . $admin->name . PHP_EOL;
        echo "   📧 Email    : " . $admin->email . PHP_EOL;
        echo "   📅 Dibuat   : " . $admin->created_at->format('d/m/Y H:i:s') . PHP_EOL;
        echo "   🕐 Update   : " . $admin->updated_at->format('d/m/Y H:i:s') . PHP_EOL;
        
        if ($i < $admins->count() - 1) {
            echo "   ────────────────────────────────────────" . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "💡 Tips:" . PHP_EOL;
echo "   • Untuk tambah admin: php tambah_admin.php" . PHP_EOL;
echo "   • Login menggunakan email dan password" . PHP_EOL;
echo "   • Untuk keamanan, ganti password default setelah login pertama" . PHP_EOL;
echo PHP_EOL;

echo "Tekan Enter untuk keluar...";
fgets(STDIN);
?>