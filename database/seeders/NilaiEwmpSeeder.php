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
        foreach (range(1,10) as $index) {
            DB::table('nilai_ewmps')->insert([
                'kelompok_rubrik_id'    =>  KelompokRubrik::all()->random()->id,
                'nama_rubrik'           =>  $faker->name(),
                'slug'                  =>  $faker->name(),
                'nama_tabel_rubrik'     =>  $faker->name(),
                'ewmp'                  =>  $faker->randomDigit(),
                'is_active'             => 1,
            ]);
        }
    }
}
