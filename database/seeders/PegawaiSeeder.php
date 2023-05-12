<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,10) as $index) {
            DB::table('pegawais')->insert([
                'nip'                   =>  $faker->unique()->randomDigit(),
                'nidn'                  =>  $faker->randomDigit(),
                'nama'                  =>  $faker->name(),
                'slug'                  =>  $faker->name(),
                'email'                 =>  $faker->email(),
                'jenis_kelamin'         =>  $faker->randomElement(['L','P']),
                'jurusan'               =>  $faker->randomElement(['gizi','kebidanan','keperawatan','analis_kesehatan','promosi_kesehatan','kesehatan_lingkungan'], 2),
                'nomor_rekening'        =>  $faker->name(),
                'npwp'                  =>  $faker->randomDigit(),
                'is_serdos'             =>  1,
                'no_sertifikat_serdos'  =>  $faker->randomDigit(),
                'no_whatsapp'           =>  $faker->randomDigit(),
                'is_active'             =>  1,
            ]);
        }
    }
}
