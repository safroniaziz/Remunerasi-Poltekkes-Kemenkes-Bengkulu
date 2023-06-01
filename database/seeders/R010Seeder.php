<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R010MenulisBukuAjarBerisbn;

class R010Seeder extends Seeder
{
    public function run(): void
    {
        DB::table('r010_menulis_buku_ajar_berisbns')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul'                 =>  10,
            'isbn'                  => '1234',
            'penulis_ke'            => 'utama',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul'                 =>  20,
            'isbn'                  => '1234',
            'penulis_ke'            => 'angggota',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul'                 =>  30,
            'isbn'                  => '1234',
            'penulis_ke'            => 'anggota',
            'jumlah_penulis'        => '4',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul'                 =>  40,
            'isbn'                  => '1234',
            'penulis_ke'            => 'utama',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  8,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul'                 =>  50,
            'isbn'                  => '1234',
            'penulis_ke'            => 'anggota',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul'                 =>  60,
            'isbn'                  => '1234',
            'penulis_ke'            => 'anggota',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ]
            ),
        );

    }
}
