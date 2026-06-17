<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R010MenulisBukuAjarBerisbn;

class R010Seeder extends Seeder
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

        DB::table('r010_menulis_buku_ajar_berisbns')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul'                 =>  10,
            'isbn'                  => '1234',
            'penulis_ke'            => 'utama',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul'                 =>  20,
            'isbn'                  => '1234',
            'penulis_ke'            => 'angggota',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul'                 =>  30,
            'isbn'                  => '1234',
            'penulis_ke'            => 'anggota',
            'jumlah_penulis'        => '4',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul'                 =>  40,
            'isbn'                  => '1234',
            'penulis_ke'            => 'utama',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  8,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul'                 =>  50,
            'isbn'                  => '1234',
            'penulis_ke'            => 'anggota',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul'                 =>  60,
            'isbn'                  => '1234',
            'penulis_ke'            => 'anggota',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ]
            ),
        );

    }
}
