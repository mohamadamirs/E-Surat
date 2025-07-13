<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// admin
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LihatSuratController;
// sekretaris
use App\Http\Controllers\Sekretaris\DashboardController as SekretarisDashboardController;
use App\Http\Controllers\Sekretaris\SuratMasukController;
use App\Http\Controllers\Sekretaris\DisposisiController;
use App\Http\Controllers\Sekretaris\SuratKeluarController;
// kepala
use App\Http\Controllers\Kepala\DashboardController as KepalaDashboardController;
use App\Http\Controllers\Kepala\ValidasiDisposisiController;
use App\Http\Controllers\Kepala\SuratKeluarController as KepalaSuratKeluarController;


Route::get('/', function () {
    return view('welcome');
});
// middleware setelah login
Route::middleware('auth')->group(function () {
    // Route utama untuk menampilkan halaman profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Route untuk memproses form update informasi (method PATCH)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route untuk memproses form hapus akun (method DELETE)
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route ini akan dipanggil oleh JavaScript untuk mendapatkan konten modal form edit info
    Route::get('/profile/partials/info', [ProfileController::class, 'partialsProfileInfo'])->name('profile.partials.info');
    // Route ini akan dipanggil oleh JavaScript untuk mendapatkan konten modal form ubah password
    Route::get('/profile/partials/password', [ProfileController::class, 'partialsPassword'])->name('profile.partials.password');
});
// Semua route untuk ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Halaman dashboard kusus admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Halaman kelola user (CRUD)
    Route::resource('users', AdminUserController::class);
    // lihat surat masuk
});

// Semua route untuk kepala
Route::middleware(['auth', 'role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
    // dashboard
    Route::get('/dashboard', [KepalaDashboardController::class, 'index'])->name('dashboard');
    // rute untuk disposisi
    Route::get('/validasi', [ValidasiDisposisiController::class, 'index'])->name('validasi.index');
    Route::patch('/validasi/{disposisi}/approve', [ValidasiDisposisiController::class, 'approve'])->name('validasi.approve');
    Route::patch('/validasi/{disposisi}/reject', [ValidasiDisposisiController::class, 'reject'])->name('validasi.reject');
    Route::get('/surat/{suratMasuk}', [ValidasiDisposisiController::class, 'show'])->name('validasi.show');
    Route::patch('/validasi/{disposisi}/revise', [ValidasiDisposisiController::class, 'revise'])->name('validasi.revise');
    // riwayat disposiis
    Route::get('/riwayat', [ValidasiDisposisiController::class, 'history'])->name('riwayat.index');
    Route::delete('/riwayat', [ValidasiDisposisiController::class, 'bulkDelete'])->name('riwayat.bulkDelete');
    Route::resource('surat-keluar', KepalaSuratKeluarController::class)->only(['index', 'show']);
});
// Semua route untuk sekretaris
Route::middleware(['auth', 'role:sekretaris,admin'])->prefix('sekretaris')->name('sekretaris.')->group(function () {
    // Anda bisa membuat dashboard khusus sekretaris jika perlu
    Route::get('/dashboard', [SekretarisDashboardController::class, 'index'])->name('dashboard');
    // CRUD untuk Surat Masuk
    Route::resource('surat-masuk', SuratMasukController::class);
    // CRUD untuk Surat Keluar
    Route::resource('surat-keluar', SuratKeluarController::class);
    // Aksi untuk menyimpan disposisi
    Route::post('surat-masuk/{suratMasuk}/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
});

require __DIR__ . '/auth.php';
