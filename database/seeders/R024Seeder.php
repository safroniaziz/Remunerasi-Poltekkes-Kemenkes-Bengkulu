<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R024TimAkredProdiDanDirektorat;

class R024Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r024_tim_akred_prodi_dan_direktorats')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  1,
        ]
            ),
        );
    }
}
