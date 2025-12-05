<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ScanController, MonitorController, AuthController, DashboardController, PesertaController, KegiatanController};

/*
|--------------------------------------------------------------------------
| Sistem Absensi NFC BEM UDINUS - Web Routes
|--------------------------------------------------------------------------
| 
| Routes untuk aplikasi absensi NFC BEM Keluarga Mahasiswa UDINUS.
| Terdiri dari public routes (scan & monitor) dan admin routes (CRUD).
|
*/

// === PUBLIC ROUTES ===
// Halaman utama & scanning absensi
Route::get('/', [ScanController::class, 'index'])->name('home');
Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');
Route::get('/scan/attendance-history/{kegiatan}', [ScanController::class, 'attendanceHistory'])->name('scan.attendance.history');

// Monitoring & pelaporan
Route::prefix('monitor')->name('monitor.')->group(function () {
    Route::get('/', [MonitorController::class, 'index'])->name('index');
    Route::get('/data', [MonitorController::class, 'getData'])->name('data');
    Route::post('/scan', [MonitorController::class, 'scan'])->name('scan');
    Route::get('/export/pdf', [MonitorController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/excel', [MonitorController::class, 'exportExcel'])->name('export.excel');
});

// === AUTHENTICATION ===
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Alias untuk backward compatibility
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// === ADMIN ROUTES (Protected) ===
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('peserta', PesertaController::class);
    Route::resource('kegiatan', KegiatanController::class);
});
