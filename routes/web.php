<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MekanismeController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\DasarHukumController;
use App\Http\Controllers\PengaturanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('admin.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Perencanaan
    Route::get('/perencanaan', [PerencanaanController::class, 'index'])->name('perencanaan');
    Route::post('/perencanaan/folder/{id}/rename', [PerencanaanController::class, 'renameFolder'])->name('perencanaan.folder.rename');
    Route::delete('/perencanaan/folder/{id}', [PerencanaanController::class, 'deleteFolder'])->name('perencanaan.folder.delete');
    Route::post('/perencanaan/file/{id}/rename', [PerencanaanController::class, 'renameFile'])->name('perencanaan.file.rename');
    Route::delete('/perencanaan/file/{id}', [PerencanaanController::class, 'deleteFile'])->name('perencanaan.file.delete');

    // Monitoring
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::post('/monitoring/folder/create', [MonitoringController::class, 'createFolder'])->name('monitoring.folder.create');
    Route::post('/monitoring/file/upload', [MonitoringController::class, 'uploadFile'])->name('monitoring.file.upload');
    Route::post('/monitoring/folder/upload', [MonitoringController::class, 'uploadFolder'])->name('monitoring.folder.upload');
    Route::post('/monitoring/folder/{id}/rename', [MonitoringController::class, 'renameFolder'])->name('monitoring.folder.rename');
    Route::delete('/monitoring/folder/{id}', [MonitoringController::class, 'deleteFolder'])->name('monitoring.folder.delete');
    Route::post('/monitoring/file/{id}/rename', [MonitoringController::class, 'renameFile'])->name('monitoring.file.rename');
    Route::delete('/monitoring/file/{id}', [MonitoringController::class, 'deleteFile'])->name('monitoring.file.delete');

    // Mekanisme
    Route::get('/mekanisme', [MekanismeController::class, 'index'])->name('mekanisme');
    Route::post('/mekanisme/folder/{id}/rename', [MekanismeController::class, 'renameFolder'])->name('mekanisme.folder.rename');
    Route::delete('/mekanisme/folder/{id}', [MekanismeController::class, 'deleteFolder'])->name('mekanisme.folder.delete');
    Route::post('/mekanisme/file/{id}/rename', [MekanismeController::class, 'renameFile'])->name('mekanisme.file.rename');
    Route::delete('/mekanisme/file/{id}', [MekanismeController::class, 'deleteFile'])->name('mekanisme.file.delete');

    // Dokumentasi
    Route::get('/dokumentasi', [DokumentasiController::class, 'index'])->name('dokumentasi');
    Route::get('/dokumentasi/create', [DokumentasiController::class, 'create'])->name('dokumentasi.create');
    Route::post('/dokumentasi', [DokumentasiController::class, 'store'])->name('dokumentasi.store');
    Route::get('/dokumentasi/{id}', [DokumentasiController::class, 'show'])->name('dokumentasi.show');
    Route::get('/dokumentasi/{id}/edit', [DokumentasiController::class, 'edit'])->name('dokumentasi.edit');
    Route::put('/dokumentasi/{id}', [DokumentasiController::class, 'update'])->name('dokumentasi.update');
    Route::delete('/dokumentasi/{id}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');

    // Dasar Hukum
    Route::get('/dasar-hukum', [DasarHukumController::class, 'index'])->name('dasar-hukum');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan', [PengaturanController::class, 'update']);
});