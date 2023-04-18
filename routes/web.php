<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#Setting Up

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#Prodi
Route::middleware('prodi')->group(function(){
    Route::get('prodi', [App\Http\Controllers\kelolaDosen::class, 'index'])->name('prodi.home');
    
    #--- Kelola Dosen
    Route::get('prodi/kelolaDosen', [App\Http\Controllers\kelolaDosen::class, 'dosen'])->name('prodi.kelolaDosen');
    Route::post('prodi/kelolaDosen', [App\Http\Controllers\kelolaDosen::class, 'tambahDosen'])->name('prodi.kelolaDosen.tambah');
    Route::patch('prodi/kelolaDosen/ubah', [App\Http\Controllers\kelolaDosen::class, 'ubahDosen'])->name('prodi.kelolaDosen.ubah');
    Route::patch('prodi/kelolaDosen/hapus', [App\Http\Controllers\kelolaDosen::class, 'hapusDosen'])->name('prodi.kelolaDosen.hapus');
    Route::get('prodi/ajaxprodi/dataDosen/{id}', [App\Http\Controllers\kelolaDosen::class, 'getDataDosen']);

    #---- Kelola Mahasiswa
    Route::get('prodi/kelolaMahasiswa', [App\Http\Controllers\kelolaMahasiswa::class, 'mahasiswa'])->name('prodi.kelolaMahasiswa');
    Route::post('prodi/kelolaMahasiswa', [App\Http\Controllers\kelolaMahasiswa::class, 'tambahMahasiswa'])->name('prodi.kelolaMahasiswa.tambah');
    Route::patch('prodi/kelolaMahasiswa/ubah', [App\Http\Controllers\kelolaMahasiswa::class, 'ubahMahasiswa'])->name('prodi.kelolaMahasiswa.ubah');
    Route::patch('prodi/kelolaMahasiswa/hapus', [App\Http\Controllers\kelolaMahasiswa::class, 'hapusMahasiswa'])->name('prodi.kelolaMahasiswa.hapus');
    Route::get('prodi/ajaxprodi/dataMahasiswa/{id}', [App\Http\Controllers\kelolaMahasiswa::class, 'getDataMahasiswa']);

    #---- Kelola User
    Route::get('prodi/kelolaUser', [App\Http\Controllers\Akun::class, 'users'])->name('prodi.kelolaUser');
    Route::patch('prodi/kelolaUser/ubah', [App\Http\Controllers\Akun::class, 'ubahUser'])->name('prodi.kelolaUser.ubah');
    Route::delete('prodi/kelolaUser/hapus', [App\Http\Controllers\Akun::class, 'hapusUser'])->name('prodi.kelolaUser.hapus');
    Route::get('prodi/ajaxprodi/dataUser/{id}', [App\Http\Controllers\Akun::class, 'getDataUser']);

    #Laporan
    Route::get('prodi/Laporan', [App\Http\Controllers\Laporan::class, 'lihatLaporan'])->name('prodi.Laporan');
    Route::get('prodi/Laporan/filter', [App\Http\Controllers\Laporan::class, 'filterLaporan'])->name('Laporan.filter');
});

#Koordinator
Route::middleware('koordinator')->group(function(){
    Route::get('koordinator', [App\Http\Controllers\KelolaTopik::class, 'index'])->name('koordinator.home');

    #---- Kelola Topik
    Route::get('koordinator/kelolaTopik', [App\Http\Controllers\KelolaTopik::class, 'topik'])->name('koordinator.kelolaTopik');
    Route::post('koordinator/kelolaTopik', [App\Http\Controllers\KelolaTopik::class, 'tambahTopik'])->name('koordinator.kelolaTopik.tambah');
    Route::patch('koordinator/kelolaTopik/ubah', [App\Http\Controllers\KelolaTopik::class, 'ubahTopik'])->name('koordinator.kelolaTopik.ubah');
    Route::delete('koordinator/kelolaTopik/hapus', [App\Http\Controllers\KelolaTopik::class, 'hapusTopik'])->name('koordinator.kelolaTopik.hapus');
    Route::get('koordinator/ajaxkoordinator/dataTopik/{id}', [App\Http\Controllers\KelolaTopik::class, 'getDataTopik']);
    
    #--- Validasi Pengajuan
    Route::get('koordinator/Pengajuan', [App\Http\Controllers\Pengajuan::class, 'pengajuanProposal'])->name('koordinator.pengajuan');
    Route::patch('koordinator/Pengajuan/revisi', [App\Http\Controllers\Pengajuan::class, 'revisiPengajuanKoordinator'])->name('koordinator.pengajuan.revisi');
    Route::patch('koordinator/Pengajuan/terima', [App\Http\Controllers\Pengajuan::class, 'terimaPengajuanKoordinator'])->name('koordinator.pengajuan.terima');
    Route::patch('koordinator/Pengajuan/pembimbing', [App\Http\Controllers\Pengajuan::class, 'pilihDosenPembimbing'])->name('koordinator.pengajuan.pembimbing');
    Route::get('koordinator/ajaxkoordinator/dataPengajuan/{id}', [App\Http\Controllers\Pengajuan::class, 'getDataPengajuan']);
    
    #--- Laporan
    Route::get('koordinator/Laporan', [App\Http\Controllers\Laporan::class, 'lihatLaporan'])->name('koordinator.Laporan');
    Route::get('koordinator/Laporan/filter', [App\Http\Controllers\Laporan::class, 'filterLaporan'])->name('Laporan.filter');
});

#Mahasiswa
Route::middleware('mahasiswa')->group(function(){
    Route::get('mahasiswa', [App\Http\Controllers\Pengajuan::class, 'index'])->name('mahasiswa.home');
    Route::get('mahasiswa/Pengajuan', [App\Http\Controllers\Pengajuan::class, 'pengajuanProposal'])->name('mahasiswa.pengajuan');
    Route::post('mahasiswa/Pengajuan', [App\Http\Controllers\Pengajuan::class, 'tambahPengajuan'])->name('mahasiswa.pengajuan.tambah');
    Route::patch('mahasiswa/Pengajuan/revisi', [App\Http\Controllers\Pengajuan::class, 'revisiPengajuan'])->name('mahasiswa.pengajuan.revisi');
    Route::get('mahasiswa/Pengajuan/lihat/{id}', [App\Http\Controllers\Pengajuan::class, 'lihatRevisi'])->name('mahasiswa.pengajuan.lihat');

    #Topik
    Route::get('mahasiswa/Topik', [App\Http\Controllers\KelolaTopik::class, 'topik'])->name('mahasiswa.kelolaTopik');
    Route::patch('mahasiswa/Topik/pilih', [App\Http\Controllers\KelolaTopik::class, 'pilihTopik'])->name('mahasiswa.kelolaTopik.pilih');
    Route::get('mahasiswa/ajaxmahasiswa/dataTopik/{id}', [App\Http\Controllers\KelolaTopik::class, 'getDataTopik']);
});

#Dosen
Route::middleware('dosen')->group(function(){
    Route::get('dosen', [App\Http\Controllers\Pengajuan::class, 'index'])->name('dosen.home');
    Route::get('dosen/Proposal', [App\Http\Controllers\Pengajuan::class, 'pengajuanProposal'])->name('dosen.pengajuan');
    Route::patch('dosen/Proposal/validasi', [App\Http\Controllers\Pengajuan::class, 'validasiProposalPembimbing'])->name('dosen.pengajuan.validasi');

    Route::get('dosen/ajaxdosen/dataPengajuan/{id}', [App\Http\Controllers\Pengajuan::class, 'getDataPengajuan']);
});

Route::get('mahasiswa/download_proposal/{filename}',[App\Http\Controllers\Pengajuan::class, 'downloadProposal']);
Route::get('dosen/download_proposal/{filename}',[App\Http\Controllers\Pengajuan::class, 'downloadProposal']);
Route::get('koordinator/download_proposal/{filename}',[App\Http\Controllers\Pengajuan::class, 'downloadProposal']);

