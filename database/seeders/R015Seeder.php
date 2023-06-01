<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R015MenulisKaryaIlmiahDipublikasikan;

class R015Seeder extends Seeder
{
    public function run(): void
    {
        DB::table('r015_menulis_karya_ilmiah_dipublikasikans')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul'                 => 'webinar',
            'penulis_ke'            => 'utama',
            'jenis'                 => 'internasional_Q3',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  4.8,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul'                 => 'webinar',
            'penulis_ke'            => 'anggota',
            'jenis'                 => 'internasional_Q3',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1.6,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul'                 => 'webinar',
            'penulis_ke'            => 'utama',
            'jenis'                 => 'nasional_sinta_3',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  3.6,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul'                 => 'webinar',
            'penulis_ke'            => 'anggota',
            'jenis'                 => 'nasional_sinta_3',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1.2,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul'                 => 'webinar',
            'penulis_ke'            => 'utama',
            'jenis'                 => 'seminar_oral_presentation_internasional',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  1.2,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul'                 => 'webinar',
            'penulis_ke'            => 'anggota',
            'jenis'                 => 'seminar_poster_nasional',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  1,
        ]
            ),
        );
    }
}
