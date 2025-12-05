<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes (tidak perlu login)
Route::get('/', [App\Http\Controllers\ScanController::class, 'index'])->name('home');
Route::get('/scan', [App\Http\Controllers\ScanController::class, 'index'])->name('scan.index');
Route::post('/scan', [App\Http\Controllers\ScanController::class, 'store'])->name('scan.store');

// Scan history (publik)
Route::get('/scan/attendance-history/{kegiatan}', [App\Http\Controllers\ScanController::class, 'attendanceHistory'])->name('scan.attendance.history');

// Monitor routes (publik)
Route::get('/monitor', [App\Http\Controllers\MonitorController::class, 'index'])->name('monitor.index');
Route::get('/monitor/data', [App\Http\Controllers\MonitorController::class, 'getData'])->name('monitor.data');
Route::post('/monitor/scan', [App\Http\Controllers\MonitorController::class, 'scan'])->name('monitor.scan');
Route::get('/monitor/export/pdf', [App\Http\Controllers\MonitorController::class, 'exportPdf'])->name('monitor.export.pdf');
Route::get('/monitor/export/excel', [App\Http\Controllers\MonitorController::class, 'exportExcel'])->name('monitor.export.excel');

// Auth routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('admin.login');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('admin.logout');

// Protected routes (perlu login) - hanya untuk admin management
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Resource routes - hanya admin yang bisa CRUD
    Route::resource('peserta', App\Http\Controllers\PesertaController::class);
    Route::resource('kegiatan', App\Http\Controllers\KegiatanController::class);
});
