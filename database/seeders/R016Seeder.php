<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R016NaskahBukuBahasaTerbitEdarInter;

class R016Seeder extends Seeder
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

        DB::table('r016_naskah_buku_bahasa_terbit_edar_inters')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  5,

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul_buku'            =>  'webinar',
            'isbn'                  =>  '01234',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  5,
        ]
            ),
        );
    }
}
