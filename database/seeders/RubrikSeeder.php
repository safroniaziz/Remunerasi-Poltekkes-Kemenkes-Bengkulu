<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RubrikSeeder extends Seeder
{
    private array $rubrikTables = [
        'r01_perkuliahan_teoris',
        'r02_perkuliahan_praktikums',
        'r03_membimbing_pencapaian_kompetensis',
        'r04_membimbing_pendampingan_ukoms',
        'r05_membimbing_praktik_pkk_pbl_kliniks',
        'r06_menguji_ujian_oscas',
        'r07_membimbing_skripsi_lta_la_profesis',
        'r08_menguji_seminar_proposal_kti_lta_skripsis',
        'r09_menguji_seminar_hasil_kti_lta_skripsis',
        'r010_menulis_buku_ajar_berisbns',
        'r011_mengembangkan_modul_berisbns',
        'r012_membimbing_pkms',
        'r013_orasi_ilmiah_narasumber_bidang_ilmus',
        'r014_karya_inovasis',
        'r015_menulis_karya_ilmiah_dipublikasikans',
        'r016_naskah_buku_bahasa_terbit_edar_inters',
        'r017_naskah_buku_bahasa_terbit_edar_nas',
        'r018_mendapat_hibah_pkms',
        'r019_latih_nyuluh_natar_ceramah_wargas',
        'r020_assessor_bkd_lkds',
        'r021_reviewer_eclere_penelitian_dosens',
        'r022_reviewer_eclere_penelitian_mhs',
        'r023_auditor_mutu_assessor_akred_internals',
        'r024_tim_akred_prodi_dan_direktorats',
        'r025_kepanitiaan_kegiatan_institusis',
        'r026_pengelola_jurnal_buletins',
        'r027_keanggotaan_senats',
        'r028_melaksanakan_pengembangan_diris',
        'r029_memperoleh_penghargaans',
        'r030_pengelola_kepks',
    ];

    public function run(): void
    {
        $periodeId = DB::table('periodes')->where('is_active', 1)->value('id');

        if (! $periodeId) {
            throw new \RuntimeException('Periode aktif tidak ditemukan.');
        }

        DB::transaction(function () use ($periodeId) {
            $this->clearGeneratedData($periodeId);
            $this->clearRubrikData($periodeId);

            $this->call([
                R01Seeder::class,
                R02Seeder::class,
                R03Seeder::class,
                R04Seeder::class,
                R05Seeder::class,
                R06Seeder::class,
                R07Seeder::class,
                R08Seeder::class,
                R09Seeder::class,
                R010Seeder::class,
                R011Seeder::class,
                R012Seeder::class,
                R013Seeder::class,
                R014Seeder::class,
                R015Seeder::class,
                R016Seeder::class,
                R017Seeder::class,
                R018Seeder::class,
                R019Seeder::class,
                R020Seeder::class,
                R021Seeder::class,
                R022Seeder::class,
                R023Seeder::class,
                R024Seeder::class,
                R025Seeder::class,
                R026Seeder::class,
                R027Seeder::class,
                R028Seeder::class,
                R029Seeder::class,
                R030Seeder::class,
            ]);
        });
    }

    private function clearGeneratedData(int $periodeId): void
    {
        if (Schema::hasTable('riwayat_points')) {
            DB::table('riwayat_points')->where('periode_id', $periodeId)->delete();
        }

        if (Schema::hasTable('rekap_per_dosens')) {
            DB::table('rekap_per_dosens')->where('periode_id', $periodeId)->delete();
        }

        if (Schema::hasTable('rekap_per_rubriks')) {
            DB::table('rekap_per_rubriks')->where('periode_id', $periodeId)->delete();
        }
    }

    private function clearRubrikData(int $periodeId): void
    {
        foreach ($this->rubrikTables as $tableName) {
            if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, 'periode_id')) {
                continue;
            }

            DB::table($tableName)->where('periode_id', $periodeId)->delete();
        }
    }
}
