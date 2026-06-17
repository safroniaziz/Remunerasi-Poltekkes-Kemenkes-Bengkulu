<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R027KeanggotaanSenat;

class R027Seeder extends Seeder
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

        DB::table('r027_keanggotaan_senats')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  198909032015041004,
            'jabatan'               =>  'ketua',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  198909032015041004,
            'jabatan'               =>  'ketua',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199308192022032013,
            'jabatan'               =>  'sekretaris',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.75,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199308192022032013,
            'jabatan'               =>  'sekretaris',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.75,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199201312019031010,
            'jabatan'               =>  'anggota',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199201312019031010,
            'jabatan'               =>  'anggota',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ]
            ),
        );
    }
}
