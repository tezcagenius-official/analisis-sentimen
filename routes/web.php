<?php

use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AutentikasiController::class, 'login'])->name('login');

Route::prefix('kelas')->group((function () {
    Route::get('', [KelasController::class, 'lihatKelas'])->name('daftar.kelas');
    Route::get('/tambah', [KelasController::class, 'formTambahKelas'])->name('form.tambah.kelas');
    Route::post('', [KelasController::class, 'tambahKelas'])->name('tambah.kelas');
    Route::get('/ubah/{idKelas}', [KelasController::class, 'formUbahKelas'])->name('form.ubah.kelas');
    Route::post('/ubah', [KelasController::class, 'ubahKelas'])->name('ubah.kelas');
    Route::post('/ubah', [KelasController::class, 'ubahKelas'])->name('ubah.kelas');
    Route::get('/hapus/{idKelas}', [KelasController::class, 'hapusKelas'])->name('hapus.kelas');
}));
