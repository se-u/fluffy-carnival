<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarPoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\JadwalPeriksaController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienCrudController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\PoliController;
use Illuminate\Support\Facades\Route;

// Guest routes (without auth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Logout (requires auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Route Manajemen Poli
    Route::resource('poli', PoliController::class);

    // Manajemen Dokter
    Route::resource('dokter', DokterController::class);

    // Manajemen Pasien
    Route::resource('pasien', PasienCrudController::class);

    // Manajemen Obat
    Route::resource('obat', ObatController::class)->names([
        'index' => 'obat.index',
        'create' => 'obat.create',
        'store' => 'obat.store',
        'edit' => 'obat.edit',
        'update' => 'obat.update',
        'destroy' => 'obat.destroy',
    ]);

    // Export routes
    Route::get('/export/dokter', [ExportController::class, 'dokter'])->name('export.dokter');
    Route::get('/export/pasien', [ExportController::class, 'pasien'])->name('export.pasien');
    Route::get('/export/obat', [ExportController::class, 'obat'])->name('export.obat');

    // Pembayaran verification
    Route::get('/pembayaran', [PembayaranController::class, 'indexAdmin'])->name('pembayaran.index');
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'showAdmin'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/konfirmasi', [PembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
});

// Dokter routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dashboard');

    // Jadwal Periksa
    Route::get('/jadwal', [JadwalPeriksaController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalPeriksaController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/{jadwal}', [JadwalPeriksaController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}', [JadwalPeriksaController::class, 'destroy'])->name('jadwal.destroy');

    // Pemeriksaan
    Route::get('/periksa', [PeriksaController::class, 'index'])->name('periksa.index');
    Route::get('/periksa/{id}', [PeriksaController::class, 'periksa'])->name('periksa.periksa');
    Route::post('/periksa/{id}', [PeriksaController::class, 'store'])->name('periksa.store');
    Route::post('/periksa/{id}/panggil', [PeriksaController::class, 'panggil'])->name('periksa.panggil');

    // Export routes
    Route::get('/export/jadwal-periksa', [ExportController::class, 'jadwalPeriksa'])->name('export.jadwal');
    Route::get('/export/riwayat-pasien', [ExportController::class, 'riwayatPasien'])->name('export.riwayat');
});

// Pasien routes
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.pasien');
    })->name('dashboard');

    // Pendaftaran Poli
    Route::get('/daftar', [DaftarPoliController::class, 'index'])->name('daftar.index');
    Route::post('/daftar', [DaftarPoliController::class, 'store'])->name('daftar.store');

    // Riwayat
    Route::get('/riwayat', function () {
        return view('pasien.riwayat.index');
    })->name('riwayat.index');
    Route::get('/riwayat/{id}', function ($id) {
        return view('pasien.riwayat.show', compact('id'));
    })->name('riwayat.show');

    // Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'indexPasien'])->name('pembayaran.index');
    Route::post('/pembayaran/{id}/upload', [PembayaranController::class, 'upload'])->name('pembayaran.upload');
});
