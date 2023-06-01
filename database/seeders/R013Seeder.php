<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R013OrasiIlmiahNarasumberBidangIlmu;

class R013Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r013_orasi_ilmiah_narasumber_bidang_ilmus')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  'webinar',
            'tingkatan_ke'          =>  'internasional',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  'webinar',
            'tingkatan_ke'          =>  'internasional',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  'webinar',
            'tingkatan_ke'          =>  'nasional',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  'webinar',
            'tingkatan_ke'          =>  'nasional',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  'webinar',
            'tingkatan_ke'          =>  'regional',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  'webinar',
            'tingkatan_ke'          =>  'regional',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  1,
        ]
            ),
        );
    }
}
