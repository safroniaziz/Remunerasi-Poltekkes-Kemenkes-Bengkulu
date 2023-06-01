<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R021ReviewerEclerePenelitianDosen;

class R021Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r021_reviewer_eclere_penelitian_dosens')->insert(array([
            'periode_id'                =>  1,
            'nip'                       =>  198909032015041004,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  1,
            'point'                     =>  0.07,

        ],
        [
            'periode_id'                =>  1,
            'nip'                       =>  198909032015041004,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  1,
            'point'                     =>  0.07,
        ],
        [
            'periode_id'                =>  1,
            'nip'                       =>  199308192022032013,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  1,
            'is_verified'               =>  1,
            'point'                     =>  0.07,
        ],
        [
            'periode_id'                =>  1,
            'nip'                       =>  199308192022032013,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  1,
            'point'                     =>  0.07,
        ],
        [
            'periode_id'                =>  1,
            'nip'                       =>  199201312019031010,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  1,
            'is_verified'               =>  0,
            'point'                     =>  0.07,
        ],
        [
            'periode_id'                =>  1,
            'nip'                       =>  199201312019031010,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  0,
            'point'                     =>  0.07,
        ]
            ),
        );
    }
}
