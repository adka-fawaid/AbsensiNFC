@echo off
title Sistem Absensi NFC - Tambah Admin
cd /d "%~dp0"

echo ================================================
echo           SISTEM ABSENSI NFC
echo         SCRIPT TAMBAH ADMINISTRATOR
echo ================================================
echo.

if not exist "vendor\autoload.php" (
    echo ERROR: File vendor\autoload.php tidak ditemukan!
    echo Pastikan Composer sudah diinstall: composer install
    echo.
    pause
    exit /b 1
)

php tambah_admin.php

pause