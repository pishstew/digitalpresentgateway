<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\JadwalPelajaranController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/guru/export',           [GuruController::class,  'export'])->name('guru.export');
    Route::get('/guru/template-import',  [GuruController::class,  'templateImport'])->name('guru.template-import');
    Route::post('/guru/import',          [GuruController::class,  'import'])->name('guru.import');

    Route::get('/siswa/template-import', [SiswaController::class, 'templateImport'])->name('siswa.template-import');
    Route::post('/siswa/import',         [SiswaController::class, 'import'])->name('siswa.import');

    Route::get('/presensi/export',       [PresensiController::class, 'export'])->name('presensi.export');

    Route::resource('siswa',    SiswaController::class);
    Route::resource('guru',     GuruController::class);
    Route::resource('mapel',    MapelController::class);
    Route::resource('jadwal',   JadwalPelajaranController::class);
    Route::resource('presensi', PresensiController::class);
});

/*
|--------------------------------------------------------------------------
| GURU AREA
| Diakses oleh: guru, walikelas, kakon
| (walikelas & kakon tetap guru pengajar, dashboard ini adalah home utama mereka)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru,walikelas,kakon'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');
    Route::post('token/generate', [\App\Http\Controllers\Guru\DashboardController::class, 'generateToken'])->name('token.generate');
    Route::post('presensi/selesaikan', [\App\Http\Controllers\Guru\DashboardController::class, 'selesaikan'])->name('presensi.selesaikan');
    Route::get('jadwal', [\App\Http\Controllers\Guru\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('presensi',           [\App\Http\Controllers\Guru\PresensiController::class, 'index'])->name('presensi.index');
    Route::post('presensi',          [\App\Http\Controllers\Guru\PresensiController::class, 'store'])->name('presensi.store');
    Route::put('presensi/{id}',      [\App\Http\Controllers\Guru\PresensiController::class, 'update'])->name('presensi.update');
});

/*
|--------------------------------------------------------------------------
| SISWA AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
    Route::post('dashboard/presensi', [\App\Http\Controllers\Siswa\DashboardController::class, 'store'])->name('presensi.store');
    Route::get('presensi',        [\App\Http\Controllers\Siswa\PresensiController::class, 'index'])->name('presensi.index');
    Route::get('presensi/search', [\App\Http\Controllers\Siswa\PresensiController::class, 'search'])->name('presensi.search');
});

/*
|--------------------------------------------------------------------------
| WALIKELAS AREA
| Hanya bisa diakses dari tombol redirect di dashboard guru
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:walikelas'])->prefix('walikelas')->name('walikelas.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Walikelas\DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| KAKON (KEPALA KONSENTRASI) AREA
| Hanya bisa diakses dari tombol redirect di dashboard guru
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:kakon'])->prefix('kakon')->name('kakon.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Kakon\DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';