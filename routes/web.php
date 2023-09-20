<?php

use App\Http\Controllers\AdministratorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanDsController;
use App\Http\Controllers\JabatanDtController;
use App\Http\Controllers\NilaiEwmpController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\VerifikatorController;
use App\Http\Controllers\RiwayatPointController;
use App\Http\Controllers\OauthCallbackController;
use App\Http\Controllers\KelompokRubrikController;
use App\Http\Controllers\PangkatGolonganController;
use App\Http\Controllers\R14KaryaInovasiController;
use App\Http\Controllers\PointRubrikDosenController;
use App\Http\Controllers\R12MembimbingPkmController;
use App\Http\Controllers\R30PengelolaKepkController;
use App\Http\Controllers\RiwayatJabatanDtController;
use App\Http\Controllers\R20AssessorBkdLkdController;
use App\Http\Controllers\GeneratePointRubrikController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\R01PerkuliahanTeoriController;
use App\Http\Controllers\R06MengujiUjianOscaController;
use App\Http\Controllers\R18MendapatHibahPkmController;
use App\Http\Controllers\R27KeanggotaanSenatController;
use App\Http\Controllers\R02PerkuliahanPraktikumController;
use App\Http\Controllers\R29MemperolehPenghargaanController;
use App\Http\Controllers\R10MenulisBukuAjarBerisbnController;
use App\Http\Controllers\R26PengelolaJurnalBuletinController;
use App\Http\Controllers\R11MengembangkanModulBerisbnController;
use App\Http\Controllers\R04MembimbingPendampinganUkomController;
use App\Http\Controllers\R24TimAkredProdiDanDirektoratController;
use App\Http\Controllers\R22ReviewerEclerePenelitianMhsController;
use App\Http\Controllers\R19LatihNyuluhNatarCeramahWargaController;
use App\Http\Controllers\R25KepanitiaanKegiatanInstitusiController;
use App\Http\Controllers\R28MelaksanakanPengembanganDiriController;
use App\Http\Controllers\R05MembimbingPraktikPkkPblKlinikController;
use App\Http\Controllers\R07MembimbingSkripsiLtaLaProfesiController;
use App\Http\Controllers\R17NaskahBukuBahasaTerbitEdarNasController;
use App\Http\Controllers\R21ReviewerEclerePenelitianDosenController;
use App\Http\Controllers\R03MembimbingPencapaianKompetensiController;
use App\Http\Controllers\R13OrasiIlmiahNarasumberBidangIlmuController;
use App\Http\Controllers\R16NaskahBukuBahasaTerbitEdarInterController;
use App\Http\Controllers\R09MengujiSeminarHasilKtiLtaSkripsiController;
use App\Http\Controllers\R15MenulisKaryaIlmiahDipublikasikanController;
use App\Http\Controllers\R23AuditorMutuAssessorAkredInternalController;
use App\Http\Controllers\R08MengujiSeminarProposalKtiLtaSkripsiController;
use App\Http\Controllers\RekapDaftarNominatifController;
use App\Http\Controllers\RoleController;

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
})->name('home');

Route::get('/oauth-callback',[OauthCallbackController::class, 'oAuthCallback'])->name('oAuthCallback');
Route::get('/logoutDosen',function(){
    session_start();
    session_destroy();
    return redirect()->route('home');
})->name('logoutDosen');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home',[DashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(SessionController::class)->group(function () {
        Route::get('/cari_dosen', 'cariDosen')->name('cari_dosen');
        Route::post('/cari_dosen', 'cari')->name('cari_dosen.post');
        Route::get('/cari_dosen/get_data_dosen','getDataDosen')->name('cari_dosen.get_data_dosen');
        Route::get('/remove_session','removeSession')->name('cari_dosen.remove_session');
    });

    Route::controller(ProdiController::class)->group(function () {
        Route::get('/data_program_studi', 'index')->name('prodi');
        Route::get('/data_program_studi/generate', 'generate')->name('prodi.generate');
        Route::get('/data_program_studi/{prodi:id_prodi}/data_dosen', 'dataDosen')->name('prodi.dosens');
    });

    // Master Data Route
    Route::controller(PegawaiController::class)->group(function () {
        Route::get('/manajemen_data_dosen', 'index')->name('dosen');
        Route::get('/manajemen_data_dosen/create', 'create')->name('dosen.create');
        Route::post('/manajemen_data_dosen', 'store')->name('dosen.store');
        Route::patch('/manajemen_data_dosen/{dosen}/set_active', 'setActive')->name('dosen.set_active');
        Route::patch('/manajemen_data_dosen/{dosen}/set_nonactive', 'setnonActive')->name('dosen.set_nonactive');
        Route::get('/manajemen_data_dosen/{pegawai:slug}/edit', 'edit')->name('dosen.edit');
        Route::patch('/manajemen_data_dosen/{pegawai:slug}/update', 'update')->name('dosen.update');
        Route::get('/manajemen_data_dosen/generate_siakad', 'generateSiakad')->name('dosen.generateSiakad');

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

    Route::controller(GeneratePointRubrikController::class)->group(function () {
        Route::get('/generate_point_rubrik', 'index')->name('generate_point_rubrik');
        Route::get('/generate_point_rubrik/generate', 'generate')->name('generate_point_rubrik.generate');
        Route::get('/generate_point_per_rubrik/{rekapPerRubrik:kode_rubrik}/generate', 'rekapPointPerRubrik')->name('generate_point_per_rubrik');
        Route::get('/isian_rubrik/{rekapPerRubrik:kode_rubrik}/detail', 'detailIsianRubrik')->name('detail_isian_rubrik');
        Route::patch('/generate_point_massal', 'generatePointMassal')->name('generate_point_massal');
    });

    Route::controller(PointRubrikDosenController::class)->group(function () {
        Route::get('/point_rubrik_dosen', 'index')->name('point_rubrik_dosen');
        Route::get('/point_rubrik_dosen/{dosen}/detail', 'pointDetail')->name('point_rubrik_dosen.detail');
    });

    Route::controller(RekapDaftarNominatifController::class)->group(function () {
        Route::get('/laporan_keuangan', 'index')->name('laporan_keuangan');
        Route::get('/laporan_keuangan/{dosen}/detail', 'pointDetail')->name('laporan_keuangan.detail');
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
        Route::get('/r_01_perkuliahan_teori/{r01perkuliahanteori}/edit', 'edit')->name('r_01_perkuliahan_teori.edit');
        Route::patch('/r_01_perkuliahan_teori/update', 'update')->name('r_01_perkuliahan_teori.update');
        Route::delete('/r_01_perkuliahan_teori/{r01perkuliahanteori}/delete', 'delete')->name('r_01_perkuliahan_teori.delete');
        Route::patch('/r_01_perkuliahan_teori/{r01perkuliahanteori}/verifikasi', 'verifikasi')->name('r_01_perkuliahan_teori.verifikasi');
        Route::patch('/r_01_perkuliahan_teori/{r01perkuliahanteori}/tolak', 'tolak')->name('r_01_perkuliahan_teori.tolak');
    });
    Route::controller(R02PerkuliahanPraktikumController::class)->group(function () {
        Route::get('/r_02_perkuliahan_praktikum', 'index')->name('r_02_perkuliahan_praktikum');
        Route::get('/r_02_perkuliahan_praktikum/create', 'create')->name('r_02_perkuliahan_praktikum.create');
        Route::post('/r_02_perkuliahan_praktikum', 'store')->name('r_02_perkuliahan_praktikum.store');
        Route::get('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/edit', 'edit')->name('r_02_perkuliahan_praktikum.edit');
        Route::patch('/r_02_perkuliahan_praktikum/update', 'update')->name('r_02_perkuliahan_praktikum.update');
        Route::delete('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/delete', 'delete')->name('r_02_perkuliahan_praktikum.delete');
        Route::patch('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/verifikasi', 'verifikasi')->name('r_02_perkuliahan_praktikum.verifikasi');
        Route::patch('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/tolak', 'tolak')->name('r_02_perkuliahan_praktikum.tolak');
    });
    Route::controller(R03MembimbingPencapaianKompetensiController::class)->group(function () {
        Route::get('/r_03_membimbing_pencapaian_kompetensi', 'index')->name('r_03_membimbing_pencapaian_kompetensi');
        Route::get('/r_03_membimbing_pencapaian_kompetensi/create', 'create')->name('r_03_membimbing_pencapaian_kompetensi.create');
        Route::post('/r_03_membimbing_pencapaian_kompetensi', 'store')->name('r_03_membimbing_pencapaian_kompetensi.store');
        Route::get('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/edit', 'edit')->name('r_03_membimbing_pencapaian_kompetensi.edit');
        Route::patch('/r_03_membimbing_pencapaian_kompetensi/update', 'update')->name('r_03_membimbing_pencapaian_kompetensi.update');
        Route::delete('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/delete', 'delete')->name('r_03_membimbing_pencapaian_kompetensi.delete');
        Route::patch('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/verifikasi', 'verifikasi')->name('r_03_membimbing_pencapaian_kompetensi.verifikasi');
        Route::patch('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/tolak', 'tolak')->name('r_03_membimbing_pencapaian_kompetensi.tolak');
    });
    Route::controller(R04MembimbingPendampinganUkomController::class)->group(function () {
        Route::get('/r_04_membimbing_pendampingan_ukom', 'index')->name('r_04_membimbing_pendampingan_ukom');
        Route::get('/r_04_membimbing_pendampingan_ukom/create', 'create')->name('r_04_membimbing_pendampingan_ukom.create');
        Route::post('/r_04_membimbing_pendampingan_ukom', 'store')->name('r_04_membimbing_pendampingan_ukom.store');
        Route::get('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/edit', 'edit')->name('r_04_membimbing_pendampingan_ukom.edit');
        Route::patch('/r_04_membimbing_pendampingan_ukom/update', 'update')->name('r_04_membimbing_pendampingan_ukom.update');
        Route::delete('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/delete', 'delete')->name('r_04_membimbing_pendampingan_ukom.delete');
        Route::patch('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/verifikasi', 'verifikasi')->name('r_04_membimbing_pendampingan_ukom.verifikasi');
        Route::patch('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/tolak', 'tolak')->name('r_04_membimbing_pendampingan_ukom.tolak');
    });
    Route::controller(R05MembimbingPraktikPkkPblKlinikController::class)->group(function () {
        Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik', 'index')->name('r_05_membimbing_praktik_pkk_pbl_klinik');
        Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik/create', 'create')->name('r_05_membimbing_praktik_pkk_pbl_klinik.create');
        Route::post('/r_05_membimbing_praktik_pkk_pbl_klinik', 'store')->name('r_05_membimbing_praktik_pkk_pbl_klinik.store');
        Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/edit', 'edit')->name('r_05_membimbing_praktik_pkk_pbl_klinik.edit');
        Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/update', 'update')->name('r_05_membimbing_praktik_pkk_pbl_klinik.update');
        Route::delete('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/delete', 'delete')->name('r_05_membimbing_praktik_pkk_pbl_klinik.delete');
        Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/verifikasi', 'verifikasi')->name('r_05_membimbing_praktik_pkk_pbl_klinik.verifikasi');
        Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/tolak', 'tolak')->name('r_05_membimbing_praktik_pkk_pbl_klinik.tolak');
    });
    Route::controller(R06MengujiUjianOscaController::class)->group(function () {
        Route::get('/r_06_menguji_ujian_osca', 'index')->name('r_06_menguji_ujian_osca');
        Route::get('/r_06_menguji_ujian_osca/create', 'create')->name('r_06_menguji_ujian_osca.create');
        Route::post('/r_06_menguji_ujian_osca', 'store')->name('r_06_menguji_ujian_osca.store');
        Route::get('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/edit', 'edit')->name('r_06_menguji_ujian_osca.edit');
        Route::patch('/r_06_menguji_ujian_osca/update', 'update')->name('r_06_menguji_ujian_osca.update');
        Route::delete('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/delete', 'delete')->name('r_06_menguji_ujian_osca.delete');
        Route::patch('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/verifikasi', 'verifikasi')->name('r_06_menguji_ujian_osca.verifikasi');
        Route::patch('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/tolak', 'tolak')->name('r_06_menguji_ujian_osca.tolak');
    });
    Route::controller(R07MembimbingSkripsiLtaLaProfesiController::class)->group(function () {
        Route::get('/r_07_membimbing_skripsi_lta_la_profesi', 'index')->name('r_07_membimbing_skripsi_lta_la_profesi');
        Route::get('/r_07_membimbing_skripsi_lta_la_profesi/create', 'create')->name('r_07_membimbing_skripsi_lta_la_profesi.create');
        Route::post('/r_07_membimbing_skripsi_lta_la_profesi', 'store')->name('r_07_membimbing_skripsi_lta_la_profesi.store');
        Route::get('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/edit', 'edit')->name('r_07_membimbing_skripsi_lta_la_profesi.edit');
        Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/update', 'update')->name('r_07_membimbing_skripsi_lta_la_profesi.update');
        Route::delete('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/delete', 'delete')->name('r_07_membimbing_skripsi_lta_la_profesi.delete');
        Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/verifikasi', 'verifikasi')->name('r_07_membimbing_skripsi_lta_la_profesi.verifikasi');
        Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/tolak', 'tolak')->name('r_07_membimbing_skripsi_lta_la_profesi.tolak');
    });
    Route::controller(R08MengujiSeminarProposalKtiLtaSkripsiController::class)->group(function () {
        Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi', 'index')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi');
        Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi/create', 'create')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.create');
        Route::post('/r_08_menguji_seminar_proposal_kti_lta_skripsi', 'store')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.store');
        Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/edit', 'edit')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.edit');
        Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/update', 'update')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.update');
        Route::delete('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/delete', 'delete')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.delete');
        Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/verifikasi', 'verifikasi')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.verifikasi');
        Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/tolak', 'tolak')->name('r_08_menguji_seminar_proposal_kti_lta_skripsi.tolak');
    });
    Route::controller(R09MengujiSeminarHasilKtiLtaSkripsiController::class)->group(function () {
        Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi', 'index')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi');
        Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi/create', 'create')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.create');
        Route::post('/r_09_menguji_seminar_hasil_kti_lta_skripsi', 'store')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.store');
        Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/edit', 'edit')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.edit');
        Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/update', 'update')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.update');
        Route::delete('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/delete', 'delete')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.delete');
        Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/verifikasi', 'verifikasi')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.verifikasi');
        Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/tolak', 'tolak')->name('r_09_menguji_seminar_hasil_kti_lta_skripsi.tolak');
    });
    Route::controller(R10MenulisBukuAjarBerisbnController::class)->group(function () {
        Route::get('/r_010_menulis_buku_ajar_berisbn', 'index')->name('r_010_menulis_buku_ajar_berisbn');
        Route::get('/r_010_menulis_buku_ajar_berisbn/create', 'create')->name('r_010_menulis_buku_ajar_berisbn.create');
        Route::post('/r_010_menulis_buku_ajar_berisbn', 'store')->name('r_010_menulis_buku_ajar_berisbn.store');
        Route::get('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/edit', 'edit')->name('r_010_menulis_buku_ajar_berisbn.edit');
        Route::patch('/r_010_menulis_buku_ajar_berisbn/update', 'update')->name('r_010_menulis_buku_ajar_berisbn.update');
        Route::delete('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/delete', 'delete')->name('r_010_menulis_buku_ajar_berisbn.delete');
        Route::patch('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/verifikasi', 'verifikasi')->name('r_010_menulis_buku_ajar_berisbn.verifikasi');
        Route::patch('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/tolak', 'tolak')->name('r_010_menulis_buku_ajar_berisbn.tolak');
    });
    Route::controller(R11MengembangkanModulBerisbnController::class)->group(function () {
        Route::get('/r_011_mengembangkan_modul_berisbn', 'index')->name('r_011_mengembangkan_modul_berisbn');
        Route::get('/r_011_mengembangkan_modul_berisbn/create', 'create')->name('r_011_mengembangkan_modul_berisbn.create');
        Route::post('/r_011_mengembangkan_modul_berisbn', 'store')->name('r_011_mengembangkan_modul_berisbn.store');
        Route::get('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/edit', 'edit')->name('r_011_mengembangkan_modul_berisbn.edit');
        Route::patch('/r_011_mengembangkan_modul_berisbn/update', 'update')->name('r_011_mengembangkan_modul_berisbn.update');
        Route::delete('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/delete', 'delete')->name('r_011_mengembangkan_modul_berisbn.delete');
        Route::patch('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/verifikasi', 'verifikasi')->name('r_011_mengembangkan_modul_berisbn.verifikasi');
        Route::patch('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/tolak', 'tolak')->name('r_011_mengembangkan_modul_berisbn.tolak');
    });
    Route::controller(R12MembimbingPkmController::class)->group(function () {
        Route::get('/r_012_membimbing_pkm', 'index')->name('r_012_membimbing_pkm');
        Route::get('/r_012_membimbing_pkm/create', 'create')->name('r_012_membimbing_pkm.create');
        Route::post('/r_012_membimbing_pkm', 'store')->name('r_012_membimbing_pkm.store');
        Route::get('/r_012_membimbing_pkm/{r012membimbingpkm}/edit', 'edit')->name('r_012_membimbing_pkm.edit');
        Route::patch('/r_012_membimbing_pkm/update', 'update')->name('r_012_membimbing_pkm.update');
        Route::delete('/r_012_membimbing_pkm/{r012membimbingpkm}/delete', 'delete')->name('r_012_membimbing_pkm.delete');
        Route::patch('/r_012_membimbing_pkm/{r012membimbingpkm}/verifikasi', 'verifikasi')->name('r_012_membimbing_pkm.verifikasi');
        Route::patch('/r_012_membimbing_pkm/{r012membimbingpkm}/tolak', 'tolak')->name('r_012_membimbing_pkm.tolak');
    });
    // End Of Pengaturan/Setting Rubrik Pendidikan
    // Pengaturan/Setting Rubrik Pendidikan Insidental
    Route::controller(R13OrasiIlmiahNarasumberBidangIlmuController::class)->group(function () {
        Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu', 'index')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu');
        Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/create', 'create')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.create');
        Route::post('/r_013_orasi_ilmiah_narasumber_bidang_ilmu', 'store')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.store');
        Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/edit', 'edit')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.edit');
        Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/update', 'update')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.update');
        Route::delete('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/delete', 'delete')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.delete');
        Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/verifikasi', 'verifikasi')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.verifikasi');
        Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/tolak', 'tolak')->name('r_013_orasi_ilmiah_narasumber_bidang_ilmu.tolak');
    });
    Route::controller(R14KaryaInovasiController::class)->group(function () {
        Route::get('/r_014_karya_inovasi', 'index')->name('r_014_karya_inovasi');
        Route::get('/r_014_karya_inovasi/create', 'create')->name('r_014_karya_inovasi.create');
        Route::post('/r_014_karya_inovasi', 'store')->name('r_014_karya_inovasi.store');
        Route::get('/r_014_karya_inovasi/{r014karyainovasi}/edit', 'edit')->name('r_014_karya_inovasi.edit');
        Route::patch('/r_014_karya_inovasi/update', 'update')->name('r_014_karya_inovasi.update');
        Route::delete('/r_014_karya_inovasi/{r014karyainovasi}/delete', 'delete')->name('r_014_karya_inovasi.delete');
        Route::patch('/r_014_karya_inovasi/{r014karyainovasi}/verifikasi', 'verifikasi')->name('r_014_karya_inovasi.verifikasi');
        Route::patch('/r_014_karya_inovasi/{r014karyainovasi}/tolak', 'tolak')->name('r_014_karya_inovasi.tolak');
    });
    // End Of Pengaturan/Setting Rubrik Pendidikan Insidental
    // Pengaturan/Setting Rubrik Penelitian
    Route::controller(R15MenulisKaryaIlmiahDipublikasikanController::class)->group(function () {
        Route::get('/r_015_menulis_karya_ilmiah_dipublikasikan', 'index')->name('r_015_menulis_karya_ilmiah_dipublikasikan');
        Route::get('/r_015_menulis_karya_ilmiah_dipublikasikan/create', 'create')->name('r_015_menulis_karya_ilmiah_dipublikasikan.create');
        Route::post('/r_015_menulis_karya_ilmiah_dipublikasikan', 'store')->name('r_015_menulis_karya_ilmiah_dipublikasikan.store');
        Route::get('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/edit', 'edit')->name('r_015_menulis_karya_ilmiah_dipublikasikan.edit');
        Route::patch('/r_015_menulis_karya_ilmiah_dipublikasikan/update', 'update')->name('r_015_menulis_karya_ilmiah_dipublikasikan.update');
        Route::delete('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/delete', 'delete')->name('r_015_menulis_karya_ilmiah_dipublikasikan.delete');
        Route::patch('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/verifikasi', 'verifikasi')->name('r_015_menulis_karya_ilmiah_dipublikasikan.verifikasi');
        Route::patch('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/tolak', 'tolak')->name('r_015_menulis_karya_ilmiah_dipublikasikan.tolak');
    });
    Route::controller(R16NaskahBukuBahasaTerbitEdarInterController::class)->group(function () {
        Route::get('/r_016_naskah_buku_bahasa_terbit_edar_inter', 'index')->name('r_016_naskah_buku_bahasa_terbit_edar_inter');
        Route::get('/r_016_naskah_buku_bahasa_terbit_edar_inter/create', 'create')->name('r_016_naskah_buku_bahasa_terbit_edar_inter.create');
        Route::post('/r_016_naskah_buku_bahasa_terbit_edar_inter', 'store')->name('r_016_naskah_buku_bahasa_terbit_edar_inter.store');
        Route::get('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/edit', 'edit')->name('r_016_naskah_buku_bahasa_terbit_edar_inter.edit');
        Route::patch('/r_016_naskah_buku_bahasa_terbit_edar_inter/update', 'update')->name('r_016_naskah_buku_bahasa_terbit_edar_inter.update');
        Route::delete('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/delete', 'delete')->name('r_016_naskah_buku_bahasa_terbit_edar_inter.delete');
        Route::patch('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/verifikasi', 'verifikasi')->name('r_016_naskah_buku_bahasa_terbit_edar_inter.verifikasi');
        Route::patch('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/tolak', 'tolak')->name('r_016_naskah_buku_bahasa_terbit_edar_inter.tolak');
    });
    Route::controller(R17NaskahBukuBahasaTerbitEdarNasController::class)->group(function () {
        Route::get('/r_017_naskah_buku_bahasa_terbit_edar_nas', 'index')->name('r_017_naskah_buku_bahasa_terbit_edar_nas');
        Route::get('/r_017_naskah_buku_bahasa_terbit_edar_nas/create', 'create')->name('r_017_naskah_buku_bahasa_terbit_edar_nas.create');
        Route::post('/r_017_naskah_buku_bahasa_terbit_edar_nas', 'store')->name('r_017_naskah_buku_bahasa_terbit_edar_nas.store');
        Route::get('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/edit', 'edit')->name('r_017_naskah_buku_bahasa_terbit_edar_nas.edit');
        Route::patch('/r_017_naskah_buku_bahasa_terbit_edar_nas/update', 'update')->name('r_017_naskah_buku_bahasa_terbit_edar_nas.update');
        Route::delete('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/delete', 'delete')->name('r_017_naskah_buku_bahasa_terbit_edar_nas.delete');
        Route::patch('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/verifikasi', 'verifikasi')->name('r_017_naskah_buku_bahasa_terbit_edar_nas.verifikasi');
        Route::patch('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/tolak', 'tolak')->name('r_017_naskah_buku_bahasa_terbit_edar_nas.tolak');
    });
    // End Of Pengaturan/Setting Rubrik Penelitian
    // Pengaturan/Setting Rubrik Pengabdian
    Route::controller(R18MendapatHibahPkmController::class)->group(function () {
        Route::get('/r_018_mendapat_hibah_pkm', 'index')->name('r_018_mendapat_hibah_pkm');
        Route::get('/r_018_mendapat_hibah_pkm/create', 'create')->name('r_018_mendapat_hibah_pkm.create');
        Route::post('/r_018_mendapat_hibah_pkm', 'store')->name('r_018_mendapat_hibah_pkm.store');
        Route::get('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/edit', 'edit')->name('r_018_mendapat_hibah_pkm.edit');
        Route::patch('/r_018_mendapat_hibah_pkm/update', 'update')->name('r_018_mendapat_hibah_pkm.update');
        Route::delete('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/delete', 'delete')->name('r_018_mendapat_hibah_pkm.delete');
        Route::patch('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/verifikasi', 'verifikasi')->name('r_018_mendapat_hibah_pkm.verifikasi');
        Route::patch('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/tolak', 'tolak')->name('r_018_mendapat_hibah_pkm.tolak');
    });
    Route::controller(R19LatihNyuluhNatarCeramahWargaController::class)->group(function () {
        Route::get('/r_019_latih_nyuluh_natar_ceramah_warga', 'index')->name('r_019_latih_nyuluh_natar_ceramah_warga');
        Route::get('/r_019_latih_nyuluh_natar_ceramah_warga/create', 'create')->name('r_019_latih_nyuluh_natar_ceramah_warga.create');
        Route::post('/r_019_latih_nyuluh_natar_ceramah_warga', 'store')->name('r_019_latih_nyuluh_natar_ceramah_warga.store');
        Route::get('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/edit', 'edit')->name('r_019_latih_nyuluh_natar_ceramah_warga.edit');
        Route::patch('/r_019_latih_nyuluh_natar_ceramah_warga/update', 'update')->name('r_019_latih_nyuluh_natar_ceramah_warga.update');
        Route::delete('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/delete', 'delete')->name('r_019_latih_nyuluh_natar_ceramah_warga.delete');
        Route::patch('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/verifikasi', 'verifikasi')->name('r_019_latih_nyuluh_natar_ceramah_warga.verifikasi');
        Route::patch('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/tolak', 'tolak')->name('r_019_latih_nyuluh_natar_ceramah_warga.tolak');
    });
    // End Of Pengaturan/Setting Rubrik Pengabdian
    // Pengaturan/Setting Rubrik Penunjang Kegiatan Akademik Dosen
    Route::controller(R20AssessorBkdLkdController::class)->group(function () {
        Route::get('/r_020_assessor_bkd_lkd', 'index')->name('r_020_assessor_bkd_lkd');
        Route::get('/r_020_assessor_bkd_lkd/create', 'create')->name('r_020_assessor_bkd_lkd.create');
        Route::post('/r_020_assessor_bkd_lkd', 'store')->name('r_020_assessor_bkd_lkd.store');
        Route::get('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/edit', 'edit')->name('r_020_assessor_bkd_lkd.edit');
        Route::patch('/r_020_assessor_bkd_lkd/update', 'update')->name('r_020_assessor_bkd_lkd.update');
        Route::delete('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/delete', 'delete')->name('r_020_assessor_bkd_lkd.delete');
        Route::patch('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/verifikasi', 'verifikasi')->name('r_020_assessor_bkd_lkd.verifikasi');
        Route::patch('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/tolak', 'tolak')->name('r_020_assessor_bkd_lkd.tolak');
    });
    Route::controller(R21ReviewerEclerePenelitianDosenController::class)->group(function () {
        Route::get('/r_021_reviewer_eclere_penelitian_dosen', 'index')->name('r_021_reviewer_eclere_penelitian_dosen');
        Route::get('/r_021_reviewer_eclere_penelitian_dosen/create', 'create')->name('r_021_reviewer_eclere_penelitian_dosen.create');
        Route::post('/r_021_reviewer_eclere_penelitian_dosen', 'store')->name('r_021_reviewer_eclere_penelitian_dosen.store');
        Route::get('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/edit', 'edit')->name('r_021_reviewer_eclere_penelitian_dosen.edit');
        Route::patch('/r_021_reviewer_eclere_penelitian_dosen/update', 'update')->name('r_021_reviewer_eclere_penelitian_dosen.update');
        Route::delete('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/delete', 'delete')->name('r_021_reviewer_eclere_penelitian_dosen.delete');
        Route::patch('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/verifikasi', 'verifikasi')->name('r_021_reviewer_eclere_penelitian_dosen.verifikasi');
        Route::patch('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/tolak', 'tolak')->name('r_021_reviewer_eclere_penelitian_dosen.tolak');
    });
    Route::controller(R22ReviewerEclerePenelitianMhsController::class)->group(function () {
        Route::get('/r_022_reviewer_eclere_penelitian_mhs', 'index')->name('r_022_reviewer_eclere_penelitian_mhs');
        Route::get('/r_022_reviewer_eclere_penelitian_mhs/create', 'create')->name('r_022_reviewer_eclere_penelitian_mhs.create');
        Route::post('/r_022_reviewer_eclere_penelitian_mhs', 'store')->name('r_022_reviewer_eclere_penelitian_mhs.store');
        Route::get('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/edit', 'edit')->name('r_022_reviewer_eclere_penelitian_mhs.edit');
        Route::patch('/r_022_reviewer_eclere_penelitian_mhs/update', 'update')->name('r_022_reviewer_eclere_penelitian_mhs.update');
        Route::delete('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/delete', 'delete')->name('r_022_reviewer_eclere_penelitian_mhs.delete');
        Route::patch('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/verifikasi', 'verifikasi')->name('r_022_reviewer_eclere_penelitian_mhs.verifikasi');
        Route::patch('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/tolak', 'tolak')->name('r_022_reviewer_eclere_penelitian_mhs.tolak');
    });
    Route::controller(R23AuditorMutuAssessorAkredInternalController::class)->group(function () {
        Route::get('/r_023_auditor_mutu_assessor_akred_internal', 'index')->name('r_023_auditor_mutu_assessor_akred_internal');
        Route::get('/r_023_auditor_mutu_assessor_akred_internal/create', 'create')->name('r_023_auditor_mutu_assessor_akred_internal.create');
        Route::post('/r_023_auditor_mutu_assessor_akred_internal', 'store')->name('r_023_auditor_mutu_assessor_akred_internal.store');
        Route::get('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/edit', 'edit')->name('r_023_auditor_mutu_assessor_akred_internal.edit');
        Route::patch('/r_023_auditor_mutu_assessor_akred_internal/update', 'update')->name('r_023_auditor_mutu_assessor_akred_internal.update');
        Route::delete('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/delete', 'delete')->name('r_023_auditor_mutu_assessor_akred_internal.delete');
        Route::patch('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/verifikasi', 'verifikasi')->name('r_023_auditor_mutu_assessor_akred_internal.verifikasi');
        Route::patch('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/tolak', 'tolak')->name('r_023_auditor_mutu_assessor_akred_internal.tolak');
    });
    Route::controller(R24TimAkredProdiDanDirektoratController::class)->group(function () {
        Route::get('/r_024_tim_akred_prodi_dan_direktorat', 'index')->name('r_024_tim_akred_prodi_dan_direktorat');
        Route::get('/r_024_tim_akred_prodi_dan_direktorat/create', 'create')->name('r_024_tim_akred_prodi_dan_direktorat.create');
        Route::post('/r_024_tim_akred_prodi_dan_direktorat', 'store')->name('r_024_tim_akred_prodi_dan_direktorat.store');
        Route::get('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/edit', 'edit')->name('r_024_tim_akred_prodi_dan_direktorat.edit');
        Route::patch('/r_024_tim_akred_prodi_dan_direktorat/update', 'update')->name('r_024_tim_akred_prodi_dan_direktorat.update');
        Route::delete('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/delete', 'delete')->name('r_024_tim_akred_prodi_dan_direktorat.delete');
        Route::patch('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/verifikasi', 'verifikasi')->name('r_024_tim_akred_prodi_dan_direktorat.verifikasi');
        Route::patch('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/tolak', 'tolak')->name('r_024_tim_akred_prodi_dan_direktorat.tolak');
    });
    Route::controller(R25KepanitiaanKegiatanInstitusiController::class)->group(function () {
        Route::get('/r_025_kepanitiaan_kegiatan_institusi', 'index')->name('r_025_kepanitiaan_kegiatan_institusi');
        Route::get('/r_025_kepanitiaan_kegiatan_institusi/create', 'create')->name('r_025_kepanitiaan_kegiatan_institusi.create');
        Route::post('/r_025_kepanitiaan_kegiatan_institusi', 'store')->name('r_025_kepanitiaan_kegiatan_institusi.store');
        Route::get('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/edit', 'edit')->name('r_025_kepanitiaan_kegiatan_institusi.edit');
        Route::patch('/r_025_kepanitiaan_kegiatan_institusi/update', 'update')->name('r_025_kepanitiaan_kegiatan_institusi.update');
        Route::delete('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/delete', 'delete')->name('r_025_kepanitiaan_kegiatan_institusi.delete');
        Route::patch('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/verifikasi', 'verifikasi')->name('r_025_kepanitiaan_kegiatan_institusi.verifikasi');
        Route::patch('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/tolak', 'tolak')->name('r_025_kepanitiaan_kegiatan_institusi.tolak');
    });
    Route::controller(R26PengelolaJurnalBuletinController::class)->group(function () {
        Route::get('/r_026_pengelola_jurnal_buletin', 'index')->name('r_026_pengelola_jurnal_buletin');
        Route::get('/r_026_pengelola_jurnal_buletin/create', 'create')->name('r_026_pengelola_jurnal_buletin.create');
        Route::post('/r_026_pengelola_jurnal_buletin', 'store')->name('r_026_pengelola_jurnal_buletin.store');
        Route::get('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/edit', 'edit')->name('r_026_pengelola_jurnal_buletin.edit');
        Route::patch('/r_026_pengelola_jurnal_buletin/update', 'update')->name('r_026_pengelola_jurnal_buletin.update');
        Route::delete('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/delete', 'delete')->name('r_026_pengelola_jurnal_buletin.delete');
        Route::patch('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/verifikasi', 'verifikasi')->name('r_026_pengelola_jurnal_buletin.verifikasi');
        Route::patch('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/tolak', 'tolak')->name('r_026_pengelola_jurnal_buletin.tolak');
    });
    Route::controller(R27KeanggotaanSenatController::class)->group(function () {
        Route::get('/r_027_keanggotaan_senat', 'index')->name('r_027_keanggotaan_senat');
        Route::get('/r_027_keanggotaan_senat/create', 'create')->name('r_027_keanggotaan_senat.create');
        Route::post('/r_027_keanggotaan_senat', 'store')->name('r_027_keanggotaan_senat.store');
        Route::get('/r_027_keanggotaan_senat/{r27keanggotaansenat}/edit', 'edit')->name('r_027_keanggotaan_senat.edit');
        Route::patch('/r_027_keanggotaan_senat/update', 'update')->name('r_027_keanggotaan_senat.update');
        Route::delete('/r_027_keanggotaan_senat/{r27keanggotaansenat}/delete', 'delete')->name('r_027_keanggotaan_senat.delete');
        Route::patch('/r_027_keanggotaan_senat/{r27keanggotaansenat}/verifikasi', 'verifikasi')->name('r_027_keanggotaan_senat.verifikasi');
        Route::patch('/r_027_keanggotaan_senat/{r27keanggotaansenat}/tolak', 'tolak')->name('r_027_keanggotaan_senat.tolak');
    });
    Route::controller(R28MelaksanakanPengembanganDiriController::class)->group(function () {
        Route::get('/r_028_melaksanakan_pengembangan_diri', 'index')->name('r_028_melaksanakan_pengembangan_diri');
        Route::get('/r_028_melaksanakan_pengembangan_diri/create', 'create')->name('r_028_melaksanakan_pengembangan_diri.create');
        Route::post('/r_028_melaksanakan_pengembangan_diri', 'store')->name('r_028_melaksanakan_pengembangan_diri.store');
        Route::get('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/edit', 'edit')->name('r_028_melaksanakan_pengembangan_diri.edit');
        Route::patch('/r_028_melaksanakan_pengembangan_diri/update', 'update')->name('r_028_melaksanakan_pengembangan_diri.update');
        Route::delete('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/delete', 'delete')->name('r_028_melaksanakan_pengembangan_diri.delete');
        Route::patch('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/verifikasi', 'verifikasi')->name('r_028_melaksanakan_pengembangan_diri.verifikasi');
        Route::patch('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/tolak', 'tolak')->name('r_028_melaksanakan_pengembangan_diri.tolak');
    });
    Route::controller(R29MemperolehPenghargaanController::class)->group(function () {
        Route::get('/r_029_memperoleh_penghargaan', 'index')->name('r_029_memperoleh_penghargaan');
        Route::get('/r_029_memperoleh_penghargaan/create', 'create')->name('r_029_memperoleh_penghargaan.create');
        Route::post('/r_029_memperoleh_penghargaan', 'store')->name('r_029_memperoleh_penghargaan.store');
        Route::get('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/edit', 'edit')->name('r_029_memperoleh_penghargaan.edit');
        Route::patch('/r_029_memperoleh_penghargaan/update', 'update')->name('r_029_memperoleh_penghargaan.update');
        Route::delete('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/delete', 'delete')->name('r_029_memperoleh_penghargaan.delete');
        Route::patch('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/verifikasi', 'verifikasi')->name('r_029_memperoleh_penghargaan.verifikasi');
        Route::patch('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/tolak', 'tolak')->name('r_029_memperoleh_penghargaan.tolak');
    });
    Route::controller(R30PengelolaKepkController::class)->group(function () {
        Route::get('/r_030_pengelola_kepk', 'index')->name('r_030_pengelola_kepk');
        Route::get('/r_030_pengelola_kepk/create', 'create')->name('r_030_pengelola_kepk.create');
        Route::post('/r_030_pengelola_kepk', 'store')->name('r_030_pengelola_kepk.store');
        Route::get('/r_030_pengelola_kepk/{r030pengelolakepk}/edit', 'edit')->name('r_030_pengelola_kepk.edit');
        Route::patch('/r_030_pengelola_kepk/update', 'update')->name('r_030_pengelola_kepk.update');
        Route::delete('/r_030_pengelola_kepk/{r030pengelolakepk}/delete', 'delete')->name('r_030_pengelola_kepk.delete');
        Route::patch('/r_030_pengelola_kepk/{r030pengelolakepk}/verifikasi', 'verifikasi')->name('r_030_pengelola_kepk.verifikasi');
        Route::patch('/r_030_pengelola_kepk/{r030pengelolakepk}/tolak', 'tolak')->name('r_030_pengelola_kepk.tolak');
    });
    // End Of Pengaturan/Setting Rubrik Penunjang Kegiatan Akademik Dosen
    
    //user
    Route::controller(VerifikatorController::class)->group(function () {
        Route::get('/manajemen_data_verifikator', 'index')->name('manajemen_data_verifikator');
        Route::post('/manajemen_data_verifikator', 'store')->name('manajemen_data_verifikator.store');
        Route::get('/manajemen_data_verifikator/{user}/edit', 'edit')->name('manajemen_data_verifikator.edit');
        Route::patch('/manajemen_data_verifikator/update', 'update')->name('manajemen_data_verifikator.update');
        Route::delete('/manajemen_data_verifikator/{user}/delete', 'delete')->name('manajemen_data_verifikator.delete');
        Route::patch('/manajemen_data_verifikator/{user}/active', 'active')->name('manajemen_data_verifikator.active');
        Route::patch('/manajemen_data_verifikator/{user}/nonactive', 'nonactive')->name('manajemen_data_verifikator.nonactive');
        Route::patch('/manajemen_data_verifikator/ubah_password', 'ubahPassword')->name('manajemen_data_verifikator.ubahPassword');
    });

    Route::controller(AdministratorController::class)->group(function () {
        Route::get('/manajemen_data_administrator', 'index')->name('manajemen_data_administrator');
        Route::post('/manajemen_data_administrator', 'store')->name('manajemen_data_administrator.store');
        Route::get('/manajemen_data_administrator/{administrator}/edit', 'edit')->name('manajemen_data_administrator.edit');
        Route::patch('/manajemen_data_administrator/update', 'update')->name('manajemen_data_administrator.update');
        Route::delete('/manajemen_data_administrator/{administrator}/delete', 'delete')->name('manajemen_data_administrator.delete');
        Route::patch('/manajemen_data_administrator/{administrator}/active', 'active')->name('manajemen_data_administrator.active');
        Route::patch('/manajemen_data_administrator/{administrator}/nonactive', 'nonactive')->name('manajemen_data_administrator.nonactive');
        Route::patch('/manajemen_data_administrator/ubah_password', 'ubahPassword')->name('manajemen_data_administrator.ubahPassword');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/manajemen_role', 'index')->name('manajemen_role');
        Route::post('/manajemen_role', 'store')->name('manajemen_role.store');
        Route::get('/manajemen_role/{role}/edit', 'edit')->name('manajemen_role.edit');
        Route::patch('/manajemen_role/update', 'update')->name('manajemen_role.update');
        Route::get('/manajemen_role/{role}/detail', 'detail')->name('manajemen_role.detail');
        Route::delete('/manajemen_role/{role}/delete', 'delete')->name('manajemen_role.delete');
        Route::delete('/manajemen_role/{role}/revoke/{permission}', 'revoke')->name('manajemen_role.revoke');
        Route::post('/manajemen_role/{role}/assign/', 'assign')->name('manajemen_role.assign');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/manajemen_permission', 'index')->name('manajemen_permission');
        Route::post('/manajemen_permission', 'store')->name('manajemen_permission.store');
        Route::get('/manajemen_permission/{permission}/edit', 'edit')->name('manajemen_permission.edit');
        Route::patch('/manajemen_permission/update', 'update')->name('manajemen_permission.update');
        Route::delete('/manajemen_permission/{permission}/delete', 'delete')->name('manajemen_permission.delete');
    });
});
