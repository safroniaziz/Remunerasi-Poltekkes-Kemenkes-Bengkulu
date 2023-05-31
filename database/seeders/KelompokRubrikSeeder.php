<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokRubrikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = \Faker\Factory::create();
            DB::table('kelompok_rubriks')->insert(array([
                'id'                    =>  1,
                'nama_kelompok_rubrik'  =>  'RUBRIK PENDIDIKAN REGULER',
                'slug'                  =>  'RUBRIK_PENDIDIKAN_REGULER',
                'is_active'             =>  1,
            ],
            [
                'id'                    =>  2,
                'nama_kelompok_rubrik'  =>  'RUBRIK PENDIDIKAN INSIDENTAL',
                'slug'                  =>  'RUBRIK_PENDIDIKAN_INSIDENTAL',
                'is_active'             =>  1,
            ],
            [
                'id'                    =>  3,
                'nama_kelompok_rubrik'  =>  'RUBRIK PELAKSANAAN PENELITIAN',
                'slug'                  =>  'RUBRIK_PELAKSANAAN_PENELITIAN',
                'is_active'             =>  1,
            ],
            [
                'id'                    =>  4,
                'nama_kelompok_rubrik'  =>  'RUBRIK PELAKSANAAN PENGABDIAN',
                'slug'                  =>  'RUBRIK_PELAKSANAAN_PENGABDIAN',
                'is_active'             =>  1,
            ],
            [
                'id'                    =>  5,
                'nama_kelompok_rubrik'  =>  'RUBRIK PENUNJANG AKADEMIK DOSEN',
                'slug'                  =>  'RUBRIK_PENUNJANG_AKADEMIK_DOSEN',
                'is_active'             =>  1,
            ]
        ),
        );
    }
}
