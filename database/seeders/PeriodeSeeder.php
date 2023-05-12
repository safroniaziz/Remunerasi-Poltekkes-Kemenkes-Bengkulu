<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,1) as $index) {
            DB::table('periodes')->insert([
                'nama_periode'          =>  $faker->name(),
                'slug'                  =>  $faker->name(),
                'periode_siakad_id'     =>  $faker->randomDigit(),
                'semester'              =>  $faker->randomDigit(),
                'tahun_ajaran'          =>  $faker->randomDigit(),
                'bulan'                 =>  $faker->randomDigit(),
                'bulan_pembayaran'      =>  $faker->randomDigit(),
                'is_active'             => 1,
            ]);
        }
    }
}
