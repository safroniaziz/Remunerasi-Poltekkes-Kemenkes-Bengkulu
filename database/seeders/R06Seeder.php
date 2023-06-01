<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R06MengujiUjianOsca;

class R06Seeder extends Seeder
{
    public function run(): void
    {
        DB::table('r06_menguji_ujian_oscas')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_mahasiswa'      =>  10,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_mahasiswa'      =>  20,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  4,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_mahasiswa'      =>  30,
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  6,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_mahasiswa'      =>  40,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  8,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_mahasiswa'      =>  50,
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  10,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_mahasiswa'      =>  60,
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  12,
        ]
            ),

        );
    }
}
