<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PimpinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pimpinan = User::create([
            'nama_user' => 'Pimpinan',
            'email' => 'pimpinan@mail.com',
            'password' => bcrypt('password'),
        ]);
        $rolePimpinan = Role::firstOrCreate(['name' => 'pimpinan']);
        $pimpinan->assignRole($rolePimpinan);
    }
}
