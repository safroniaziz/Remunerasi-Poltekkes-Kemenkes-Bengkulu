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
            'semester'              =>  2,
            'tahun_ajaran'          =>  2022,
            'bulan'                 =>  1,
            'bulan_pembayaran'      =>  1,
            'tanggal_awal'          =>  '2022-08-01',
            'tanggal_akhir'          =>  '2022-08-31',
            'is_active'             =>  1,
            'created_at'            =>  now(),
            'updated_at'            =>  now(),
        ]);
    }
}
