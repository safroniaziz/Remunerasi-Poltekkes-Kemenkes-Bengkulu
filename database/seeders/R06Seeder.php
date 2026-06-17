<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R06MengujiUjianOsca;

class R06Seeder extends Seeder
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

        DB::table('r06_menguji_ujian_oscas')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'jumlah_mahasiswa'      =>  10,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  2,

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'jumlah_mahasiswa'      =>  20,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  4,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'jumlah_mahasiswa'      =>  30,
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  6,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'jumlah_mahasiswa'      =>  40,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  8,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'jumlah_mahasiswa'      =>  50,
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  10,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'jumlah_mahasiswa'      =>  60,
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  12,
        ]
            ),

        );
    }
}
