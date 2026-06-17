<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\R025KepanitiaanKegiatanInstitusi;

class R025Seeder extends Seeder
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

        DB::table('r025_kepanitiaan_kegiatan_institusis')->insert(array([
            'periode_id'            =>  $periodeId,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  10,
            'jabatan'               =>  'ketua',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  20,
            'jabatan'               =>  'ketua',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  $periodeId,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  30,
            'jabatan'               =>  'sekretaris',
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  $periodeId,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  40,
            'jabatan'               =>  'sekretaris',
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  $periodeId,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  50,
            'jabatan'               =>  'anggota',
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.2,
        ],
        [
            'periode_id'            =>  $periodeId,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'anggota',
            'is_bkd'                =>  0,
            'is_verified'           =>  0,
            'point'                 =>  0.2,
        ]
            ),
        );
    }
}
