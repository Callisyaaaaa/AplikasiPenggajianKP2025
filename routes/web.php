<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\AuthenticatedSessionController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/absensi', function () {
    return view('absensi'); // Halaman absensi
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/daftar-pegawai', [PegawaiController::class, 'showAll'])->name('pegawai.showAll'); 
    Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/penggajian', [PenggajianController::class, 'index'])->name('gaji.index');
    Route::get('/riwayat-gaji', [PenggajianController::class, 'riwayat'])->name('gaji.riwayat');
    Route::get('/riwayat-gaji/download/{id}', [PenggajianController::class, 'downloadFromRiwayat'])->name('riwayat.download');
    Route::get('/riwayat-absensi', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    Route::get('/riwayat-absensi/download', [AbsensiController::class, 'downloadPdf'])->name('absensi.riwayat.download');    // Tambahkan route lain yang ingin kamu proteksi
});


// Menampilkan form kelola pegawai
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index'); // Menggunakan controller untuk index

// Menyimpan pegawai
Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');

// Menampilkan daftar pegawai
Route::get('/daftar-pegawai', [PegawaiController::class, 'showAll'])->name('pegawai.showAll'); // Untuk menampilkan semua pegawai

// Route untuk edit pegawai
Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');

// Route untuk update pegawai
Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');

// Route untuk hapus pegawai
Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');


Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index'); // Menampilkan form absensi
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store'); // Menyimpan data absensi


// Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
// Route::post('/penggajian/hitung', [PenggajianController::class, 'hitungGaji'])->name('penggajian.hitung');
// Route::get('/penggajian/slip/{id}', [PenggajianController::class, 'slipGaji'])->name('penggajian.slip');

Route::get('/penggajian', [PenggajianController::class, 'index'])->name('gaji.index');
Route::post('/penggajian/hitung', [PenggajianController::class, 'hitungGaji'])->name('gaji.hitung');
Route::get('/api/absensi', [PenggajianController::class, 'getAbsensiByPegawai'])->name('api.absensi');

Route::get('/riwayat-gaji', [PenggajianController::class, 'riwayat'])->name('gaji.riwayat');
Route::post('/penggajian/selesai', [PenggajianController::class, 'selesaikanPenggajian'])->name('penggajian.selesai');
Route::get('/slipgaji/{id}', [PenggajianController::class, 'generateSlipGaji'])->name('slipgaji.pdf');

Route::post('/slip-gaji/download', [PenggajianController::class, 'downloadSlip'])->name('slipgaji.download');
Route::get('/riwayat-gaji/download/{id}', [PenggajianController::class, 'downloadFromRiwayat'])->name('riwayat.download');

Route::get('/riwayat-absensi', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
Route::get('/riwayat-absensi/download', [AbsensiController::class, 'downloadPdf'])->name('absensi.riwayat.download');

Route::get('/test-gd', function () {
    if (!extension_loaded('gd')) {
        return 'GD NOT LOADED';
    }

    $im = imagecreatetruecolor(100, 100);
    $bg = imagecolorallocate($im, 0, 100, 255);
    imagefill($im, 0, 0, $bg);

    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);
});
