<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PeriodeSeeder::class,
            JabatanDtSeeder::class,
            // PegawaiSeeder::class,
            JabatanDsSeeder::class,
            KelompokRubrikSeeder::class,
            NilaiEwmpSeeder::class,
            // PangkatGolonganSeeder::class,
            // JabatanFungsionalSeeder::class,
            UserRolePermissionSeeder::class,
            // R01Seeder::class,
            // R02Seeder::class,
            // R03Seeder::class,
            // R04Seeder::class,
            // R05Seeder::class,
            // R06Seeder::class,
            // R07Seeder::class,
            // R08Seeder::class,
            // R09Seeder::class,
            // R010Seeder::class,
            // R011Seeder::class,
            // R012Seeder::class,
            // R013Seeder::class,
            // R014Seeder::class,
            // R015Seeder::class,
            // R016Seeder::class,
            // R017Seeder::class,
            // R018Seeder::class,
            // R019Seeder::class,
            // R020Seeder::class,
            // R021Seeder::class,
            // R022Seeder::class,
            // R023Seeder::class,
            // R024Seeder::class,
            // R025Seeder::class,
            // R026Seeder::class,
            // R027Seeder::class,
            // R028Seeder::class,
            // R029Seeder::class,
            // R030Seeder::class,
        ]);
    }
}
