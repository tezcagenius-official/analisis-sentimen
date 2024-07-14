<?php

use App\Constant\Runtime;
use App\Http\Controllers\AnalisaController;
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
    Route::get('', [KelasController::class, 'lihatKelas'])->name('daftar.kelas')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/tambah', [KelasController::class, 'formTambahKelas'])->name('form.tambah.kelas')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('', [KelasController::class, 'tambahKelas'])->name('tambah.kelas')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/ubah/{idKelas}', [KelasController::class, 'formUbahKelas'])->name('form.ubah.kelas')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('/ubah', [KelasController::class, 'ubahKelas'])->name('ubah.kelas')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/hapus/{idKelas}', [KelasController::class, 'hapusKelas'])->name('hapus.kelas')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
}));

Route::prefix('siswa')->middleware(AuthMiddleware::class)->group(function () {
    Route::get('', [SiswaController::class, 'lihatSiswa'])->name('daftar.siswa')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN, Runtime::ROLE_GURU]));
    Route::get('/tambah', [SiswaController::class, 'formTambahSiswa'])->name('form.tambah.siswa')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('', [SiswaController::class, 'tambahSiswa'])->name('tambah.siswa')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/ubah/{idSiswa}', [SiswaController::class, 'formUbahSiswa'])->name('form.ubah.siswa')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('/ubah', [SiswaController::class, 'ubahSiswa'])->name('ubah.siswa')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/hapus/{idSiswa}', [SiswaController::class, 'hapusSiswa'])->name('hapus.siswa')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
});


Route::prefix('guru')->middleware(AuthMiddleware::class)->group((function () {
    Route::get('', [GuruController::class, 'lihatGuru'])->name('daftar.guru')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/tambah', [GuruController::class, 'formTambahGuru'])->name('form.tambah.guru')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('', [GuruController::class, 'tambahGuru'])->name('tambah.guru')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/ubah/{idGuru}', [GuruController::class, 'formUbahGuru'])->name('form.ubah.guru')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('/ubah', [GuruController::class, 'ubahGuru'])->name('ubah.guru')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/hapus/{idGuru}', [GuruController::class, 'hapusGuru'])->name('hapus.guru')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
}));

Route::prefix('kuisioner')->middleware(AuthMiddleware::class)->group(function () {
    Route::get('', [KuisionerController::class, 'lihatKuisioner'])->name('daftar.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN, Runtime::ROLE_GURU]));
    Route::get('/analisa', [KuisionerController::class, 'analisaKesimpulan'])->name('analisa.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/analisa/{idKuisioner}', [KuisionerController::class, 'lihatHasilAnalisa'])->name('lihat.analisa.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN, Runtime::ROLE_GURU]));
    Route::get('/tambah', [KuisionerController::class, 'formTambahKuisioner'])->name('form.tambah.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('', [KuisionerController::class, 'tambahKuisioner'])->name('tambah.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/ubah/{idKuisioner}', [KuisionerController::class, 'formUbahKuisioner'])->name('form.ubah.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::post('/ubah', [KuisionerController::class, 'ubahKuisioner'])->name('ubah.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
    Route::get('/hapus/{idKuisioner}', [KuisionerController::class, 'hapusKuisioner'])->name('hapus.kuisioner')->middleware('check_role:'.implode(',', [Runtime::ROLE_ADMIN]));
});

Route::get('/hasil', [AnalisaController::class, 'lihatAnalisa'])->name('analisa.kesimpulan');
Route::post('/hasil', [AnalisaController::class, 'lihatAnalisa'])->name('lihat.analisa.kesimpulan');
Route::get('/keluar', [AutentikasiController::class, 'keluar'])->name('keluar')->middleware(AuthMiddleware::class);