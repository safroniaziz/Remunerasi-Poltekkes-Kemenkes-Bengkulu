<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R05MembimbingPraktikPkkPblKlinik;

class R05Seeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        DB::table('r05_membimbing_praktik_pkk_pbl_kliniks')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_sks'            =>  2,
            'jumlah_mahasiswa'      =>  12,
            'jumlah_tatap_muka'     =>  6,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_sks'            =>  3,
            'jumlah_mahasiswa'      =>  12,
            'jumlah_tatap_muka'     =>  6,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_sks'            =>  4,
            'jumlah_mahasiswa'      =>  12,
            'jumlah_tatap_muka'     =>  6,
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  4,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_sks'            =>  2,
            'jumlah_mahasiswa'      =>  80,
            'jumlah_tatap_muka'     =>  6,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_sks'            =>  3,
            'jumlah_mahasiswa'      =>  80,
            'jumlah_tatap_muka'     =>  6,
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_sks'            =>  4,
            'jumlah_mahasiswa'      =>  80,
            'jumlah_tatap_muka'     =>  6,
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  4,
        ]
            ),

        );
    }
}
