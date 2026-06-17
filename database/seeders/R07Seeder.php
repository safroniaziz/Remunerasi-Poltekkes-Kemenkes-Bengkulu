<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R07MembimbingSkripsiLtaLaProfesi;

class R07Seeder extends Seeder
{
    public function run(): void
    {
        $periodeId = DB::table('periodes')->where('is_active', 1)->value('id');

        if (! $periodeId) {
            throw new \RuntimeException('Periode aktif tidak ditemukan.');
        }

        DB::table('r07_membimbing_skripsi_lta_la_profesis')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  198909032015041004,
            'jumlah_mahasiswa'      =>  4,
            'pembimbing_ke'         => 'pembimbing_utama',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  198909032015041004,
            'jumlah_mahasiswa'      =>  8,
            'pembimbing_ke'         => 'pembimbing_utama',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199308192022032013,
            'jumlah_mahasiswa'      =>  10,
            'pembimbing_ke'         => 'pembimbing_pendamping',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199308192022032013,
            'jumlah_mahasiswa'      =>  12,
            'pembimbing_ke'         => 'pembimbing_utama',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199201312019031010,
            'jumlah_mahasiswa'      =>  5,
            'pembimbing_ke'         => 'pembimbing_pendamping',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  199201312019031010,
            'jumlah_mahasiswa'      =>  15,
            'pembimbing_ke'         => 'pembimbing_pendamping',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  3,
        ]
            ),

        );
    }
}
