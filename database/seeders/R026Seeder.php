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
        DB::table('r026_pengelola_jurnal_buletins')->insert(array([
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'ketua',
            'edisi_terbit'          =>  10,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  198909032015041004,
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'ketua',
            'edisi_terbit'          =>  20,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'ketua',
            'edisi_terbit'          =>  30,
            'is_bkd'                =>  1,
            'is_verified'           =>  1,
            'point'                 =>  1,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199308192022032013,
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'anggota',
            'edisi_terbit'          =>  40,
            'is_bkd'                =>  0,
            'is_verified'           =>  1,
            'point'                 => 0.25,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
            'judul_kegiatan'        =>  60,
            'jabatan'               =>  'anggota',
            'edisi_terbit'          =>  50,
            'is_bkd'                =>  1,
            'is_verified'           =>  0,
            'point'                 =>  0.25,
        ],
        [
            'periode_id'            =>  1,
            'nip'                   =>  199201312019031010,
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
