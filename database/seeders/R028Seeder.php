<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R028MelaksanakanPengembanganDiri;

class R028Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r028_melaksanakan_pengembangan_diris')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jenis_kegiatan'        =>  'pelatihan',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jenis_kegiatan'        =>  'pelatihan',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jenis_kegiatan'        =>  'workshop',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jenis_kegiatan'        =>  'workshop',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jenis_kegiatan'        =>  'webinar',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.15,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jenis_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.15,
        ]
            ),
        );
    }
}
