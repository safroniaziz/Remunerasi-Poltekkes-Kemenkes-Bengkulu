<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R022ReviewerEclerePenelitianMhs;


class R022Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodeId = DB::table('periodes')->where('is_active', 1)->value('id');

        if (! $periodeId) {
            throw new \RuntimeException('Periode aktif tidak ditemukan.');
        }

        DB::table('r022_reviewer_eclere_penelitian_mhs')->insert(array([
            'periode_id'                =>  $periodeId,
            'nip'                       =>  198909032015041004,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  1,
            'point'                     =>  0.03,

        ],
        [
            'periode_id'                =>  $periodeId,
            'nip'                       =>  198909032015041004,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  1,
            'point'                     =>  0.03,
        ],
        [
            'periode_id'                =>  $periodeId,
            'nip'                       =>  199308192022032013,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  1,
            'is_verified'               =>  1,
            'point'                     =>  0.03,
        ],
        [
            'periode_id'                =>  $periodeId,
            'nip'                       =>  199308192022032013,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  1,
            'point'                     =>  0.03,
        ],
        [
            'periode_id'                =>  $periodeId,
            'nip'                       =>  199201312019031010,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  1,
            'is_verified'               =>  0,
            'point'                     =>  0.03,
        ],
        [
            'periode_id'                =>  $periodeId,
            'nip'                       =>  199201312019031010,
            'judul_protokol_penelitian' =>  'webinar',
            'is_bkd'                    =>  0,
            'is_verified'               =>  0,
            'point'                     =>  0.03,
        ]            ),
       );
    }
}
