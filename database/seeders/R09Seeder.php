<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R09MengujiSeminarHasilKtiLtaSkripsi;

class R09Seeder extends Seeder
{

    public function run(): void
    {
        DB::table('r09_menguji_seminar_hasil_kti_lta_skripsis')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_mahasiswa'      =>  10,
            'jenis'                 => 'skripsi',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.6,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'jumlah_mahasiswa'      =>  20,
            'jenis'                 => 'skripsi',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1.2,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_mahasiswa'      =>  30,
            'jenis'                 => 'skripsi',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  1.8,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'jumlah_mahasiswa'      =>  40,
            'jenis'                 => 'skripsi',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2.4,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_mahasiswa'      =>  50,
            'jenis'                 => 'skripsi',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'jumlah_mahasiswa'      =>  60,
            'jenis'                 => 'skripsi',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  3.6,
        ]
            ),
        );
    }
}
