<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R017NaskahBukuBahasaTerbitEdarNa;

class R017Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r017_naskah_buku_bahasa_terbit_edar_nas')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  3,
        ]
            ),
        );
    }
}
