<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R014KaryaInovasi;

class R014Seeder extends Seeder
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

        $sampleNips = DB::table('pegawais')
            ->whereNull('deleted_at')
            ->orderBy('nip')
            ->limit(3)
            ->pluck('nip')
            ->all();

        if (count($sampleNips) < 3) {
            throw new \RuntimeException('Minimal 3 pegawai diperlukan untuk seed data rubrik.');
        }

        DB::table('r014_karya_inovasis')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul'                 => 'webinar',
            'penulis_ke'            => 'utama',
            'jenis'                 => 'menghasilkan_pendapatan_blu',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  3,

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul'                 => 'webinar',
            'penulis_ke'            => 'anggota',
            'jenis'                 => 'menghasilkan_pendapatan_blu',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul'                 => 'webinar',
            'penulis_ke'            => 'utama',
            'jenis'                 => 'paten_belum_dikonversi',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  2.4,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul'                 => 'webinar',
            'penulis_ke'            => 'anggota',
            'jenis'                 => 'paten_belum_dikonversi',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.8,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul'                 => 'webinar',
            'penulis_ke'            => 'utama',
            'jenis'                 => 'paten_sederhana',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  1.8,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul'                 => 'webinar',
            'penulis_ke'            => 'anggota',
            'jenis'                 => 'paten_sederhana',
            'jumlah_penulis'        => '2',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.6,
        ]
            ),
        );
    }
}
