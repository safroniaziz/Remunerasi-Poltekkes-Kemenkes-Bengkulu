<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R01PerkuliahanTeori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class R01Seeder extends Seeder
{
    private function getRandomMatkul()
    {
        $matkuls = ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Sejarah', 'Geografi'];
        return $matkuls[array_rand($matkuls)];
    }

    // Fungsi untuk mendapatkan pilihan antara 8 dan 16 secara acak
    private function getRandomTatapMuka()
    {
        return (rand(0, 1) === 0) ? 8 : 16;
    }


    public function run(): void
    {
        $periodeId = DB::table('periodes')->where('is_active', 1)->value('id');

        if (! $periodeId) {
            throw new \RuntimeException('Periode aktif tidak ditemukan.');
        }

        $dosenData = Pegawai::all();
        foreach ($dosenData as $dosen) {
            $nip = $dosen['nip'];
            $nama_matkul = $this->getRandomMatkul();
            $jumlah_sks = 2;
            $jumlah_mahasiswa = 40;
            $jumlah_tatap_muka = $this->getRandomTatapMuka();
            $is_bkd = rand(0, 1);
            $is_verified = rand(0, 1);
            $point = 1;

            // Query untuk memasukkan data ke tabel r01perkulianteoris menggunakan Query Builder
            DB::table('r01_perkuliahan_teoris')->insert([
                'periode_id' => $periodeId,
                'keterangan'            =>  'Data sample seeder',
                'nip' => $nip,
                'nama_matkul' => $nama_matkul,
                'kode_kelas' => 'A',
                'jumlah_sks' => $jumlah_sks,
                'jumlah_mahasiswa' => $jumlah_mahasiswa,
                'jumlah_tatap_muka' => $jumlah_tatap_muka,
                'is_bkd' => $is_bkd,
                'is_verified' => $is_verified,
                'sumber_data' => 'manual',
                'point' => $point,
            ]);
        }
        // $faker = \Faker\Factory::create();
        // DB::table('r01_perkuliahan_teoris')->insert(array([
        //     'periode_id'            =>  $periodeId,
        //     'nip'                   =>  198909032015041004,
        //     'nama_matkul'           =>  'kesehatan',
        //     'nama_matkul'           =>  'kesehatan',
        //     'jumlah_sks'            =>  2,
        //     'jumlah_mahasiswa'      =>  40,
        //     'jumlah_tatap_muka'     =>  16,
        //     'is_bkd'                =>  0,
        //     'is_verified'           =>  1,
        //     'point'                 =>  1,

        // ],
        // [
        //     'periode_id'            =>  $periodeId,
        //     'nip'                   =>  198909032015041004,
        //     'nama_matkul'           =>  'kesehatan',
        //     'jumlah_sks'            =>  3,
        //     'jumlah_mahasiswa'      =>  40,
        //     'jumlah_tatap_muka'     =>  16,
        //     'is_bkd'                =>  0,
        //     'is_verified'           =>  1,
        //     'point'                 =>  3,
        // ],
        // [
        //     'periode_id'            =>  $periodeId,
        //     'nip'                   =>  199308192022032013,
        //     'nama_matkul'           =>  'kesehatan',
        //     'jumlah_sks'            =>  4,
        //     'jumlah_mahasiswa'      =>  40,
        //     'jumlah_tatap_muka'     =>  16,
        //     'is_bkd'                =>  1,
        //     'is_verified'           =>  1,
        //     'point'                 =>  4,
        // ],
        // [
        //     'periode_id'            =>  $periodeId,
        //     'nip'                   =>  199308192022032013,
        //     'nama_matkul'           =>  'kesehatan',
        //     'jumlah_sks'            =>  2,
        //     'jumlah_mahasiswa'      =>  80,
        //     'jumlah_tatap_muka'     =>  16,
        //     'is_bkd'                =>  0,
        //     'is_verified'           =>  1,
        //     'point'                 =>  2,
        // ],
        // [
        //     'periode_id'            =>  $periodeId,
        //     'nip'                   =>  199201312019031010,
        //     'nama_matkul'           =>  'kesehatan',
        //     'jumlah_sks'            =>  3,
        //     'jumlah_mahasiswa'      =>  80,
        //     'jumlah_tatap_muka'     =>  16,
        //     'is_bkd'                =>  1,
        //     'is_verified'           =>  0,
        //     'point'                 =>  3,
        // ],
        // [
        //     'periode_id'            =>  $periodeId,
        //     'nip'                   =>  199201312019031010,
        //     'nama_matkul'           =>  'kesehatan',
        //     'jumlah_sks'            =>  4,
        //     'jumlah_mahasiswa'      =>  80,
        //     'jumlah_tatap_muka'     =>  16,
        //     'is_bkd'                =>  0,
        //     'is_verified'           =>  0,
        //     'point'                 =>  4,
        // ]
        //     ),

        // );
    }
}
