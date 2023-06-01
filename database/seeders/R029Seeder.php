<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R029MemperolehPenghargaan;

class R029Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r029_memperoleh_penghargaans')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_penghargaan'     =>  'dosen_berprestasi_nasional',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_penghargaan'     =>  'dosen_berprestasi_nasional',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_penghargaan'     =>  'reviewer_internasional_berscopus',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.5
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_penghargaan'     =>  'dosen_berprestasi_nasional',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_penghargaan'     =>  'reviewer_internasional_berscopus',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_penghargaan'     =>  'reviewer_internasional_berscopus',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ]
            ),
        );
    }
}
