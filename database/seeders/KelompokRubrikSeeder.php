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
        foreach (range(1,10) as $index) {
            DB::table('kelompok_rubriks')->insert([
                'nama_kelompok_rubrik'    =>  $faker->name(),
                'slug'                    =>  $faker->name(),
                'is_active'               => 1,
            ]);
        }
    }
}
