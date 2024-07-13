<?php

use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KuisionerController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(AuthMiddleware::class);

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AutentikasiController::class, 'login'])->name('login');

Route::prefix('kelas')->middleware(AuthMiddleware::class)->group((function () {
    Route::get('', [KelasController::class, 'lihatKelas'])->name('daftar.kelas');
    Route::get('/tambah', [KelasController::class, 'formTambahKelas'])->name('form.tambah.kelas');
    Route::post('', [KelasController::class, 'tambahKelas'])->name('tambah.kelas');
    Route::get('/ubah/{idKelas}', [KelasController::class, 'formUbahKelas'])->name('form.ubah.kelas');
    Route::post('/ubah', [KelasController::class, 'ubahKelas'])->name('ubah.kelas');
    Route::get('/hapus/{idKelas}', [KelasController::class, 'hapusKelas'])->name('hapus.kelas');
}));

Route::prefix('siswa')->middleware(AuthMiddleware::class)->group(function () {
    Route::get('', [SiswaController::class, 'lihatSiswa'])->name('daftar.siswa');
    Route::get('/tambah', [SiswaController::class, 'formTambahSiswa'])->name('form.tambah.siswa');
    Route::post('', [SiswaController::class, 'tambahSiswa'])->name('tambah.siswa');
    Route::get('/ubah/{idSiswa}', [SiswaController::class, 'formUbahSiswa'])->name('form.ubah.siswa');
    Route::post('/ubah', [SiswaController::class, 'ubahSiswa'])->name('ubah.siswa');
    Route::get('/hapus/{idSiswa}', [SiswaController::class, 'hapusSiswa'])->name('hapus.siswa'); 
});


Route::prefix('guru')->middleware(AuthMiddleware::class)->group((function () {
    Route::get('', [GuruController::class, 'lihatGuru'])->name('daftar.guru');
    Route::get('/tambah', [GuruController::class, 'formTambahGuru'])->name('form.tambah.guru');
    Route::post('', [GuruController::class, 'tambahGuru'])->name('tambah.guru');
    Route::get('/ubah/{idGuru}', [GuruController::class, 'formUbahGuru'])->name('form.ubah.guru');
    Route::post('/ubah', [GuruController::class, 'ubahGuru'])->name('ubah.guru');
    Route::get('/hapus/{idGuru}', [GuruController::class, 'hapusGuru'])->name('hapus.guru');
}));

Route::prefix('kuisioner')->middleware(AuthMiddleware::class)->group(function () {
    Route::get('', [KuisionerController::class, 'lihatKuisioner'])->name('daftar.kuisioner');
    Route::get('/analisa', [KuisionerController::class, 'analisa'])->name('analisa.kuisioner');
    Route::get('/analisa/{idKuisioner}', [KuisionerController::class, 'lihatHasilAnalisa'])->name('lihat.analisa.kuisioner');
    Route::get('/tambah', [KuisionerController::class, 'formTambahKuisioner'])->name('form.tambah.kuisioner');
    Route::post('', [KuisionerController::class, 'tambahKuisioner'])->name('tambah.kuisioner');
    Route::get('/ubah/{idKuisioner}', [KuisionerController::class, 'formUbahKuisioner'])->name('form.ubah.kuisioner');
    Route::post('/ubah', [KuisionerController::class, 'ubahKuisioner'])->name('ubah.kuisioner');
    Route::get('/hapus/{idKuisioner}', [KuisionerController::class, 'hapusKuisioner'])->name('hapus.kuisioner');
});

Route::get('/hasil', [KuisionerController::class, 'analisaKesimpulan'])->name('analisa.kesimpulan');