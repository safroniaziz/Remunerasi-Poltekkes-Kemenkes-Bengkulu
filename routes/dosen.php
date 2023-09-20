<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dosen\R14DosenKaryaInovasiController;
use App\Http\Controllers\Dosen\R12DosenMembimbingPkmController;
use App\Http\Controllers\Dosen\R30DosenPengelolaKepkController;
use App\Http\Controllers\Dosen\R20DosenAssessorBkdLkdController;
use App\Http\Controllers\Dosen\R01DosenPerkuliahanTeoriController;
use App\Http\Controllers\Dosen\R06DosenMengujiUjianOscaController;
use App\Http\Controllers\Dosen\R18DosenMendapatHibahPkmController;
use App\Http\Controllers\Dosen\R27DosenKeanggotaanSenatController;
use App\Http\Controllers\Dosen\R02DosenPerkuliahanPraktikumController;
use App\Http\Controllers\Dosen\R29DosenMemperolehPenghargaanController;
use App\Http\Controllers\Dosen\R10DosenMenulisBukuAjarBerisbnController;
use App\Http\Controllers\Dosen\R26DosenPengelolaJurnalBuletinController;
use App\Http\Controllers\Dosen\R11DosenMengembangkanModulBerisbnController;
use App\Http\Controllers\Dosen\R04DosenMembimbingPendampinganUkomController;
use App\Http\Controllers\Dosen\R24DosenTimAkredProdiDanDirektoratController;
use App\Http\Controllers\Dosen\R22DosenReviewerEclerePenelitianMhsController;
use App\Http\Controllers\Dosen\R19DosenLatihNyuluhNatarCeramahWargaController;
use App\Http\Controllers\Dosen\R25DosenKepanitiaanKegiatanInstitusiController;
use App\Http\Controllers\Dosen\R28DosenMelaksanakanPengembanganDiriController;
use App\Http\Controllers\Dosen\R05DosenMembimbingPraktikPkkPblKlinikController;
use App\Http\Controllers\Dosen\R07DosenMembimbingSkripsiLtaLaProfesiController;
use App\Http\Controllers\Dosen\R17DosenNaskahBukuBahasaTerbitEdarNasController;
use App\Http\Controllers\Dosen\R21DosenReviewerEclerePenelitianDosenController;
use App\Http\Controllers\Dosen\R03DosenMembimbingPencapaianKompetensiController;
use App\Http\Controllers\Dosen\R13DosenOrasiIlmiahNarasumberBidangIlmuController;
use App\Http\Controllers\Dosen\R16DosenNaskahBukuBahasaTerbitEdarInterController;
use App\Http\Controllers\Dosen\R09DosenMengujiSeminarHasilKtiLtaSkripsiController;
use App\Http\Controllers\Dosen\R15DosenMenulisKaryaIlmiahDipublikasikanController;
use App\Http\Controllers\Dosen\R23DosenAuditorMutuAssessorAkredInternalController;
use App\Http\Controllers\Dosen\R08DosenMengujiSeminarProposalKtiLtaSkripsiController;
use App\Http\Controllers\LaporanDosenController;

Route::get('/home', function () {
    return view('backend.dosen.dashboard');
})->name('dosen.dashboard');

// Pengaturan/Setting Rubrik Pendidikan
Route::controller(R01DosenPerkuliahanTeoriController::class)->group(function () {
    Route::get('/r_01_perkuliahan_teori', 'index')->name('dosen.r_01_perkuliahan_teori');
    Route::get('/r_01_perkuliahan_teori/create', 'create')->name('dosen.r_01_perkuliahan_teori.create');
    Route::post('/r_01_perkuliahan_teori', 'store')->name('dosen.r_01_perkuliahan_teori.store');
    Route::get('/r_01_perkuliahan_teori/{perkuliahanTeori}/edit', 'edit')->name('dosen.r_01_perkuliahan_teori.edit');
    Route::patch('/r_01_perkuliahan_teori/update', 'update')->name('dosen.r_01_perkuliahan_teori.update');
    Route::delete('/r_01_perkuliahan_teori/{perkuliahanteori}/delete', 'delete')->name('dosen.r_01_perkuliahan_teori.delete');
    Route::patch('/r_01_perkuliahan_teori/{r01perkuliahanteori}/verifikasi', 'verifikasi')->name('dosen.r_01_perkuliahan_teori.verifikasi');
    Route::patch('/r_01_perkuliahan_teori/{r01perkuliahanteori}/tolak', 'tolak')->name('dosen.r_01_perkuliahan_teori.tolak');
    Route::get('/r_01_perkuliahan_teori/siakad', 'siakad')->name('dosen.r_01_perkuliahan_teori.siakad');
    Route::post('/r_01_perkuliahan_teori/siakad_post', 'siakadPost')->name('dosen.r_01_perkuliahan_teori.siakad_post');
});

Route::controller(R02DosenPerkuliahanPraktikumController::class)->group(function () {
    Route::get('/r_02_perkuliahan_praktikum', 'index')->name('dosen.r_02_perkuliahan_praktikum');
    Route::get('/r_02_perkuliahan_praktikum/create', 'create')->name('dosen.r_02_perkuliahan_praktikum.create');
    Route::post('/r_02_perkuliahan_praktikum', 'store')->name('dosen.r_02_perkuliahan_praktikum.store');
    Route::get('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/edit', 'edit')->name('dosen.r_02_perkuliahan_praktikum.edit');
    Route::patch('/r_02_perkuliahan_praktikum/update', 'update')->name('dosen.r_02_perkuliahan_praktikum.update');
    Route::delete('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/delete', 'delete')->name('dosen.r_02_perkuliahan_praktikum.delete');
    Route::patch('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/verifikasi', 'verifikasi')->name('dosen.r_02_perkuliahan_praktikum.verifikasi');
    Route::patch('/r_02_perkuliahan_praktikum/{r02perkuliahanpraktikum}/tolak', 'tolak')->name('dosen.r_02_perkuliahan_praktikum.tolak');
    Route::get('/r_02_perkuliahan_praktikum/siakad', 'siakad')->name('dosen.r_02_perkuliahan_praktikum.siakad');
    Route::post('/r_02_perkuliahan_praktikum/siakad_post', 'siakadPost')->name('dosen.r_02_perkuliahan_praktikum.siakad_post');
});
Route::controller(R03DosenMembimbingPencapaianKompetensiController::class)->group(function () {
    Route::get('/r_03_membimbing_pencapaian_kompetensi', 'index')->name('dosen.r_03_membimbing_pencapaian_kompetensi');
    Route::get('/r_03_membimbing_pencapaian_kompetensi/create', 'create')->name('dosen.r_03_membimbing_pencapaian_kompetensi.create');
    Route::post('/r_03_membimbing_pencapaian_kompetensi', 'store')->name('dosen.r_03_membimbing_pencapaian_kompetensi.store');
    Route::get('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/edit', 'edit')->name('dosen.r_03_membimbing_pencapaian_kompetensi.edit');
    Route::patch('/r_03_membimbing_pencapaian_kompetensi/update', 'update')->name('dosen.r_03_membimbing_pencapaian_kompetensi.update');
    Route::delete('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/delete', 'delete')->name('dosen.r_03_membimbing_pencapaian_kompetensi.delete');
    Route::patch('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/verifikasi', 'verifikasi')->name('dosen.r_03_membimbing_pencapaian_kompetensi.verifikasi');
    Route::patch('/r_03_membimbing_pencapaian_kompetensi/{r03bimbingcapaiankompetensi}/tolak', 'tolak')->name('dosen.r_03_membimbing_pencapaian_kompetensi.tolak');
});
Route::controller(R04DosenMembimbingPendampinganUkomController::class)->group(function () {
    Route::get('/r_04_membimbing_pendampingan_ukom', 'index')->name('dosen.r_04_membimbing_pendampingan_ukom');
    Route::get('/r_04_membimbing_pendampingan_ukom/create', 'create')->name('dosen.r_04_membimbing_pendampingan_ukom.create');
    Route::post('/r_04_membimbing_pendampingan_ukom', 'store')->name('dosen.r_04_membimbing_pendampingan_ukom.store');
    Route::get('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/edit', 'edit')->name('dosen.r_04_membimbing_pendampingan_ukom.edit');
    Route::patch('/r_04_membimbing_pendampingan_ukom/update', 'update')->name('dosen.r_04_membimbing_pendampingan_ukom.update');
    Route::delete('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/delete', 'delete')->name('dosen.r_04_membimbing_pendampingan_ukom.delete');
    Route::patch('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/verifikasi', 'verifikasi')->name('dosen.r_04_membimbing_pendampingan_ukom.verifikasi');
    Route::patch('/r_04_membimbing_pendampingan_ukom/{r04membimbingpendampinganukom}/tolak', 'tolak')->name('dosen.r_04_membimbing_pendampingan_ukom.tolak');
});
Route::controller(R05DosenMembimbingPraktikPkkPblKlinikController::class)->group(function () {
    Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik', 'index')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik');
    Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik/create', 'create')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik.create');
    Route::post('/r_05_membimbing_praktik_pkk_pbl_klinik', 'store')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik.store');
    Route::get('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/edit', 'edit')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik.edit');
    Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/update', 'update')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik.update');
    Route::delete('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/delete', 'delete')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik.delete');
    Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/verifikasi', 'verifikasi')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik.verifikasi');
    Route::patch('/r_05_membimbing_praktik_pkk_pbl_klinik/{r05membimbingpraktikpkkpblklinik}/tolak', 'tolak')->name('dosen.r_05_membimbing_praktik_pkk_pbl_klinik.tolak');
});
Route::controller(R06DosenMengujiUjianOscaController::class)->group(function () {
    Route::get('/r_06_menguji_ujian_osca', 'index')->name('dosen.r_06_menguji_ujian_osca');
    Route::get('/r_06_menguji_ujian_osca/create', 'create')->name('dosen.r_06_menguji_ujian_osca.create');
    Route::post('/r_06_menguji_ujian_osca', 'store')->name('dosen.r_06_menguji_ujian_osca.store');
    Route::get('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/edit', 'edit')->name('dosen.r_06_menguji_ujian_osca.edit');
    Route::patch('/r_06_menguji_ujian_osca/update', 'update')->name('dosen.r_06_menguji_ujian_osca.update');
    Route::delete('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/delete', 'delete')->name('dosen.r_06_menguji_ujian_osca.delete');
    Route::patch('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/verifikasi', 'verifikasi')->name('dosen.r_06_menguji_ujian_osca.verifikasi');
    Route::patch('/r_06_menguji_ujian_osca/{r06mengujiujianosca}/tolak', 'tolak')->name('dosen.r_06_menguji_ujian_osca.tolak');
});
Route::controller(R07DosenMembimbingSkripsiLtaLaProfesiController::class)->group(function () {
    Route::get('/r_07_membimbing_skripsi_lta_la_profesi', 'index')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi');
    Route::get('/r_07_membimbing_skripsi_lta_la_profesi/create', 'create')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi.create');
    Route::post('/r_07_membimbing_skripsi_lta_la_profesi', 'store')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi.store');
    Route::get('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/edit', 'edit')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi.edit');
    Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/update', 'update')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi.update');
    Route::delete('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/delete', 'delete')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi.delete');
    Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/verifikasi', 'verifikasi')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi.verifikasi');
    Route::patch('/r_07_membimbing_skripsi_lta_la_profesi/{r07membimbingskripsiltalaprofesi}/tolak', 'tolak')->name('dosen.r_07_membimbing_skripsi_lta_la_profesi.tolak');
});
Route::controller(R08DosenMengujiSeminarProposalKtiLtaSkripsiController::class)->group(function () {
    Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi', 'index')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi');
    Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi/create', 'create')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi.create');
    Route::post('/r_08_menguji_seminar_proposal_kti_lta_skripsi', 'store')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi.store');
    Route::get('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/edit', 'edit')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi.edit');
    Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/update', 'update')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi.update');
    Route::delete('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/delete', 'delete')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi.delete');
    Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/verifikasi', 'verifikasi')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi.verifikasi');
    Route::patch('/r_08_menguji_seminar_proposal_kti_lta_skripsi/{r08mengujiseminarproposal}/tolak', 'tolak')->name('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi.tolak');
});
Route::controller(R09DosenMengujiSeminarHasilKtiLtaSkripsiController::class)->group(function () {
    Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi', 'index')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi');
    Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi/create', 'create')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi.create');
    Route::post('/r_09_menguji_seminar_hasil_kti_lta_skripsi', 'store')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi.store');
    Route::get('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/edit', 'edit')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi.edit');
    Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/update', 'update')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi.update');
    Route::delete('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/delete', 'delete')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi.delete');
    Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/verifikasi', 'verifikasi')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi.verifikasi');
    Route::patch('/r_09_menguji_seminar_hasil_kti_lta_skripsi/{r09mengujiseminarhasil}/tolak', 'tolak')->name('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi.tolak');
});
Route::controller(R10DosenMenulisBukuAjarBerisbnController::class)->group(function () {
    Route::get('/r_010_menulis_buku_ajar_berisbn', 'index')->name('dosen.r_010_menulis_buku_ajar_berisbn');
    Route::get('/r_010_menulis_buku_ajar_berisbn/create', 'create')->name('dosen.r_010_menulis_buku_ajar_berisbn.create');
    Route::post('/r_010_menulis_buku_ajar_berisbn', 'store')->name('dosen.r_010_menulis_buku_ajar_berisbn.store');
    Route::get('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/edit', 'edit')->name('dosen.r_010_menulis_buku_ajar_berisbn.edit');
    Route::patch('/r_010_menulis_buku_ajar_berisbn/update', 'update')->name('dosen.r_010_menulis_buku_ajar_berisbn.update');
    Route::delete('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/delete', 'delete')->name('dosen.r_010_menulis_buku_ajar_berisbn.delete');
    Route::patch('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/verifikasi', 'verifikasi')->name('dosen.r_010_menulis_buku_ajar_berisbn.verifikasi');
    Route::patch('/r_010_menulis_buku_ajar_berisbn/{r010menulisbukuajarberisbn}/tolak', 'tolak')->name('dosen.r_010_menulis_buku_ajar_berisbn.tolak');
});
Route::controller(R11DosenMengembangkanModulBerisbnController::class)->group(function () {
    Route::get('/r_011_mengembangkan_modul_berisbn', 'index')->name('dosen.r_011_mengembangkan_modul_berisbn');
    Route::get('/r_011_mengembangkan_modul_berisbn/create', 'create')->name('dosen.r_011_mengembangkan_modul_berisbn.create');
    Route::post('/r_011_mengembangkan_modul_berisbn', 'store')->name('dosen.r_011_mengembangkan_modul_berisbn.store');
    Route::get('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/edit', 'edit')->name('dosen.r_011_mengembangkan_modul_berisbn.edit');
    Route::patch('/r_011_mengembangkan_modul_berisbn/update', 'update')->name('dosen.r_011_mengembangkan_modul_berisbn.update');
    Route::delete('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/delete', 'delete')->name('dosen.r_011_mengembangkan_modul_berisbn.delete');
    Route::patch('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/verifikasi', 'verifikasi')->name('dosen.r_011_mengembangkan_modul_berisbn.verifikasi');
    Route::patch('/r_011_mengembangkan_modul_berisbn/{r011mengembangkanmodulberisbn}/tolak', 'tolak')->name('dosen.r_011_mengembangkan_modul_berisbn.tolak');
});
Route::controller(R12DosenMembimbingPkmController::class)->group(function () {
    Route::get('/r_012_membimbing_pkm', 'index')->name('dosen.r_012_membimbing_pkm');
    Route::get('/r_012_membimbing_pkm/create', 'create')->name('dosen.r_012_membimbing_pkm.create');
    Route::post('/r_012_membimbing_pkm', 'store')->name('dosen.r_012_membimbing_pkm.store');
    Route::get('/r_012_membimbing_pkm/{r012membimbingpkm}/edit', 'edit')->name('dosen.r_012_membimbing_pkm.edit');
    Route::patch('/r_012_membimbing_pkm/update', 'update')->name('dosen.r_012_membimbing_pkm.update');
    Route::delete('/r_012_membimbing_pkm/{r012membimbingpkm}/delete', 'delete')->name('dosen.r_012_membimbing_pkm.delete');
    Route::patch('/r_012_membimbing_pkm/{r012membimbingpkm}/verifikasi', 'verifikasi')->name('dosen.r_012_membimbing_pkm.verifikasi');
    Route::patch('/r_012_membimbing_pkm/{r012membimbingpkm}/tolak', 'tolak')->name('dosen.r_012_membimbing_pkm.tolak');
});
// End Of Pengaturan/Setting Rubrik Pendidikan
// Pengaturan/Setting Rubrik Pendidikan Insidental
Route::controller(R13DosenOrasiIlmiahNarasumberBidangIlmuController::class)->group(function () {
    Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu', 'index')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu');
    Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/create', 'create')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu.create');
    Route::post('/r_013_orasi_ilmiah_narasumber_bidang_ilmu', 'store')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu.store');
    Route::get('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/edit', 'edit')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu.edit');
    Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/update', 'update')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu.update');
    Route::delete('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/delete', 'delete')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu.delete');
    Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/verifikasi', 'verifikasi')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu.verifikasi');
    Route::patch('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/{r013orasiilmiahnarasumber}/tolak', 'tolak')->name('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu.tolak');
});
Route::controller(R14DosenKaryaInovasiController::class)->group(function () {
    Route::get('/r_014_karya_inovasi', 'index')->name('dosen.r_014_karya_inovasi');
    Route::get('/r_014_karya_inovasi/create', 'create')->name('dosen.r_014_karya_inovasi.create');
    Route::post('/r_014_karya_inovasi', 'store')->name('dosen.r_014_karya_inovasi.store');
    Route::get('/r_014_karya_inovasi/{r014karyainovasi}/edit', 'edit')->name('dosen.r_014_karya_inovasi.edit');
    Route::patch('/r_014_karya_inovasi/update', 'update')->name('dosen.r_014_karya_inovasi.update');
    Route::delete('/r_014_karya_inovasi/{r014karyainovasi}/delete', 'delete')->name('dosen.r_014_karya_inovasi.delete');
    Route::patch('/r_014_karya_inovasi/{r014karyainovasi}/verifikasi', 'verifikasi')->name('dosen.r_014_karya_inovasi.verifikasi');
    Route::patch('/r_014_karya_inovasi/{r014karyainovasi}/tolak', 'tolak')->name('dosen.r_014_karya_inovasi.tolak');
});
// End Of Pengaturan/Setting Rubrik Pendidikan Insidental
// Pengaturan/Setting Rubrik Penelitian
Route::controller(R15DosenMenulisKaryaIlmiahDipublikasikanController::class)->group(function () {
    Route::get('/r_015_menulis_karya_ilmiah_dipublikasikan', 'index')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan');
    Route::get('/r_015_menulis_karya_ilmiah_dipublikasikan/create', 'create')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan.create');
    Route::post('/r_015_menulis_karya_ilmiah_dipublikasikan', 'store')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan.store');
    Route::get('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/edit', 'edit')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan.edit');
    Route::patch('/r_015_menulis_karya_ilmiah_dipublikasikan/update', 'update')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan.update');
    Route::delete('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/delete', 'delete')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan.delete');
    Route::patch('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/verifikasi', 'verifikasi')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan.verifikasi');
    Route::patch('/r_015_menulis_karya_ilmiah_dipublikasikan/{r015karyailmiahpublikasi}/tolak', 'tolak')->name('dosen.r_015_menulis_karya_ilmiah_dipublikasikan.tolak');
});
Route::controller(R16DosenNaskahBukuBahasaTerbitEdarInterController::class)->group(function () {
    Route::get('/r_016_naskah_buku_bahasa_terbit_edar_inter', 'index')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter');
    Route::get('/r_016_naskah_buku_bahasa_terbit_edar_inter/create', 'create')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter.create');
    Route::post('/r_016_naskah_buku_bahasa_terbit_edar_inter', 'store')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter.store');
    Route::get('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/edit', 'edit')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter.edit');
    Route::patch('/r_016_naskah_buku_bahasa_terbit_edar_inter/update', 'update')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter.update');
    Route::delete('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/delete', 'delete')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter.delete');
    Route::patch('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/verifikasi', 'verifikasi')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter.verifikasi');
    Route::patch('/r_016_naskah_buku_bahasa_terbit_edar_inter/{r016naskahbukuterbitedarinter}/tolak', 'tolak')->name('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter.tolak');
});
Route::controller(R17DosenNaskahBukuBahasaTerbitEdarNasController::class)->group(function () {
    Route::get('/r_017_naskah_buku_bahasa_terbit_edar_nas', 'index')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas');
    Route::get('/r_017_naskah_buku_bahasa_terbit_edar_nas/create', 'create')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas.create');
    Route::post('/r_017_naskah_buku_bahasa_terbit_edar_nas', 'store')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas.store');
    Route::get('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/edit', 'edit')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas.edit');
    Route::patch('/r_017_naskah_buku_bahasa_terbit_edar_nas/update', 'update')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas.update');
    Route::delete('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/delete', 'delete')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas.delete');
    Route::patch('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/verifikasi', 'verifikasi')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas.verifikasi');
    Route::patch('/r_017_naskah_buku_bahasa_terbit_edar_nas/{r017naskahbukuterbitedarnas}/tolak', 'tolak')->name('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas.tolak');
});
// End Of Pengaturan/Setting Rubrik Penelitian
// Pengaturan/Setting Rubrik Pengabdian
Route::controller(R18DosenMendapatHibahPkmController::class)->group(function () {
    Route::get('/r_018_mendapat_hibah_pkm', 'index')->name('dosen.r_018_mendapat_hibah_pkm');
    Route::get('/r_018_mendapat_hibah_pkm/create', 'create')->name('dosen.r_018_mendapat_hibah_pkm.create');
    Route::post('/r_018_mendapat_hibah_pkm', 'store')->name('dosen.r_018_mendapat_hibah_pkm.store');
    Route::get('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/edit', 'edit')->name('dosen.r_018_mendapat_hibah_pkm.edit');
    Route::patch('/r_018_mendapat_hibah_pkm/update', 'update')->name('dosen.r_018_mendapat_hibah_pkm.update');
    Route::delete('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/delete', 'delete')->name('dosen.r_018_mendapat_hibah_pkm.delete');
    Route::patch('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/verifikasi', 'verifikasi')->name('dosen.r_018_mendapat_hibah_pkm.verifikasi');
    Route::patch('/r_018_mendapat_hibah_pkm/{r018mendapathibahpkm}/tolak', 'tolak')->name('dosen.r_018_mendapat_hibah_pkm.tolak');
});
Route::controller(R19DosenLatihNyuluhNatarCeramahWargaController::class)->group(function () {
    Route::get('/r_019_latih_nyuluh_natar_ceramah_warga', 'index')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga');
    Route::get('/r_019_latih_nyuluh_natar_ceramah_warga/create', 'create')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga.create');
    Route::post('/r_019_latih_nyuluh_natar_ceramah_warga', 'store')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga.store');
    Route::get('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/edit', 'edit')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga.edit');
    Route::patch('/r_019_latih_nyuluh_natar_ceramah_warga/update', 'update')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga.update');
    Route::delete('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/delete', 'delete')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga.delete');
    Route::patch('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/verifikasi', 'verifikasi')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga.verifikasi');
    Route::patch('/r_019_latih_nyuluh_natar_ceramah_warga/{r019latihnyuluhnatarceramahwarga}/tolak', 'tolak')->name('dosen.r_019_latih_nyuluh_natar_ceramah_warga.tolak');
});
// End Of Pengaturan/Setting Rubrik Pengabdian
// Pengaturan/Setting Rubrik Penunjang Kegiatan Akademik Dosen
Route::controller(R20DosenAssessorBkdLkdController::class)->group(function () {
    Route::get('/r_020_assessor_bkd_lkd', 'index')->name('dosen.r_020_assessor_bkd_lkd');
    Route::get('/r_020_assessor_bkd_lkd/create', 'create')->name('dosen.r_020_assessor_bkd_lkd.create');
    Route::post('/r_020_assessor_bkd_lkd', 'store')->name('dosen.r_020_assessor_bkd_lkd.store');
    Route::get('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/edit', 'edit')->name('dosen.r_020_assessor_bkd_lkd.edit');
    Route::patch('/r_020_assessor_bkd_lkd/update', 'update')->name('dosen.r_020_assessor_bkd_lkd.update');
    Route::delete('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/delete', 'delete')->name('dosen.r_020_assessor_bkd_lkd.delete');
    Route::patch('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/verifikasi', 'verifikasi')->name('dosen.r_020_assessor_bkd_lkd.verifikasi');
    Route::patch('/r_020_assessor_bkd_lkd/{r020assessorbkdlkd}/tolak', 'tolak')->name('dosen.r_020_assessor_bkd_lkd.tolak');
});
Route::controller(R21DosenReviewerEclerePenelitianDosenController::class)->group(function () {
    Route::get('/r_021_reviewer_eclere_penelitian_dosen', 'index')->name('dosen.r_021_reviewer_eclere_penelitian_dosen');
    Route::get('/r_021_reviewer_eclere_penelitian_dosen/create', 'create')->name('dosen.r_021_reviewer_eclere_penelitian_dosen.create');
    Route::post('/r_021_reviewer_eclere_penelitian_dosen', 'store')->name('dosen.r_021_reviewer_eclere_penelitian_dosen.store');
    Route::get('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/edit', 'edit')->name('dosen.r_021_reviewer_eclere_penelitian_dosen.edit');
    Route::patch('/r_021_reviewer_eclere_penelitian_dosen/update', 'update')->name('dosen.r_021_reviewer_eclere_penelitian_dosen.update');
    Route::delete('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/delete', 'delete')->name('dosen.r_021_reviewer_eclere_penelitian_dosen.delete');
    Route::patch('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/verifikasi', 'verifikasi')->name('dosen.r_021_reviewer_eclere_penelitian_dosen.verifikasi');
    Route::patch('/r_021_reviewer_eclere_penelitian_dosen/{r21revieweclerepenelitidosen}/tolak', 'tolak')->name('dosen.r_021_reviewer_eclere_penelitian_dosen.tolak');
});
Route::controller(R22DosenReviewerEclerePenelitianMhsController::class)->group(function () {
    Route::get('/r_022_reviewer_eclere_penelitian_mhs', 'index')->name('dosen.r_022_reviewer_eclere_penelitian_mhs');
    Route::get('/r_022_reviewer_eclere_penelitian_mhs/create', 'create')->name('dosen.r_022_reviewer_eclere_penelitian_mhs.create');
    Route::post('/r_022_reviewer_eclere_penelitian_mhs', 'store')->name('dosen.r_022_reviewer_eclere_penelitian_mhs.store');
    Route::get('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/edit', 'edit')->name('dosen.r_022_reviewer_eclere_penelitian_mhs.edit');
    Route::patch('/r_022_reviewer_eclere_penelitian_mhs/update', 'update')->name('dosen.r_022_reviewer_eclere_penelitian_mhs.update');
    Route::delete('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/delete', 'delete')->name('dosen.r_022_reviewer_eclere_penelitian_mhs.delete');
    Route::patch('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/verifikasi', 'verifikasi')->name('dosen.r_022_reviewer_eclere_penelitian_mhs.verifikasi');
    Route::patch('/r_022_reviewer_eclere_penelitian_mhs/{r22revieweclerepenelitimhs}/tolak', 'tolak')->name('dosen.r_022_reviewer_eclere_penelitian_mhs.tolak');
});
Route::controller(R23DosenAuditorMutuAssessorAkredInternalController::class)->group(function () {
    Route::get('/r_023_auditor_mutu_assessor_akred_internal', 'index')->name('dosen.r_023_auditor_mutu_assessor_akred_internal');
    Route::get('/r_023_auditor_mutu_assessor_akred_internal/create', 'create')->name('dosen.r_023_auditor_mutu_assessor_akred_internal.create');
    Route::post('/r_023_auditor_mutu_assessor_akred_internal', 'store')->name('dosen.r_023_auditor_mutu_assessor_akred_internal.store');
    Route::get('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/edit', 'edit')->name('dosen.r_023_auditor_mutu_assessor_akred_internal.edit');
    Route::patch('/r_023_auditor_mutu_assessor_akred_internal/update', 'update')->name('dosen.r_023_auditor_mutu_assessor_akred_internal.update');
    Route::delete('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/delete', 'delete')->name('dosen.r_023_auditor_mutu_assessor_akred_internal.delete');
    Route::patch('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/verifikasi', 'verifikasi')->name('dosen.r_023_auditor_mutu_assessor_akred_internal.verifikasi');
    Route::patch('/r_023_auditor_mutu_assessor_akred_internal/{r23auditmutuasesorakredinternal}/tolak', 'tolak')->name('dosen.r_023_auditor_mutu_assessor_akred_internal.tolak');
});
Route::controller(R24DosenTimAkredProdiDanDirektoratController::class)->group(function () {
    Route::get('/r_024_tim_akred_prodi_dan_direktorat', 'index')->name('dosen.r_024_tim_akred_prodi_dan_direktorat');
    Route::get('/r_024_tim_akred_prodi_dan_direktorat/create', 'create')->name('dosen.r_024_tim_akred_prodi_dan_direktorat.create');
    Route::post('/r_024_tim_akred_prodi_dan_direktorat', 'store')->name('dosen.r_024_tim_akred_prodi_dan_direktorat.store');
    Route::get('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/edit', 'edit')->name('dosen.r_024_tim_akred_prodi_dan_direktorat.edit');
    Route::patch('/r_024_tim_akred_prodi_dan_direktorat/update', 'update')->name('dosen.r_024_tim_akred_prodi_dan_direktorat.update');
    Route::delete('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/delete', 'delete')->name('dosen.r_024_tim_akred_prodi_dan_direktorat.delete');
    Route::patch('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/verifikasi', 'verifikasi')->name('dosen.r_024_tim_akred_prodi_dan_direktorat.verifikasi');
    Route::patch('/r_024_tim_akred_prodi_dan_direktorat/{r24timakredprodirektorat}/tolak', 'tolak')->name('dosen.r_024_tim_akred_prodi_dan_direktorat.tolak');
});
Route::controller(R25DosenKepanitiaanKegiatanInstitusiController::class)->group(function () {
    Route::get('/r_025_kepanitiaan_kegiatan_institusi', 'index')->name('dosen.r_025_kepanitiaan_kegiatan_institusi');
    Route::get('/r_025_kepanitiaan_kegiatan_institusi/create', 'create')->name('dosen.r_025_kepanitiaan_kegiatan_institusi.create');
    Route::post('/r_025_kepanitiaan_kegiatan_institusi', 'store')->name('dosen.r_025_kepanitiaan_kegiatan_institusi.store');
    Route::get('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/edit', 'edit')->name('dosen.r_025_kepanitiaan_kegiatan_institusi.edit');
    Route::patch('/r_025_kepanitiaan_kegiatan_institusi/update', 'update')->name('dosen.r_025_kepanitiaan_kegiatan_institusi.update');
    Route::delete('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/delete', 'delete')->name('dosen.r_025_kepanitiaan_kegiatan_institusi.delete');
    Route::patch('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/verifikasi', 'verifikasi')->name('dosen.r_025_kepanitiaan_kegiatan_institusi.verifikasi');
    Route::patch('/r_025_kepanitiaan_kegiatan_institusi/{r25panitiakegiataninstitusi}/tolak', 'tolak')->name('dosen.r_025_kepanitiaan_kegiatan_institusi.tolak');
});
Route::controller(R26DosenPengelolaJurnalBuletinController::class)->group(function () {
    Route::get('/r_026_pengelola_jurnal_buletin', 'index')->name('dosen.r_026_pengelola_jurnal_buletin');
    Route::get('/r_026_pengelola_jurnal_buletin/create', 'create')->name('dosen.r_026_pengelola_jurnal_buletin.create');
    Route::post('/r_026_pengelola_jurnal_buletin', 'store')->name('dosen.r_026_pengelola_jurnal_buletin.store');
    Route::get('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/edit', 'edit')->name('dosen.r_026_pengelola_jurnal_buletin.edit');
    Route::patch('/r_026_pengelola_jurnal_buletin/update', 'update')->name('dosen.r_026_pengelola_jurnal_buletin.update');
    Route::delete('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/delete', 'delete')->name('dosen.r_026_pengelola_jurnal_buletin.delete');
    Route::patch('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/verifikasi', 'verifikasi')->name('dosen.r_026_pengelola_jurnal_buletin.verifikasi');
    Route::patch('/r_026_pengelola_jurnal_buletin/{r26pengelolajurnalbuletin}/tolak', 'tolak')->name('dosen.r_026_pengelola_jurnal_buletin.tolak');
});
Route::controller(R27DosenKeanggotaanSenatController::class)->group(function () {
    Route::get('/r_027_keanggotaan_senat', 'index')->name('dosen.r_027_keanggotaan_senat');
    Route::get('/r_027_keanggotaan_senat/create', 'create')->name('dosen.r_027_keanggotaan_senat.create');
    Route::post('/r_027_keanggotaan_senat', 'store')->name('dosen.r_027_keanggotaan_senat.store');
    Route::get('/r_027_keanggotaan_senat/{r27keanggotaansenat}/edit', 'edit')->name('dosen.r_027_keanggotaan_senat.edit');
    Route::patch('/r_027_keanggotaan_senat/update', 'update')->name('dosen.r_027_keanggotaan_senat.update');
    Route::delete('/r_027_keanggotaan_senat/{r27keanggotaansenat}/delete', 'delete')->name('dosen.r_027_keanggotaan_senat.delete');
    Route::patch('/r_027_keanggotaan_senat/{r27keanggotaansenat}/verifikasi', 'verifikasi')->name('dosen.r_027_keanggotaan_senat.verifikasi');
    Route::patch('/r_027_keanggotaan_senat/{r27keanggotaansenat}/tolak', 'tolak')->name('dosen.r_027_keanggotaan_senat.tolak');
});
Route::controller(R28DosenMelaksanakanPengembanganDiriController::class)->group(function () {
    Route::get('/r_028_melaksanakan_pengembangan_diri', 'index')->name('dosen.r_028_melaksanakan_pengembangan_diri');
    Route::get('/r_028_melaksanakan_pengembangan_diri/create', 'create')->name('dosen.r_028_melaksanakan_pengembangan_diri.create');
    Route::post('/r_028_melaksanakan_pengembangan_diri', 'store')->name('dosen.r_028_melaksanakan_pengembangan_diri.store');
    Route::get('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/edit', 'edit')->name('dosen.r_028_melaksanakan_pengembangan_diri.edit');
    Route::patch('/r_028_melaksanakan_pengembangan_diri/update', 'update')->name('dosen.r_028_melaksanakan_pengembangan_diri.update');
    Route::delete('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/delete', 'delete')->name('dosen.r_028_melaksanakan_pengembangan_diri.delete');
    Route::patch('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/verifikasi', 'verifikasi')->name('dosen.r_028_melaksanakan_pengembangan_diri.verifikasi');
    Route::patch('/r_028_melaksanakan_pengembangan_diri/{r28laksanakanpengembangandiri}/tolak', 'tolak')->name('dosen.r_028_melaksanakan_pengembangan_diri.tolak');
});
Route::controller(R29DosenMemperolehPenghargaanController::class)->group(function () {
    Route::get('/r_029_memperoleh_penghargaan', 'index')->name('dosen.r_029_memperoleh_penghargaan');
    Route::get('/r_029_memperoleh_penghargaan/create', 'create')->name('dosen.r_029_memperoleh_penghargaan.create');
    Route::post('/r_029_memperoleh_penghargaan', 'store')->name('dosen.r_029_memperoleh_penghargaan.store');
    Route::get('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/edit', 'edit')->name('dosen.r_029_memperoleh_penghargaan.edit');
    Route::patch('/r_029_memperoleh_penghargaan/update', 'update')->name('dosen.r_029_memperoleh_penghargaan.update');
    Route::delete('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/delete', 'delete')->name('dosen.r_029_memperoleh_penghargaan.delete');
    Route::patch('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/verifikasi', 'verifikasi')->name('dosen.r_029_memperoleh_penghargaan.verifikasi');
    Route::patch('/r_029_memperoleh_penghargaan/{r29memperolehpenghargaan}/tolak', 'tolak')->name('dosen.r_029_memperoleh_penghargaan.tolak');
});
Route::controller(R30DosenPengelolaKepkController::class)->group(function () {
    Route::get('/r_030_pengelola_kepk', 'index')->name('dosen.r_030_pengelola_kepk');
    Route::get('/r_030_pengelola_kepk/create', 'create')->name('dosen.r_030_pengelola_kepk.create');
    Route::post('/r_030_pengelola_kepk', 'store')->name('dosen.r_030_pengelola_kepk.store');
    Route::get('/r_030_pengelola_kepk/{r030pengelolakepk}/edit', 'edit')->name('dosen.r_030_pengelola_kepk.edit');
    Route::patch('/r_030_pengelola_kepk/update', 'update')->name('dosen.r_030_pengelola_kepk.update');
    Route::delete('/r_030_pengelola_kepk/{r030pengelolakepk}/delete', 'delete')->name('dosen.r_030_pengelola_kepk.delete');
    Route::patch('/r_030_pengelola_kepk/{r030pengelolakepk}/verifikasi', 'verifikasi')->name('dosen.r_030_pengelola_kepk.verifikasi');
    Route::patch('/r_030_pengelola_kepk/{r030pengelolakepk}/tolak', 'tolak')->name('dosen.r_030_pengelola_kepk.tolak');
});

Route::controller(LaporanDosenController::class)->group(function () {
    Route::get('/cetak_laporan', 'cetakLaporan')->name('dosen.cetakLaporan');
});
// End Of Pengaturan/Setting Rubrik Penunjang Kegiatan Akademik Dosen