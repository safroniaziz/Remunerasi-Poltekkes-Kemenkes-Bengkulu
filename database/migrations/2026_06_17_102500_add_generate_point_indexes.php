<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $rubrikTables = [
        'r01_perkuliahan_teoris' => 'idx_r01_gen_point',
        'r02_perkuliahan_praktikums' => 'idx_r02_gen_point',
        'r03_membimbing_pencapaian_kompetensis' => 'idx_r03_gen_point',
        'r04_membimbing_pendampingan_ukoms' => 'idx_r04_gen_point',
        'r05_membimbing_praktik_pkk_pbl_kliniks' => 'idx_r05_gen_point',
        'r06_menguji_ujian_oscas' => 'idx_r06_gen_point',
        'r07_membimbing_skripsi_lta_la_profesis' => 'idx_r07_gen_point',
        'r08_menguji_seminar_proposal_kti_lta_skripsis' => 'idx_r08_gen_point',
        'r09_menguji_seminar_hasil_kti_lta_skripsis' => 'idx_r09_gen_point',
        'r010_menulis_buku_ajar_berisbns' => 'idx_r010_gen_point',
        'r011_mengembangkan_modul_berisbns' => 'idx_r011_gen_point',
        'r012_membimbing_pkms' => 'idx_r012_gen_point',
        'r013_orasi_ilmiah_narasumber_bidang_ilmus' => 'idx_r013_gen_point',
        'r014_karya_inovasis' => 'idx_r014_gen_point',
        'r015_menulis_karya_ilmiah_dipublikasikans' => 'idx_r015_gen_point',
        'r016_naskah_buku_bahasa_terbit_edar_inters' => 'idx_r016_gen_point',
        'r017_naskah_buku_bahasa_terbit_edar_nas' => 'idx_r017_gen_point',
        'r018_mendapat_hibah_pkms' => 'idx_r018_gen_point',
        'r019_latih_nyuluh_natar_ceramah_wargas' => 'idx_r019_gen_point',
        'r020_assessor_bkd_lkds' => 'idx_r020_gen_point',
        'r021_reviewer_eclere_penelitian_dosens' => 'idx_r021_gen_point',
        'r022_reviewer_eclere_penelitian_mhs' => 'idx_r022_gen_point',
        'r023_auditor_mutu_assessor_akred_internals' => 'idx_r023_gen_point',
        'r024_tim_akred_prodi_dan_direktorats' => 'idx_r024_gen_point',
        'r025_kepanitiaan_kegiatan_institusis' => 'idx_r025_gen_point',
        'r026_pengelola_jurnal_buletins' => 'idx_r026_gen_point',
        'r027_keanggotaan_senats' => 'idx_r027_gen_point',
        'r028_melaksanakan_pengembangan_diris' => 'idx_r028_gen_point',
        'r029_memperoleh_penghargaans' => 'idx_r029_gen_point',
        'r030_pengelola_kepks' => 'idx_r030_gen_point',
    ];

    public function up(): void
    {
        foreach ($this->rubrikTables as $tableName => $indexName) {
            $this->addIndexIfColumnsExist($tableName, ['periode_id', 'is_bkd', 'is_verified', 'nip'], $indexName);
        }

        $this->addIndexIfColumnsExist('riwayat_points', ['periode_id', 'nip'], 'idx_riwayat_points_periode_nip');
        $this->addIndexIfColumnsExist('riwayat_points', ['periode_id', 'kode_rubrik'], 'idx_riwayat_points_periode_rubrik');
        $this->addIndexIfColumnsExist('rekap_per_dosens', ['periode_id', 'nip'], 'idx_rekap_dosens_periode_nip');
        $this->addIndexIfColumnsExist('rekap_per_rubriks', ['periode_id', 'kode_rubrik'], 'idx_rekap_rubriks_periode_kode');
    }

    public function down(): void
    {
        foreach ($this->rubrikTables as $tableName => $indexName) {
            $this->dropIndexIfTableExists($tableName, $indexName);
        }

        $this->dropIndexIfTableExists('riwayat_points', 'idx_riwayat_points_periode_nip');
        $this->dropIndexIfTableExists('riwayat_points', 'idx_riwayat_points_periode_rubrik');
        $this->dropIndexIfTableExists('rekap_per_dosens', 'idx_rekap_dosens_periode_nip');
        $this->dropIndexIfTableExists('rekap_per_rubriks', 'idx_rekap_rubriks_periode_kode');
    }

    private function addIndexIfColumnsExist(string $tableName, array $columns, string $indexName): void
    {
        if (! Schema::hasTable($tableName)) {
            return;
        }

        foreach ($columns as $column) {
            if (! Schema::hasColumn($tableName, $column)) {
                return;
            }
        }

        if ($this->indexExists($tableName, $indexName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($columns, $indexName) {
            $table->index($columns, $indexName);
        });
    }

    private function dropIndexIfTableExists(string $tableName, string $indexName): void
    {
        if (! $this->indexExists($tableName, $indexName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($indexName) {
            $table->dropIndex($indexName);
        });
    }

    private function indexExists(string $tableName, string $indexName): bool
    {
        if (! Schema::hasTable($tableName)) {
            return false;
        }

        $connection = Schema::getConnection();
        if ($connection->getDriverName() !== 'mysql') {
            return false;
        }

        return ! empty($connection->select(
            'SELECT 1 FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ? LIMIT 1',
            [$connection->getDatabaseName(), $tableName, $indexName]
        ));
    }
};
