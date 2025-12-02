@echo off
title Sistem Absensi NFC - Lihat Admin
cd /d "%~dp0"

echo ================================================
echo           SISTEM ABSENSI NFC
echo         SCRIPT LIHAT ADMINISTRATOR
echo ================================================
echo.

if not exist "vendor\autoload.php" (
    echo ERROR: File vendor\autoload.php tidak ditemukan!
    echo Pastikan Composer sudah diinstall: composer install
    echo.
    pause
    exit /b 1
)

php lihat_admin.php

pause