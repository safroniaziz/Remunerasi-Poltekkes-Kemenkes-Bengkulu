<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JabatanDtController;
use App\Http\Controllers\JabatanDsController;
use App\Http\Controllers\JabatanFungsionalController;
use App\Http\Controllers\PangkatGolonganController;
use App\Http\Controllers\KelompokRubrikController;
use App\Http\Controllers\NilaiEwmpController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\RiwayatJabatanDtController;
use App\Http\Controllers\RiwayatPointController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\R01PerkuliahanTeoriController;
use App\Http\Controllers\R02PerkuliahanPraktikumController;
use App\Http\Controllers\R03MembimbingPencapaianKompetensiController;
use App\Http\Controllers\R04MembimbingPendampinganUkomController;
use App\Http\Controllers\R05MembimbingPraktikPkkPblKlinikController;
use App\Http\Controllers\R06MengujiUjianOscaController;
use App\Http\Controllers\R07MembimbingSkripsiLtaLaProfesiController;
use App\Http\Controllers\R08MengujiSeminarProposalKtiLtaSkripsiController;
use App\Http\Controllers\R09MengujiSeminarHasilKtiLtaSkripsiController;
use App\Http\Controllers\R10MenulisBukuAjarBerisbnController;
use App\Http\Controllers\R11MengembangkanModulBerisbnController;
use App\Http\Controllers\R12MembimbingPkmController;
use App\Http\Controllers\R13OrasiIlmiahNarasumberBidangIlmuController;




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

    Route::get('/manajemen_data_dosen/{pegawai:slug}/riwayat_jabatan_fungsional', 'riwayatJabatanFungsional')->name('dosen.riwayat_jabatan_fungsional');
    Route::patch('/manajemen_data_dosen/riwayat_jabatan_fungsional', 'updateRiwayatJabatanFungsional')->name('dosen.riwayat_jabatan_fungsional.update');
    Route::post('/manajemen_data_dosen/{pegawai:slug}/riwayat_jabatan_fungsional', 'storeRiwayatJabatanFungsional')->name('dosen.riwayat_jabatan_fungsional.store');
    Route::patch('/manajemen_data_dosen/{pegawai:slug}/aktifkan_riwayat_jabatan_fungsional/{jabatanFungsional}', 'setActiveRiwayatJabatanFungsional')->name('dosen.riwayat_jabatan_fungsional.set_active');
    Route::patch('/manajemen_data_dosen/{pegawai:slug}/non_aktifkan_riwayat_jabatan_fungsional/{jabatanFungsional}', 'setNonActiveRiwayatJabatanFungsional')->name('dosen.riwayat_jabatan_fungsional.set_nonactive');
    Route::delete('/manajemen_data_dosen/{pegawai:slug}/riwayat_jabatan_fungsional/{jabatanFungsional}', 'deleteRiwayatJabatanFungsional')->name('dosen.riwayat_jabatan_fungsional.delete');

    Route::get('/manajemen_data_dosen/{pegawai:slug}/riwayat_pangkat_golongan', 'riwayatPangkatGolongan')->name('dosen.riwayat_pangkat_golongan');
    Route::patch('/manajemen_data_dosen/riwayat_pangkat_golongan', 'updateRiwayatPangkatGolongan')->name('dosen.riwayat_pangkat_golongan.update');
    Route::post('/manajemen_data_dosen/{pegawai:slug}/riwayat_pangkat_golongan', 'storeRiwayatPangkatGolongan')->name('dosen.riwayat_pangkat_golongan.store');
    Route::patch('/manajemen_data_dosen/{pegawai:slug}/riwayat_pangkat_golongan/{pangkatGolongan}', 'setActiveRiwayatPangkatGolongan')->name('dosen.riwayat_pangkat_golongan.set_active');
    Route::delete('/manajemen_data_dosen/{pegawai:slug}/riwayat_pangkat_golongan/{pangkatGolongan}', 'deleteRiwayatPangkatGolongan')->name('dosen.riwayat_pangkat_golongan.delete');
    
    Route::get('/manajemen_data_dosen/{pegawai:slug}/riwayat_jabatan_dt', 'riwayatJabatanDt')->name('dosen.riwayat_jabatan_dt');
    Route::patch('/manajemen_data_dosen/riwayat_jabatan_dt', 'updateRiwayatJabatanDt')->name('dosen.riwayat_jabatan_dt.update');
    Route::post('/manajemen_data_dosen/{pegawai:slug}/riwayat_jabatan_dt', 'storeRiwayatJabatanDt')->name('dosen.riwayat_jabatan_dt.store');
    Route::patch('/manajemen_data_dosen/{pegawai:slug}/aktifkan_riwayat_jabatan_dt/{jabatanDt}', 'setActiveRiwayatJabatanDt')->name('dosen.riwayat_jabatan_dt.set_active');
    Route::patch('/manajemen_data_dosen/{pegawai:slug}/non_aktifkan_riwayat_jabatan_dt/{jabatanDt}', 'setNonActiveRiwayatJabatanDt')->name('dosen.riwayat_jabatan_dt.set_nonactive');
    Route::delete('/manajemen_data_dosen/{pegawai:slug}/delete_riwayat_jabatan_dt/{jabatanDt}', 'deleteRiwayatJabatanDt')->name('dosen.riwayat_jabatan_dt.delete');
});

Route::controller(JabatanDtController::class)->group(function () {
    Route::get('/manajemen_jabatan_dt', 'index')->name('jabatan_dt');
    Route::get('/manajemen_jabatan_dt/create', 'create')->name('jabatan_dt.create');
    Route::post('/manajemen_jabatan_dt', 'store')->name('jabatan_dt.store');
    Route::get('/manajemen_jabatan_dt/{jabatandt:slug}/edit', 'edit')->name('jabatan_dt.edit');
    Route::patch('/manajemen_jabatan_dt/{jabatandt:slug}/update', 'update')->name('jabatan_dt.update');
    Route::delete('/manajemen_jabatan_dt/{jabatandt}/delete', 'delete')->name('jabatan_dt.delete');
});
Route::controller(JabatanDsController::class)->group(function () {
    Route::get('/manajemen_jabatan_ds', 'index')->name('jabatan_ds');
    Route::get('/manajemen_jabatan_ds/create', 'create')->name('jabatan_ds.create');
    Route::post('/manajemen_jabatan_ds', 'store')->name('jabatan_ds.store');
    Route::get('/manajemen_jabatan_ds/{jabatands:slug}/edit', 'edit')->name('jabatan_ds.edit');
    Route::patch('/manajemen_jabatan_ds/{jabatands:slug}/update', 'update')->name('jabatan_ds.update');
    Route::delete('/manajemen_jabatan_ds/{jabatands}/delete', 'delete')->name('jabatan_ds.delete');
});
// Route::controller(JabatanFungsionalController::class)->group(function () {
//     Route::get('/manajemen_jabatan_fungsional', 'index')->name('jabatan_fungsional');
//     Route::get('/manajemen_jabatan_fungsional/create', 'create')->name('jabatan_fungsional.create');
//     Route::post('/manajemen_jabatan_fungsional', 'store')->name('jabatan_fungsional.store');
//     Route::patch('/manajemen_jabatan_fungsional/{jabatanfungsional}/set_active', 'setActive')->name('jabatan_fungsional.set_active');
//     Route::patch('/manajemen_jabatan_fungsional/{jabatanfungsional}/set_nonactive', 'setnonActive')->name('jabatan_fungsional.set_nonactive');
//     Route::get('/manajemen_jabatan_fungsional/{jabatanfungsional:slug}/edit', 'edit')->name('jabatan_fungsional.edit');
//     Route::patch('/manajemen_jabatan_fungsional/{jabatanfungsional:slug}/update', 'update')->name('jabatan_fungsional.update');
//     Route::delete('/manajemen_jabatan_fungsional/{jabatanfungsional}/delete', 'delete')->name('jabatan_fungsional.delete');
// });

Route::controller(PangkatGolonganController::class)->group(function () {
    Route::get('/manajemen_pangkat_golongan', 'index')->name('pangkat_golongan');
    Route::get('/manajemen_pangkat_golongan/create', 'create')->name('pangkat_golongan.create');
    Route::post('/manajemen_pangkat_golongan', 'store')->name('pangkat_golongan.store');
    Route::patch('/manajemen_pangkat_golongan/{pangkatgolongan}/set_active', 'setActive')->name('pangkat_golongan.set_active');
    Route::patch('/manajemen_pangkat_golongan/{pangkatgolongan}/set_nonactive', 'setnonActive')->name('pangkat_golongan.set_nonactive');
    Route::get('/manajemen_pangkat_golongan/{pangkatgolongan:slug}/edit', 'edit')->name('pangkat_golongan.edit');
    Route::patch('/manajemen_pangkat_golongan/{pangkatgolongan:slug}/update', 'update')->name('pangkat_golongan.update');
    Route::delete('/manajemen_pangkat_golongan/{pangkatgolongan}/delete', 'delete')->name('pangkat_golongan.delete');
});
Route::controller(KelompokRubrikController::class)->group(function () {
    Route::get('/manajemen_kelompok_rubrik', 'index')->name('kelompok_rubrik');
    Route::get('/manajemen_kelompok_rubrik/create', 'create')->name('kelompok_rubrik.create');
    Route::post('/manajemen_kelompok_rubrik', 'store')->name('kelompok_rubrik.store');
    Route::patch('/manajemen_kelompok_rubrik/{kelompokrubrik}/set_active', 'setActive')->name('kelompok_rubrik.set_active');
    Route::patch('/manajemen_kelompok_rubrik/{kelompokrubrik}/set_nonactive', 'setnonActive')->name('kelompok_rubrik.set_nonactive');
    Route::get('/manajemen_kelompok_rubrik/{kelompokrubrik}/edit', 'edit')->name('kelompok_rubrik.edit');
    Route::patch('/manajemen_kelompok_rubrik/update', 'update')->name('kelompok_rubrik.update');
    Route::delete('/manajemen_kelompok_rubrik/{kelompokrubrik}/delete', 'delete')->name('kelompok_rubrik.delete');
});
Route::controller(NilaiEwmpController::class)->group(function () {
    Route::get('/manajemen_nilai_ewmp', 'index')->name('nilai_ewmp');
    Route::get('/manajemen_nilai_ewmp/create', 'create')->name('nilai_ewmp.create');
    Route::post('/manajemen_nilai_ewmp', 'store')->name('nilai_ewmp.store');
    Route::patch('/manajemen_nilai_ewmp/{nilaiewmp}/set_active', 'setActive')->name('nilai_ewmp.set_active');
    Route::patch('/manajemen_nilai_ewmp/{nilaiewmp}/set_nonactive', 'setnonActive')->name('nilai_ewmp.set_nonactive');
    Route::get('/manajemen_nilai_ewmp/{nilaiewmp}/edit', 'edit')->name('nilai_ewmp.edit');
    Route::patch('/manajemen_nilai_ewmp/{nilaiewmp}/update', 'update')->name('nilai_ewmp.update');
    Route::delete('/manajemen_nilai_ewmp/{nilaiewmp}/delete', 'delete')->name('nilai_ewmp.delete');
});
Route::controller(PengumumanController::class)->group(function () {
    Route::get('/manajemen_pengumuman', 'index')->name('pengumuman');
    Route::get('/manajemen_pengumuman/create', 'create')->name('pengumuman.create');
    Route::post('/manajemen_pengumuman', 'store')->name('pengumuman.store');
    Route::patch('/manajemen_pengumuman/{pengumuman}/set_active', 'setActive')->name('pengumuman.set_active');
    Route::patch('/manajemen_pengumuman/{pengumuman}/set_nonactive', 'setnonActive')->name('pengumuman.set_nonactive');
    Route::get('/manajemen_pengumuman/{pengumuman}/edit', 'edit')->name('pengumuman.edit');
    Route::patch('/manajemen_pengumuman/update', 'update')->name('pengumuman.update');
    Route::delete('/manajemen_pengumuman/{pengumuman}/delete', 'delete')->name('pengumuman.delete');
});
Route::controller(PresensiController::class)->group(function () {
    Route::get('/manajemen_presensi', 'index')->name('presensi');
    Route::get('/manajemen_presensi/create', 'create')->name('presensi.create');
    Route::post('/manajemen_presensi', 'store')->name('presensi.store');
    Route::get('/manajemen_presensi/{presensi}/edit', 'edit')->name('presensi.edit');
    Route::patch('/manajemen_presensi/update', 'update')->name('presensi.update');
    Route::delete('/manajemen_presensi/{presensi}/delete', 'delete')->name('presensi.delete');
});
Route::controller(RiwayatJabatanDtController::class)->group(function () {
    Route::get('/manajemen_riwayat_jabatan_dt', 'index')->name('riwayat_jabatan_dt');
    Route::get('/manajemen_riwayat_jabatan_dt/create', 'create')->name('riwayat_jabatan_dt.create');
    Route::post('/manajemen_riwayat_jabatan_dt', 'store')->name('riwayat_jabatan_dt.store');
    Route::patch('/manajemen_riwayat_jabatan_dt/{riwayatjabatandt}/set_active', 'setActive')->name('riwayat_jabatan_dt.set_active');
    Route::patch('/manajemen_riwayat_jabatan_dt/{riwayatjabatandt}/set_nonactive', 'setnonActive')->name('riwayat_jabatan_dt.set_nonactive');
    Route::get('/manajemen_riwayat_jabatan_dt/{riwayatjabatandt:slug}/edit', 'edit')->name('riwayat_jabatan_dt.edit');
    Route::patch('/manajemen_riwayat_jabatan_dt/{riwayatjabatandt:slug}/update', 'update')->name('riwayat_jabatan_dt.update');
    Route::delete('/manajemen_riwayat_jabatan_dt/{riwayatjabatandt}/delete', 'delete')->name('riwayat_jabatan_dt.delete');
});
Route::controller(RiwayatPointController::class)->group(function () {
    Route::get('/manajemen_riwayat_point', 'index')->name('riwayat_point');
    Route::get('/manajemen_riwayat_point/create', 'create')->name('riwayat_point.create');
    Route::post('/manajemen_riwayat_point', 'store')->name('riwayat_point.store');
    Route::get('/manajemen_riwayat_point/{riwayatpoint}/edit', 'edit')->name('riwayat_point.edit');
    Route::patch('/manajemen_riwayat_point/update', 'update')->name('riwayat_point.update');
    Route::delete('/manajemen_riwayat_point/{riwayatpoint}/delete', 'delete')->name('riwayat_point.delete');
});
// End Of Data Master Route

// Pesan & Pengumuman Route
Route::controller(PesanController::class)->group(function () {
    Route::get('/manajemen_data_periode', 'index')->name('periode_penilaian');
    Route::get('/manajemen_data_periode/create', 'create')->name('periode_penilaian.create');
    Route::post('/manajemen_data_periode', 'store')->name('periode_penilaian.store');
    Route::patch('/manajemen_data_periode/{periode}/set_active', 'setActive')->name('periode_penilaian.set_active');
    Route::patch('/manajemen_data_periode/{periode}/set_nonactive', 'setnonActive')->name('periode_penilaian.set_nonactive');
    Route::get('/manajemen_data_periode/{periode}/edit', 'edit')->name('periode_penilaian.edit');
    Route::patch('/manajemen_data_periode/update', 'update')->name('periode_penilaian.update');
    Route::delete('/manajemen_data_periode/{periode}/delete', 'delete')->name('periode_penilaian.delete');
});
// End Of Pesan & Pengumuman Route


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

// Pengaturan/Setting Rubrik Pendidikan
Route::controller(R01PerkuliahanTeoriController::class)->group(function () {
    Route::get('/r_01_perkuliahan_teori', 'index')->name('r_01_perkuliahan_teori');
    Route::get('/r_01_perkuliahan_teori/create', 'create')->name('r_01_perkuliahan_teori.create');
    Route::post('/r_01_perkuliahan_teori', 'store')->name('r_01_perkuliahan_teori.store');
    Route::patch('/r_01_perkuliahan_teori/{r01perkuliahanteori}/bkdset_active', 'bkdSetActive')->name('r_01_perkuliahan_teori.bkd_set_active');
    Route::patch('/r_01_perkuliahan_teori/{r01perkuliahanteori}/bkdset_nonactive', 'bkdSetnonActive')->name('r_01_perkuliahan_teori.bkd_set_nonactive');
    Route::get('/r_01_perkuliahan_teori/{r01perkuliahanteori}/edit', 'edit')->name('r_01_perkuliahan_teori.edit');
    Route::patch('/r_01_perkuliahan_teori/update', 'update')->name('r_01_perkuliahan_teori.update');
    Route::delete('/r_01_perkuliahan_teori/{r01perkuliahanteori}/delete', 'delete')->name('r_01_perkuliahan_teori.delete');
});
Route::controller(R02PerkuliahanPraktikumController::class)->group(function () {
    Route::get('/r_02_perkuliahan_praktikum', 'index')->name('r_02_perkuliahan_praktikum');
    Route::get('/r_02_perkuliahan_praktikum/create', 'create')->name('r_02_perkuliahan_praktikum.create');
    Route::post('/r_02_perkuliahan_praktikum', 'store')->name('r_02_perkuliahan_praktikum.store');
    Route::patch('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/bkdset_active', 'bkdSetActive')->name('r_02_perkuliahan_praktikum.bkd_set_active');
    Route::patch('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/bkdset_nonactive', 'bkdSetnonActive')->name('r_02_perkuliahan_praktikum.bkd_set_nonactive');
    Route::get('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/edit', 'edit')->name('r_02_perkuliahan_praktikum.edit');
    Route::patch('/r_02_perkuliahan_praktikum/update', 'update')->name('r_02_perkuliahan_praktikum.update');
    Route::delete('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/delete', 'delete')->name('r_02_perkuliahan_praktikum.delete');
});
Route::controller(R03MembimbingPencapaianKompetensiController::class)->group(function () {
    Route::get('/r_03_membimbing_pencapaian_kompetensi', 'index')->name('r_03_membimbing_pencapaian_kompetensi');
    Route::get('/r_03_membimbing_pencapaian_kompetensi/create', 'create')->name('r_03_membimbing_pencapaian_kompetensi.create');
    Route::post('/r_03_membimbing_pencapaian_kompetensi', 'store')->name('r_03_membimbing_pencapaian_kompetensi.store');
    Route::patch('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/bkdset_active', 'bkdSetActive')->name('r_03_membimbing_pencapaian_kompetensi.bkd_set_active');
    Route::patch('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/bkdset_nonactive', 'bkdSetnonActive')->name('r_03_membimbing_pencapaian_kompetensi.bkd_set_nonactive');
    Route::get('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/edit', 'edit')->name('r_03_membimbing_pencapaian_kompetensi.edit');
    Route::patch('/r_03_membimbing_pencapaian_kompetensi/update', 'update')->name('r_03_membimbing_pencapaian_kompetensi.update');
    Route::delete('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/delete', 'delete')->name('r_03_membimbing_pencapaian_kompetensi.delete');
});
Route::controller(R04MembimbingPendampinganUkomController::class)->group(function () {
    Route::get('/r_04_membimbing_pendampingan_ukom', 'index')->name('r_04_membimbing_pendampingan_ukom');
    Route::get('/r_04_membimbing_pendampingan_ukom/create', 'create')->name('r_04_membimbing_pendampingan_ukom.create');
    Route::post('/r_04_membimbing_pendampingan_ukom', 'store')->name('r_04_membimbing_pendampingan_ukom.store');
    Route::patch('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/bkdset_active', 'bkdSetActive')->name('r_04_membimbing_pendampingan_ukom.bkd_set_active');
    Route::patch('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/bkdset_nonactive', 'bkdSetnonActive')->name('r_04_membimbing_pendampingan_ukom.bkd_set_nonactive');
    Route::get('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/edit', 'edit')->name('r_04_membimbing_pendampingan_ukom.edit');
    Route::patch('/r_04_membimbing_pendampingan_ukom/update', 'update')->name('r_04_membimbing_pendampingan_ukom.update');
    Route::delete('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/delete', 'delete')->name('r_04_membimbing_pendampingan_ukom.delete');
});
Route::controller(R05MembimbingPraktikPkkPblKlinikController::class)->group(function () {
    Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik', 'index')->name('r_05_membimbing_praktik_pkk_pbl_klinik');
    Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik/create', 'create')->name('r_05_membimbing_praktik_pkk_pbl_klinik.create');
    Route::post('/r_05_membimbing_praktik_pkk_pbl_klinik', 'store')->name('r_05_membimbing_praktik_pkk_pbl_klinik.store');
    Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/bkdset_active', 'bkdSetActive')->name('r_05_membimbing_praktik_pkk_pbl_klinik.bkd_set_active');
    Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/bkdset_nonactive', 'bkdSetnonActive')->name('r_05_membimbing_praktik_pkk_pbl_klinik.bkd_set_nonactive');
    Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/edit', 'edit')->name('r_05_membimbing_praktik_pkk_pbl_klinik.edit');
    Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/update', 'update')->name('r_05_membimbing_praktik_pkk_pbl_klinik.update');
    Route::delete('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/delete', 'delete')->name('r_05_membimbing_praktik_pkk_pbl_klinik.delete');
});
Route::controller(R06MengujiUjianOscaController::class)->group(function () {
    Route::get('/r_06_menguji_ujian_osca', 'index')->name('r_06_menguji_ujian_osca');
    Route::get('/r_06_menguji_ujian_osca/create', 'create')->name('r_06_menguji_ujian_osca.create');
    Route::post('/r_06_menguji_ujian_osca', 'store')->name('r_06_menguji_ujian_osca.store');
    Route::patch('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/bkdset_active', 'bkdSetActive')->name('r_06_menguji_ujian_osca.bkd_set_active');
    Route::patch('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/bkdset_nonactive', 'bkdSetnonActive')->name('r_06_menguji_ujian_osca.bkd_set_nonactive');
    Route::get('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/edit', 'edit')->name('r_06_menguji_ujian_osca.edit');
    Route::patch('/r_06_menguji_ujian_osca/update', 'update')->name('r_06_menguji_ujian_osca.update');
    Route::delete('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/delete', 'delete')->name('r_06_menguji_ujian_osca.delete');
});
Route::controller(R07MembimbingSkripsiLtaLaProfesiController::class)->group(function () {
    Route::get('/r_07_membimbing_skripsi_lta_la_profesi', 'index')->name('r_07_membimbing_skripsi_lta_la_profesi');
    Route::get('/r_07_membimbing_skripsi_lta_la_profesi/create', 'create')->name('r_07_membimbing_skripsi_lta_la_profesi.create');
    Route::post('/r_07_membimbing_skripsi_lta_la_profesi', 'store')->name('r_07_membimbing_skripsi_lta_la_profesi.store');
    Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/bkdset_active', 'bkdSetActive')->name('r_07_membimbing_skripsi_lta_la_profesi.bkd_set_active');
    Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/bkdset_nonactive', 'bkdSetnonActive')->name('r_07_membimbing_skripsi_lta_la_profesi.bkd_set_nonactive');
    Route::get('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/edit', 'edit')->name('r_07_membimbing_skripsi_lta_la_profesi.edit');
    Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/update', 'update')->name('r_07_membimbing_skripsi_lta_la_profesi.update');
    Route::delete('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/delete', 'delete')->name('r_07_membimbing_skripsi_lta_la_profesi.delete');
});
Route::controller(R08MengujiSeminarProposalKtiLtaSkripsiController::class)->group(function () {
    Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi', 'index')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi');
    Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi/create', 'create')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.create');
    Route::post('/r_08_menguji_seminar_proposal_kti_lta_skripsi', 'store')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.store');
    Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/bkdset_active', 'bkdSetActive')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.bkd_set_active');
    Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/bkdset_nonactive', 'bkdSetnonActive')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.bkd_set_nonactive');
    Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/edit', 'edit')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.edit');
    Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/update', 'update')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.update');
    Route::delete('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/delete', 'delete')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.delete');
});
Route::controller(R09MengujiSeminarHasilKtiLtaSkripsiController::class)->group(function () {
    Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi', 'index')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi');
    Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi/create', 'create')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.create');
    Route::post('/r_09_menguji_seminar_hasil_kti_lta_skripsi', 'store')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.store');
    Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/bkdset_active', 'bkdSetActive')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.bkd_set_active');
    Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/bkdset_nonactive', 'bkdSetnonActive')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.bkd_set_nonactive');
    Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/edit', 'edit')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.edit');
    Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/update', 'update')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.update');
    Route::delete('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/delete', 'delete')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.delete');
});
Route::controller(R10MenulisBukuAjarBerisbnController::class)->group(function () {
    Route::get('/r_010_menulis_buku_ajar_berisbn', 'index')->name('r_010_menulis_buku_ajar_berisbn');
    Route::get('/r_010_menulis_buku_ajar_berisbn/create', 'create')->name('r_010_menulis_buku_ajar_berisbn.create');
    Route::post('/r_010_menulis_buku_ajar_berisbn', 'store')->name('r_010_menulis_buku_ajar_berisbn.store');
    Route::patch('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/bkdset_active', 'bkdSetActive')->name('r_010_menulis_buku_ajar_berisbn.bkd_set_active');
    Route::patch('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/bkdset_nonactive', 'bkdSetnonActive')->name('r_010_menulis_buku_ajar_berisbn.bkd_set_nonactive');
    Route::get('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/edit', 'edit')->name('r_010_menulis_buku_ajar_berisbn.edit');
    Route::patch('/r_010_menulis_buku_ajar_berisbn/update', 'update')->name('r_010_menulis_buku_ajar_berisbn.update');
    Route::delete('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/delete', 'delete')->name('r_010_menulis_buku_ajar_berisbn.delete');
});
Route::controller(R11MengembangkanModulBerisbnController::class)->group(function () {
    Route::get('/r_011_mengembangkan_modul_berisbn', 'index')->name('r_011_mengembangkan_modul_berisbn');
    Route::get('/r_011_mengembangkan_modul_berisbn/create', 'create')->name('r_011_mengembangkan_modul_berisbn.create');
    Route::post('/r_011_mengembangkan_modul_berisbn', 'store')->name('r_011_mengembangkan_modul_berisbn.store');
    Route::patch('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/bkdset_active', 'bkdSetActive')->name('r_011_mengembangkan_modul_berisbn.bkd_set_active');
    Route::patch('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/bkdset_nonactive', 'bkdSetnonActive')->name('r_011_mengembangkan_modul_berisbn.bkd_set_nonactive');
    Route::get('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/edit', 'edit')->name('r_011_mengembangkan_modul_berisbn.edit');
    Route::patch('/r_011_mengembangkan_modul_berisbn/update', 'update')->name('r_011_mengembangkan_modul_berisbn.update');
    Route::delete('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/delete', 'delete')->name('r_011_mengembangkan_modul_berisbn.delete');
});
Route::controller(R12MembimbingPkmController::class)->group(function () {
    Route::get('/r_012_membimbing_pkm', 'index')->name('r_012_membimbing_pkm');
    Route::get('/r_012_membimbing_pkm/create', 'create')->name('r_012_membimbing_pkm.create');
    Route::post('/r_012_membimbing_pkm', 'store')->name('r_012_membimbing_pkm.store');
    Route::patch('/r_012_membimbing_pkm/{r012membimbingpkm}/bkdset_active', 'bkdSetActive')->name('r_012_membimbing_pkm.bkd_set_active');
    Route::patch('/r_012_membimbing_pkm/{r012membimbingpkm}/bkdset_nonactive', 'bkdSetnonActive')->name('r_012_membimbing_pkm.bkd_set_nonactive');
    Route::get('/r_012_membimbing_pkm/{r012membimbingpkm}/edit', 'edit')->name('r_012_membimbing_pkm.edit');
    Route::patch('/r_012_membimbing_pkm/update', 'update')->name('r_012_membimbing_pkm.update');
    Route::delete('/r_012_membimbing_pkm/{r012membimbingpkm}/delete', 'delete')->name('r_012_membimbing_pkm.delete');
});
// End Of Pengaturan/Setting Rubrik Pendidikan
// Pengaturan/Setting Rubrik Pendidikan Insidental
Route::controller(R13OrasiIlmiahNarasumberBidangIlmuController::class)->group(function () {
    Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu', 'index')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu');
    Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/create', 'create')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.create');
    Route::post('/r_013_orasi_ilmiah_narasumber_bidang_ilmu', 'store')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.store');
    Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/bkdset_active', 'bkdSetActive')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.bkd_set_active');
    Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/bkdset_nonactive', 'bkdSetnonActive')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.bkd_set_nonactive');
    Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/edit', 'edit')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.edit');
    Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/update', 'update')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.update');
    Route::delete('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/delete', 'delete')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.delete');
});
// End Of Pengaturan/Setting Rubrik Pendidikan Insidental
