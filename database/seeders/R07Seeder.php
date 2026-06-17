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

        $sampleNips = DB::table('pegawais')
            ->whereNull('deleted_at')
            ->orderBy('nip')
            ->limit(3)
            ->pluck('nip')
            ->all();

        if (count($sampleNips) < 3) {
            throw new \RuntimeException('Minimal 3 pegawai diperlukan untuk seed data rubrik.');
        }

        DB::table('r07_membimbing_skripsi_lta_la_profesis')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'jumlah_mahasiswa'      =>  4,
            'pembimbing_ke'         => 'pembimbing_utama',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'jumlah_mahasiswa'      =>  8,
            'pembimbing_ke'         => 'pembimbing_utama',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'jumlah_mahasiswa'      =>  10,
            'pembimbing_ke'         => 'pembimbing_pendamping',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  2,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'jumlah_mahasiswa'      =>  12,
            'pembimbing_ke'         => 'pembimbing_utama',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'jumlah_mahasiswa'      =>  5,
            'pembimbing_ke'         => 'pembimbing_pendamping',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
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
