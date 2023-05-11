<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanDsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,10) as $index) {
            DB::table('jabatan_ds')->insert([
                'nama_jabatan_ds'   =>  $faker->name(),
                'slug'              =>  $faker->name(),
                'grade'             =>  $faker->randomDigit(),
                'harga_point_ds'    =>  $faker->randomDigit(),
                'job_value'         =>  $faker->randomDigit(),
                'pir'               =>  $faker->randomDigit(),
                'harga_jabatan'     =>  $faker->randomDigit(),
                'gaji_blu'          =>  $faker->randomDigit(),
                'insentif_maximum'  =>  $faker->randomDigit(),
            ]);
        }
    }
}
