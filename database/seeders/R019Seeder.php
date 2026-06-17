<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R019LatihNyuluhNatarCeramahWarga;

class R019Seeder extends Seeder
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

        DB::table('r019_latih_nyuluh_natar_ceramah_wargas')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul_kegiatan'        =>  10,
            'jenis'                 => 'pelatihan_insidentil',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5

        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul_kegiatan'        =>  10,
            'jenis'                 => 'pelatihan_insidentil',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.5
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul_kegiatan'        =>  10,
            'jenis'                 => 'latihan_penyuluhan',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.25
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul_kegiatan'        =>  10,
            'jenis'                 => 'latihan_penyuluhan',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.25
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul_kegiatan'        =>  10,
            'jenis'                 => 'pelatihan_insidentil',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul_kegiatan'        =>  10,
            'jenis'                 => 'pelatihan_insidentil',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.5,
        ]
            ),
        );
    }
}
