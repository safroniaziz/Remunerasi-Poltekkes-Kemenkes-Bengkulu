<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R012MembimbingPkm;

class R012Seeder extends Seeder
{

    public function run(): void
    {
        DB::table('r012_membimbing_pkms')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'tingkat_pkm'           => 'internasional',
            'juara_ke'              => '1',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'tingkat_pkm'           => 'internasional',
            'juara_ke'              => '2',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'tingkat_pkm'           => 'internasional',
            'juara_ke'              => 'tidak_juara',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'tingkat_pkm'           => 'nasional',
            'juara_ke'              => '1',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'tingkat_pkm'           => 'nasional',
            'juara_ke'              => '2',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'tingkat_pkm'           => 'nasional',
            'juara_ke'              => 'tidak_juara',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.25,
        ]
            ),
        );

    }
}
