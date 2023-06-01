<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R023AuditorMutuAssessorAkredInternal;

class R023Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r023_auditor_mutu_assessor_akred_internals')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.6,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.6,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.6,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.6,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.6,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  'webinar',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.6,
        ]
            ),
        );
    }
}
