<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JabatanDtController;
use App\Http\Controllers\JabatanDsController;
use App\Http\Controllers\JabatanFungsionalController;
use App\Http\Controllers\KelompokRubrikController;
use App\Http\Controllers\NilaiEwmpController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PeriodeController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    activity()->log('Look mum, I logged something');

    return view('backend.dashboard');
})->name('dashboard');

// Master Data Route
Route::controller(PegawaiController::class)->group(function () {
    Route::get('/manajemen_data_dosen', 'index')->name('dosen');
    Route::get('/manajemen_data_dosen/create', 'create')->name('dosen.create');
    Route::post('/manajemen_data_dosen', 'store')->name('dosen.store');
    Route::patch('/manajemen_data_dosen/{dosen}/set_active', 'setActive')->name('dosen.set_active');
    Route::patch('/manajemen_data_dosen/{dosen}/set_nonactive', 'setnonActive')->name('dosen.set_nonactive');
    Route::get('/manajemen_data_dosen/{pegawai:slug}/edit', 'edit')->name('dosen.edit');
    Route::patch('/manajemen_data_dosen/{pegawai:slug}/update', 'update')->name('dosen.update');
});

Route::controller(JabatanDtController::class)->group(function () {
    Route::get('/manajemen_jabatan_dt', 'index')->name('jabatan_dt');
    Route::get('/manajemen_jabatan_dt/create', 'create')->name('jabatan_dt.create');
    Route::post('/manajemen_jabatan_dt', 'store')->name('jabatan_dt.store');
    Route::get('/manajemen_jabatan_dt/{jabatandt:slug}/edit', 'edit')->name('jabatan_dt.edit');
    Route::patch('/manajemen_jabatan_dt/{jabatandt:slug}/update', 'update')->name('jabatan_dt.update');
});

Route::controller(JabatanDsController::class)->group(function () {
    Route::get('/manajemen_jabatan_ds', 'index')->name('jabatan_ds');
    Route::get('/manajemen_jabatan_ds/create', 'create')->name('jabatan_ds.create');
    Route::post('/manajemen_jabatan_ds', 'store')->name('jabatan_ds.store');
    Route::get('/manajemen_jabatan_ds/{jabatands:slug}/edit', 'edit')->name('jabatan_ds.edit');
    Route::patch('/manajemen_jabatan_ds/{jabatands:slug}/update', 'update')->name('jabatan_ds.update');
});

Route::controller(JabatanFungsionalController::class)->group(function () {
    Route::get('/manajemen_jabatan_fungsional', 'index')->name('jabatan_fungsional');
    Route::get('/manajemen_jabatan_fungsional/create', 'create')->name('jabatan_fungsional.create');
    Route::post('/manajemen_jabatan_fungsional', 'store')->name('jabatan_fungsional.store');
    Route::patch('/manajemen_jabatan_fungsional/{jabatanfungsional}/set_active', 'setActive')->name('jabatan_fungsional.set_active');
    Route::patch('/manajemen_jabatan_fungsional/{jabatanfungsional}/set_nonactive', 'setnonActive')->name('jabatan_fungsional.set_nonactive');
    Route::get('/manajemen_jabatan_fungsional/{jabatanfungsional:slug}/edit', 'edit')->name('jabatan_fungsional.edit');
    Route::patch('/manajemen_jabatan_fungsional/{jabatanfungsional:slug}/update', 'update')->name('jabatan_fungsional.update');
});
Route::controller(KelompokRubrikController::class)->group(function () {
    Route::get('/manajemen_kelompok_rubrik', 'index')->name('kelompok_rubrik');
    Route::get('/manajemen_kelompok_rubrik/create', 'create')->name('kelompok_rubrik.create');
    Route::post('/manajemen_kelompok_rubrik', 'store')->name('kelompok_rubrik.store');
    Route::patch('/manajemen_kelompok_rubrik/{kelompokrubrik}/set_active', 'setActive')->name('kelompok_rubrik.set_active');
    Route::patch('/manajemen_kelompok_rubrik/{kelompokrubrik}/set_nonactive', 'setnonActive')->name('kelompok_rubrik.set_nonactive');
    Route::get('/manajemen_kelompok_rubrik/{kelompokrubrik:slug}/edit', 'edit')->name('kelompok_rubrik.edit');
    Route::patch('/manajemen_kelompok_rubrik/{kelompokrubrik:slug}/update', 'update')->name('kelompok_rubrik.update');
});
Route::controller(NilaiEwmpController::class)->group(function () {
    Route::get('/manajemen_nilai_ewmp', 'index')->name('nilai_ewmp');
    Route::get('/manajemen_nilai_ewmp/create', 'create')->name('nilai_ewmp.create');
    Route::post('/manajemen_nilai_ewmp', 'store')->name('nilai_ewmp.store');
    Route::patch('/manajemen_nilai_ewmp/{nilaiewmp}/set_active', 'setActive')->name('nilai_ewmp.set_active');
    Route::patch('/manajemen_nilai_ewmp/{nilaiewmp}/set_nonactive', 'setnonActive')->name('nilai_ewmp.set_nonactive');
    Route::get('/manajemen_nilai_ewmp/{nilaiewmp:slug}/edit', 'edit')->name('nilai_ewmp.edit');
    Route::patch('/manajemen_nilai_ewmp/{nilaiewmp:slug}/update', 'update')->name('nilai_ewmp.update');
});
Route::controller(PengumumanController::class)->group(function () {
    Route::get('/manajemen_pengumuman', 'index')->name('pengumuman');
    Route::get('/manajemen_pengumuman/create', 'create')->name('pengumuman.create');
    Route::post('/manajemen_pengumuman', 'store')->name('pengumuman.store');
    Route::patch('/manajemen_pengumuman/{pengumuman}/set_active', 'setActive')->name('pengumuman.set_active');
    Route::patch('/manajemen_pengumuman/{pengumuman}/set_nonactive', 'setnonActive')->name('pengumuman.set_nonactive');
    Route::get('/manajemen_pengumuman/{pengumuman:slug}/edit', 'edit')->name('pengumuman.edit');
    Route::patch('/manajemen_pengumuman/{pengumuman:slug}/update', 'update')->name('pengumuman.update');
});
// End Of Data Master Route

// Pengaturan/Setting Route
Route::controller(PeriodeController::class)->group(function () {
    Route::get('/manajemen_data_periode', 'index')->name('periode_penilaian');
    Route::get('/manajemen_data_periode/create', 'create')->name('periode_penilaian.create');
    Route::post('/manajemen_data_periode', 'store')->name('periode_penilaian.store');
    Route::patch('/manajemen_data_periode/{periode}/set_active', 'setActive')->name('periode_penilaian.set_active');
    Route::patch('/manajemen_data_periode/{periode}/set_nonactive', 'setnonActive')->name('periode_penilaian.set_nonactive');
    Route::get('/manajemen_data_periode/{periode}/edit', 'edit')->name('periode_penilaian.edit');
    Route::patch('/manajemen_data_periode/update', 'update')->name('periode_penilaian.update');
    Route::delete('/manajemen_data_periode/{periode}/delete', 'delete')->name('periode_penilaian.delete');
});
// End Of Pengaturan/Setting Route
