<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;

class JabatanFungsionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,10) as $index) {
            DB::table('jabatan_fungsionals')->insert([
                'nip'                       =>  Pegawai::all()->random()->nip,
                'nama_jabatan_fungsional'   =>  $faker->name(),
                'slug'                      =>  $faker->name(),
                'tmt_jabatan_fungsional'      =>  $faker->dateTime(),
                'is_active'                 =>  1,
            ]);
        }
    }
}
