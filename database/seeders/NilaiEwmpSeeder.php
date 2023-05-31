<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KelompokRubrik;

class NilaiEwmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
            DB::table('nilai_ewmps')->insert(array([
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 01 Perkuliahan Teori',
                'nama_tabel_rubrik'     =>  'r01_perkuliahan_teoris',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 02 Perkuliahan Praktikum',
                'nama_tabel_rubrik'     =>  'r02_perkuliahan_praktikums',
                'ewmp'                  =>  1.5,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 03 Membimbing Capaian Kompetensi',
                'nama_tabel_rubrik'     =>  'r03_membimbing_pencapaian_kompetensis',
                'ewmp'                  =>  0.2,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 04 Membimbing Pendampingan UKOM',
                'nama_tabel_rubrik'     =>  'r04_membimbing_pendampingan_ukoms',
                'ewmp'                  =>  0.2,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 05 Membimbing Praktik PKK/PBL Klinik',
                'nama_tabel_rubrik'     =>  'r05_membimbing_praktik_pkk_pbl_kliniks',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 06 Menguji Ujian OSCA',
                'nama_tabel_rubrik'     =>  'r06_menguji_ujian_oscas',
                'ewmp'                  =>  0.25,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 07 Membimbing Skripsi/LTA/LA Profesi',
                'nama_tabel_rubrik'     =>  'r07_membimbing_skripsi_lta_la_profesis',
                'ewmp'                  =>  0.25,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 08 Menguji Seminar Proposal Skripsi/LTA/LA Profesi',
                'nama_tabel_rubrik'     =>  'r08_menguji_seminar_proposal_kti_lta_skripsis',
                'ewmp'                  =>  0.05,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 09 Menguji Seminar Hasil Skripsi/LTA/LA Profesi',
                'nama_tabel_rubrik'     =>  'r09_menguji_seminar_hasil_kti_lta_skripsis',
                'ewmp'                  =>  0.10,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 10 Menulis Buku Ajar Ber-ISBN',
                'nama_tabel_rubrik'     =>  'r010_menulis_buku_ajar_berisbns',
                'ewmp'                  =>  2,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 11 Mengembangkan Modul Ber-ISBN',
                'nama_tabel_rubrik'     =>  'r011_mengembangkan_modul_berisbns',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 12 Membimbing PKM',
                'nama_tabel_rubrik'     =>  'r012_membimbing_pkms',
                'ewmp'                  =>  2,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '2',
                'nama_rubrik'           =>  'Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu',
                'nama_tabel_rubrik'     =>  'r013_orasi_ilmiah_narasumber_bidang_ilmus',
                'ewmp'                  =>  3,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '2',
                'nama_rubrik'           =>  'Rubrik 14 Karya Inovasi',
                'nama_tabel_rubrik'     =>  'r014_karya_inovasis',
                'ewmp'                  =>  3,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '3',
                'nama_rubrik'           =>  'Rubrik 15 Menulis Karya Ilmiah Dipublikasikan',
                'nama_tabel_rubrik'     =>  'r015_menulis_karya_ilmiah_dipublikasikans',
                'ewmp'                  =>  3,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '3',
                'nama_rubrik'           =>  'Rubrik 16 Menulis Naskah Buku Berbahasa, Terbit dan Diedarkan Internasional (Minimal 3 Negara)',
                'nama_tabel_rubrik'     =>  'r016_naskah_buku_bahasa_terbit_edar_inters',
                'ewmp'                  =>  5,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '3',
                'nama_rubrik'           =>  'Rubrik 17 Menulis Naskah Buku Berbahasa, Terbit, Diedarkan Nasional, dan Terkatalog di Perpustakaan Nasional RI',
                'nama_tabel_rubrik'     =>  'r017_naskah_buku_bahasa_terbit_edar_nas',
                'ewmp'                  =>  3,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '4',
                'nama_rubrik'           =>  'Rubrik 18 Mendapatkan Hibah PKM',
                'nama_tabel_rubrik'     =>  'r018_mendapat_hibah_pkms',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '4',
                'nama_rubrik'           =>  'Rubrik 19 Memberi Latihan/ penyuluhan/ penataran/ ceramah pada masyarakat',
                'nama_tabel_rubrik'     =>  'r019_latih_nyuluh_natar_ceramah_wargas',
                'ewmp'                  =>  0.5,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 20 Assesor BKD/ LKD',
                'nama_tabel_rubrik'     =>  'r020_assessor_bkd_lkds',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 21 Reviewer Ethical Clearance Penelitian Dosen',
                'nama_tabel_rubrik'     =>  'r021_reviewer_eclere_penelitian_dosens',
                'ewmp'                  =>  0.07,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 22 Reviewer Ethical Clearance Penelitian Mahasiswa',
                'nama_tabel_rubrik'     =>  'r022_reviewer_eclere_penelitian_mhs',
                'ewmp'                  =>  0.03,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 23 Auditor Mutu Internal / Assessor Akreditasi Internal',
                'nama_tabel_rubrik'     =>  'r023_auditor_mutu_assessor_akred_internals',
                'ewmp'                  =>  0.6,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 24 Tim Akreditasi Tingkat Prodi dan Direktorat',
                'nama_tabel_rubrik'     =>  'r024_tim_akred_prodi_dan_direktorats',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 25 Kepanitiaan kegiatan institusi',
                'nama_tabel_rubrik'     =>  'r025_kepanitiaan_kegiatan_institusis',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 26 Pengelola jurnal / buletin',
                'nama_tabel_rubrik'     =>  'r026_pengelola_jurnal_buletin',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 27 Keanggotaan Senat',
                'nama_tabel_rubrik'     =>  'r027_keanggotaan_senat',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 28 Melaksanakan Pengembangan Diri',
                'nama_tabel_rubrik'     =>  'r028_melaksanakan_pengembangan_diri',
                'ewmp'                  =>  1,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 29 Memperolah penghargaan',
                'nama_tabel_rubrik'     =>  'r029_memperoleh_penghargaan',
                'ewmp'                  =>  0.5,
                'is_active'             =>  1,
            ],
            [
                'kelompok_rubrik_id'    =>  '5',
                'nama_rubrik'           =>  'Rubrik 30 Pengelola KEPK',
                'nama_tabel_rubrik'     =>  'r030_pengelola_kepk',
                'ewmp'                  =>  1.5,
                'is_active'             =>  1,
            ]
        ),

        );
    }
}
