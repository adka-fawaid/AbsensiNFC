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

// Redirect to login
Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('admin.login');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('admin.logout');

// Protected routes
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Resource routes
    Route::resource('peserta', App\Http\Controllers\PesertaController::class);
    Route::resource('kegiatan', App\Http\Controllers\KegiatanController::class);
    
    // Monitor routes
    Route::get('/monitor', [App\Http\Controllers\MonitorController::class, 'index'])->name('monitor.index');
    Route::get('/monitor/data', [App\Http\Controllers\MonitorController::class, 'getData'])->name('monitor.data');
    Route::post('/monitor/scan', [App\Http\Controllers\MonitorController::class, 'scan'])->name('monitor.scan');
});
