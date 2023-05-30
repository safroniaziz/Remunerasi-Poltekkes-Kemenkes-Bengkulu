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
            PegawaiSeeder::class,
            JabatanDsSeeder::class,
            KelompokRubrikSeeder::class,
            NilaiEwmpSeeder::class,
            PangkatGolonganSeeder::class,
            JabatanFungsionalSeeder::class,
            UserRolePermissionSeeder::class,
        ]);
    }
}
