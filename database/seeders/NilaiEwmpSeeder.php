<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KelompokRubrik;

class NilaiEwmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
            DB::table('nilai_ewmps')->insert([
                'kelompok_rubrik_id'    =>  '1',
                'nama_rubrik'           =>  'Rubrik 01 Perkuliahan Teoris',
                'nama_tabel_rubrik'     =>  'r01_perkuliahan_teoris',
                'ewmp'                  =>  2,
                'is_active'             =>  1,
            ]);
        // foreach (range(1,10) as $index) {
        //     DB::table('nilai_ewmps')->insert([
        //         'kelompok_rubrik_id'    =>  KelompokRubrik::all()->random()->id,
        //         'nama_rubrik'           =>  $faker->name(),
        //         'nama_tabel_rubrik'     =>  $faker->name(),
        //         'ewmp'                  =>  $faker->randomDigit(),
        //         'is_active'             => 1,
        //     ]);
        // }
    }
}
