<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;

class PangkatGolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,10) as $index) {
            DB::table('pangkat_golongans')->insert([
                'nip'                   =>  Pegawai::all()->random()->nip,
                'nama_pangkat'          =>  $faker->name(),
                'slug'                  =>  $faker->name(),
                'golongan'              =>  $faker->randomDigit(),
                'tmt_pangkat_golongan'  =>  $faker->dateTime(),
                'is_active'             =>  1,
            ]);
        }
    }
}
