<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R016NaskahBukuBahasaTerbitEdarInter;

class R016Seeder extends Seeder
{
    public function run(): void
    {
        DB::table('r016_naskah_buku_bahasa_terbit_edar_inters')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  5,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  5,
        ]
            ),
        );
    }
}
