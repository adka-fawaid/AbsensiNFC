<?php
/**
 * Production Readiness Check
 * BEM UDINUS - Sistem Absensi Digital
 * 
 * Run this script to verify the application is ready for production deployment
 */

echo "=================================================\n";
echo "BEM UDINUS - Sistem Absensi Digital\n";
echo "Production Readiness Checker\n";
echo "=================================================\n\n";

$checks = [];

// Check Laravel Environment
echo "1. Checking Laravel Environment...\n";
$env = file_get_contents('.env');
if (strpos($env, 'APP_ENV=production') !== false) {
    echo "   ✅ APP_ENV is set to production\n";
    $checks['env'] = true;
} else {
    echo "   ❌ APP_ENV should be set to production\n";
    $checks['env'] = false;
}

// Check Debug Mode
if (strpos($env, 'APP_DEBUG=false') !== false) {
    echo "   ✅ APP_DEBUG is disabled\n";
    $checks['debug'] = true;
} else {
    echo "   ❌ APP_DEBUG should be false in production\n";
    $checks['debug'] = false;
}

// Check App Key
if (strpos($env, 'APP_KEY=base64:') !== false) {
    echo "   ✅ APP_KEY is properly set\n";
    $checks['key'] = true;
} else {
    echo "   ❌ APP_KEY needs to be generated\n";
    $checks['key'] = false;
}

echo "\n2. Checking Database Configuration...\n";
// Check Database Config
if (strpos($env, 'DB_DATABASE=') !== false && strpos($env, 'DB_DATABASE=""') === false) {
    echo "   ✅ Database is configured\n";
    $checks['db'] = true;
} else {
    echo "   ❌ Database configuration is missing\n";
    $checks['db'] = false;
}

echo "\n3. Checking File Permissions...\n";
// Check storage permissions
if (is_writable('storage/')) {
    echo "   ✅ Storage directory is writable\n";
    $checks['storage'] = true;
} else {
    echo "   ❌ Storage directory needs write permissions\n";
    $checks['storage'] = false;
}

// Check bootstrap/cache permissions
if (is_writable('bootstrap/cache/')) {
    echo "   ✅ Bootstrap cache is writable\n";
    $checks['bootstrap'] = true;
} else {
    echo "   ❌ Bootstrap cache needs write permissions\n";
    $checks['bootstrap'] = false;
}

echo "\n4. Checking Required Files...\n";
// Check logo files
if (file_exists('public/images/logo-bem.png') && file_exists('public/images/logo-udinus.png')) {
    echo "   ✅ Logo files are present\n";
    $checks['logos'] = true;
} else {
    echo "   ❌ Logo files are missing in public/images/\n";
    $checks['logos'] = false;
}

// Check PDF template
if (file_exists('resources/views/pdf/daftar-hadir-bem.blade.php')) {
    echo "   ✅ PDF template is present\n";
    $checks['pdf'] = true;
} else {
    echo "   ❌ PDF template is missing\n";
    $checks['pdf'] = false;
}

echo "\n5. Checking Security...\n";
// Check if admin scripts are in .gitignore
$gitignore = file_exists('.gitignore') ? file_get_contents('.gitignore') : '';
$adminFiles = ['tambah_admin.php', 'lihat_admin.php', 'TAMBAH_ADMIN.bat', 'LIHAT_ADMIN.bat'];
$allIgnored = true;

foreach ($adminFiles as $file) {
    if (strpos($gitignore, $file) === false) {
        $allIgnored = false;
        break;
    }
}

if ($allIgnored) {
    echo "   ✅ Admin management scripts are properly ignored in .gitignore\n";
    $checks['security'] = true;
} else {
    echo "   ❌ Admin management scripts should be added to .gitignore\n";
    $checks['security'] = false;
}

// Summary
echo "\n=================================================\n";
echo "PRODUCTION READINESS SUMMARY\n";
echo "=================================================\n";

$passed = array_filter($checks);
$total = count($checks);
$passedCount = count($passed);

if ($passedCount === $total) {
    echo "🎉 READY FOR PRODUCTION! All checks passed ($passedCount/$total)\n";
    echo "\nNext Steps:\n";
    echo "1. Upload files to production server\n";
    echo "2. Set proper file permissions (755 for directories, 644 for files)\n";
    echo "3. Configure web server (Apache/Nginx)\n";
    echo "4. Run 'php artisan migrate:fresh --seed' on production\n";
    echo "5. Configure SSL certificate\n";
    echo "6. Test all functionality\n";
} else {
    echo "⚠️  NOT READY - Fix the issues above ($passedCount/$total checks passed)\n";
}

echo "\n=================================================\n";
echo "© 2025 BEM Keluarga Mahasiswa UDINUS\n";
echo "=================================================\n";
?>