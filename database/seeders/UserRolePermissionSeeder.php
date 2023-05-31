<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        DB::beginTransaction();
        try {
            $operator = User::create(array_merge([
                'email' =>  'operator@gmail.com',
                'nama_user'  =>  'operator',
                'level_jurusan'  =>  'gizi',
                'is_active' =>  1,
            ], $default_user_value));
    
            $administrator = User::create(array_merge([
                'email' =>  'administrator@gmail.com',
                'nama_user'  =>  'administrator',
                'level_jurusan'  =>  'gizi',
                'is_active' =>  1,
            ], $default_user_value));
    
            $pimpinan = User::create(array_merge([
                'email' =>  'pimpinan@gmail.com',
                'nama_user'  =>  'pimpinan',
                'level_jurusan'  =>  'gizi',
                'is_active' =>  1,
            ], $default_user_value));
    
            $role_operator = Role::create([
                'name'  =>  'operator'
            ]);
    
            $role_administrator = Role::create(['name'  =>  'administrator']);
    
            $role_pimpinan = Role::create(['name'  =>  'pimpinan']);
    
            $permission = Permission::create(['name'  =>  'read-role']);
            $permission = Permission::create(['name'  =>  'create-role']);
            $permission = Permission::create(['name'  =>  'update-role']);
            $permission = Permission::create(['name'  =>  'delete-role']);

            $permission = Permission::create(['name'  =>  'create-dosen']);
            $permission = Permission::create(['name'  =>  'edit-dosen']);

            $permission = Permission::create(['name'  =>  'read-presensi']);
            $permission = Permission::create(['name'  =>  'create-presensi']);
            $permission = Permission::create(['name'  =>  'update-presensi']);
            $permission = Permission::create(['name'  =>  'delete-presensi']);

            $role_operator->givePermissionTo('read-role');
            $role_operator->givePermissionTo('create-role');
            $role_operator->givePermissionTo('update-role');
            $role_operator->givePermissionTo('delete-role');
    
            $operator->assignRole('operator');
            $administrator->assignRole('administrator');
            $pimpinan->assignRole('pimpinan');

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
