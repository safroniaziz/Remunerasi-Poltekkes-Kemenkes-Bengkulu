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
        DB::table('periodes')->insert([
            'nama_periode'          =>  'Periode Pembayaran Bulan Januari 2023',
            'slug'                  =>  'periode-pembayaran-bulan-januari-2023',
            'periode_siakad_id'     =>  $faker->randomDigit(),
            'semester'              =>  2,
            'tahun_ajaran'          =>  2022,
            'bulan_pembayaran'      =>  1,
            'is_active'             => 1,
        ]);
    }
}
