<?php
/**
 * Script untuk menambahkan administrator baru
 * Sistem Absensi NFC
 * 
 * Cara pakai:
 * php tambah_admin.php
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

function showHeader() {
    echo "╔══════════════════════════════════════════╗" . PHP_EOL;
    echo "║        SISTEM ABSENSI NFC - ADMIN        ║" . PHP_EOL;
    echo "║           TAMBAH ADMINISTRATOR           ║" . PHP_EOL;
    echo "╚══════════════════════════════════════════╝" . PHP_EOL;
    echo PHP_EOL;
}

function showExistingAdmins() {
    $admins = Admin::all();
    echo "📋 Admin yang sudah ada (" . $admins->count() . "):" . PHP_EOL;
    if ($admins->count() > 0) {
        foreach ($admins as $i => $admin) {
            echo "   " . ($i + 1) . ". " . $admin->name . " (" . $admin->email . ")" . PHP_EOL;
        }
    } else {
        echo "   (Belum ada admin)" . PHP_EOL;
    }
    echo PHP_EOL;
}

function getInput($prompt, $required = true) {
    do {
        echo $prompt . ": ";
        $input = trim(fgets(STDIN));
        
        if ($required && empty($input)) {
            echo "❌ Field ini wajib diisi!" . PHP_EOL;
        }
    } while ($required && empty($input));
    
    return $input;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function emailExists($email) {
    return Admin::where('email', $email)->exists();
}

// Main script
clearScreen();
showHeader();
showExistingAdmins();

echo "➕ Tambah admin baru:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;

// Input data
$name = getInput("👤 Nama lengkap");

do {
    $email = getInput("📧 Email");
    
    if (!validateEmail($email)) {
        echo "❌ Format email tidak valid!" . PHP_EOL;
        continue;
    }
    
    if (emailExists($email)) {
        echo "❌ Email sudah digunakan!" . PHP_EOL;
        continue;
    }
    
    break;
} while (true);

do {
    $password = getInput("🔐 Password (min. 6 karakter)");
    
    if (strlen($password) < 6) {
        echo "❌ Password minimal 6 karakter!" . PHP_EOL;
        continue;
    }
    
    break;
} while (true);

// Konfirmasi
echo PHP_EOL;
echo "📝 Data yang akan disimpan:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "   Nama     : " . $name . PHP_EOL;
echo "   Email    : " . $email . PHP_EOL;
echo "   Password : " . str_repeat("●", strlen($password)) . PHP_EOL;
echo PHP_EOL;

echo "💾 Simpan admin ini? (y/n): ";
$confirm = trim(strtolower(fgets(STDIN)));

if ($confirm !== 'y' && $confirm !== 'yes') {
    echo PHP_EOL . "❌ Dibatalkan!" . PHP_EOL;
    exit(0);
}

// Simpan admin
try {
    $admin = new Admin();
    $admin->name = $name;
    $admin->email = $email;
    $admin->password = bcrypt($password);
    $admin->save();
    
    echo PHP_EOL;
    echo "✅ BERHASIL!" . PHP_EOL;
    echo "━━━━━━━━━━━━" . PHP_EOL;
    echo "👤 Nama  : " . $name . PHP_EOL;
    echo "📧 Email : " . $email . PHP_EOL;
    echo "🔐 Pass  : " . $password . PHP_EOL;
    echo PHP_EOL;
    echo "💡 Admin baru sudah bisa login menggunakan email dan password di atas." . PHP_EOL;
    echo "⚠️  Catat password ini karena tidak akan ditampilkan lagi!" . PHP_EOL;
    
} catch (Exception $e) {
    echo PHP_EOL . "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

echo PHP_EOL . "Tekan Enter untuk keluar...";
fgets(STDIN);
?>