<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R020AssessorBkdLkd;


class R020Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r020_assessor_bkd_lkds')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_dosen'          =>  8,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_dosen'          =>  16,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_dosen'          =>  24,
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_dosen'          =>  32,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  4,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_dosen'          =>  40,
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_dosen'          =>  48,
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  6,
        ]
            ),
        );
    }
}
