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
        $periodeId = DB::table('periodes')->where('is_active', 1)->value('id');

        if (! $periodeId) {
            throw new \RuntimeException('Periode aktif tidak ditemukan.');
        }

        $sampleNips = DB::table('pegawais')
            ->whereNull('deleted_at')
            ->orderBy('nip')
            ->limit(3)
            ->pluck('nip')
            ->all();

        if (count($sampleNips) < 3) {
            throw new \RuntimeException('Minimal 3 pegawai diperlukan untuk seed data rubrik.');
        }

        DB::table('r012_membimbing_pkms')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'tingkat_pkm'           => 'internasional',
            'juara_ke'              => '1',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'tingkat_pkm'           => 'internasional',
            'juara_ke'              => '2',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'tingkat_pkm'           => 'internasional',
            'juara_ke'              => 'tidak_juara',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'tingkat_pkm'           => 'nasional',
            'juara_ke'              => '1',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'tingkat_pkm'           => 'nasional',
            'juara_ke'              => '2',
            'jumlah_pembimbing'     => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
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
