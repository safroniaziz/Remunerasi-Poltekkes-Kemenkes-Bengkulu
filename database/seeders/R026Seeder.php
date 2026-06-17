<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R026PengelolaJurnalBuletin;

class R026Seeder extends Seeder
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

        DB::table('r026_pengelola_jurnal_buletins')->insert(array([
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'ketua',
            'edisi_terbit'          =>  10,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[0],
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'ketua',
            'edisi_terbit'          =>  20,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'ketua',
            'edisi_terbit'          =>  30,
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[1],
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'anggota',
            'edisi_terbit'          =>  40,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 => 0.25,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'anggota',
            'edisi_terbit'          =>  50,
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  $periodeId,
                'keterangan'            =>  'Data sample seeder',
            'nip'                   =>  $sampleNips[2],
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'anggota',
            'edisi_terbit'          =>  60,
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.25,
        ]
            ),
        );
    }
}
