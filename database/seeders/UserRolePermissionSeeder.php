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
        // DB::beginTransaction();
        // try {
            $operator = User::create(array_merge([
                'email' =>  'operator@mail.com',
                'nama_user'  =>  'operator',
                'is_active' =>  1,
            ], $default_user_value));

            $verifikator1 = User::create(array_merge([
                'email' =>  'verifikator1@mail.com',
                'nama_user'  =>  'verifikator',
                'is_active' =>  1,
            ], $default_user_value));

            $verifikator2 = User::create(array_merge([
                'email' =>  'verifikator2@mail.com',
                'nama_user'  =>  'verifikator',
                'is_active' =>  1,
            ], $default_user_value));

            $verifikator3 = User::create(array_merge([
                'email' =>  'verifikator3@mail.com',
                'nama_user'  =>  'verifikator',
                'is_active' =>  1,
            ], $default_user_value));

            $verifikator4 = User::create(array_merge([
                'email' =>  'verifikator4@mail.com',
                'nama_user'  =>  'verifikator',
                'is_active' =>  1,
            ], $default_user_value));

            $verifikator5 = User::create(array_merge([
                'email' =>  'verifikator5@mail.com',
                'nama_user'  =>  'verifikator',
                'is_active' =>  1,
            ], $default_user_value));

            $administrator = User::create(array_merge([
                'email' =>  'administrator@mail.com',
                'nama_user'  =>  'administrator',
                'is_active' =>  1,
            ], $default_user_value));

            $pimpinan = User::create(array_merge([
                'email' =>  'pimpinan@mail.com',
                'nama_user'  =>  'pimpinan',
                'is_active' =>  1,
            ], $default_user_value));

            $role_operator = Role::create([
                'name'  =>  'operator'
            ]);

            $role_administrator = Role::create(['name'  =>  'administrator']);

            $role_pimpinan = Role::create(['name'  =>  'pimpinan']);

            $role_verifikator = Role::create(['name'  =>  'verifikator']);

            $permission = Permission::create(['name'  =>  'read-role']);
            $permission = Permission::create(['name'  =>  'store-role']);
            $permission = Permission::create(['name'  =>  'edit-role']);
            $permission = Permission::create(['name'  =>  'update-role']);
            $permission = Permission::create(['name'  =>  'delete-role']);

            $permission = Permission::create(['name'  =>  'read-role-has-permission']);
            $permission = Permission::create(['name'  =>  'store-role-has-permission']);
            $permission = Permission::create(['name'  =>  'edit-role-has-permission']);
            $permission = Permission::create(['name'  =>  'update-role-has-permission']);
            $permission = Permission::create(['name'  =>  'delete-role-has-permission']);

            $permission = Permission::create(['name'  =>  'read-dokumen']);
            $permission = Permission::create(['name'  =>  'create-dokumen']);
            $permission = Permission::create(['name'  =>  'store-dokumen']);
            $permission = Permission::create(['name'  =>  'edit-dokumen']);
            $permission = Permission::create(['name'  =>  'update-dokumen']);
            $permission = Permission::create(['name'  =>  'delete-dokumen']);

            $permission = Permission::create(['name'  =>  'read-jabatan-ds']);
            $permission = Permission::create(['name'  =>  'create-jabatan-ds']);
            $permission = Permission::create(['name'  =>  'store-jabatan-ds']);
            $permission = Permission::create(['name'  =>  'edit-jabatan-ds']);
            $permission = Permission::create(['name'  =>  'update-jabatan-ds']);
            $permission = Permission::create(['name'  =>  'delete-jabatan-ds']);

            $permission = Permission::create(['name'  =>  'read-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'create-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'store-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'edit-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'update-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'delete-jabatan-dt']);

            $permission = Permission::create(['name'  =>  'read-jabatan-fungsional']);
            $permission = Permission::create(['name'  =>  'create-jabatan-fungsional']);
            $permission = Permission::create(['name'  =>  'store-jabatan-fungsional']);
            $permission = Permission::create(['name'  =>  'edit-jabatan-fungsional']);
            $permission = Permission::create(['name'  =>  'update-jabatan-fungsional']);
            $permission = Permission::create(['name'  =>  'delete-jabatan-fungsional']);

            $permission = Permission::create(['name'  =>  'read-kelompok-rubrik']);
            $permission = Permission::create(['name'  =>  'create-kelompok-rubrik']);
            $permission = Permission::create(['name'  =>  'store-kelompok-rubrik']);
            $permission = Permission::create(['name'  =>  'edit-kelompok-rubrik']);
            $permission = Permission::create(['name'  =>  'update-kelompok-rubrik']);
            $permission = Permission::create(['name'  =>  'delete-kelompok-rubrik']);

            $permission = Permission::create(['name'  =>  'read-nilai-ewmp']);
            $permission = Permission::create(['name'  =>  'create-nilai-ewmp']);
            $permission = Permission::create(['name'  =>  'store-nilai-ewmp']);
            $permission = Permission::create(['name'  =>  'edit-nilai-ewmp']);
            $permission = Permission::create(['name'  =>  'update-nilai-ewmp']);
            $permission = Permission::create(['name'  =>  'delete-nilai-ewmp']);

            $permission = Permission::create(['name'  =>  'read-pangkat-golongan']);
            $permission = Permission::create(['name'  =>  'create-pangkat-golongan']);
            $permission = Permission::create(['name'  =>  'store-pangkat-golongan']);
            $permission = Permission::create(['name'  =>  'edit-pangkat-golongan']);
            $permission = Permission::create(['name'  =>  'update-pangkat-golongan']);
            $permission = Permission::create(['name'  =>  'delete-pangkat-golongan']);

            $permission = Permission::create(['name'  =>  'read-pegawai']);
            $permission = Permission::create(['name'  =>  'create-pegawai']);
            $permission = Permission::create(['name'  =>  'store-pegawai']);
            $permission = Permission::create(['name'  =>  'edit-pegawai']);
            $permission = Permission::create(['name'  =>  'update-pegawai']);

            $permission = Permission::create(['name'  =>  'read-pengumumen']);
            $permission = Permission::create(['name'  =>  'create-pengumumen']);
            $permission = Permission::create(['name'  =>  'store-pengumumen']);
            $permission = Permission::create(['name'  =>  'edit-pengumumen']);
            $permission = Permission::create(['name'  =>  'update-pengumumen']);
            $permission = Permission::create(['name'  =>  'delete-pengumumen']);

            $permission = Permission::create(['name'  =>  'read-periode']);
            $permission = Permission::create(['name'  =>  'create-periode']);
            $permission = Permission::create(['name'  =>  'store-periode']);
            $permission = Permission::create(['name'  =>  'edit-periode']);
            $permission = Permission::create(['name'  =>  'update-periode']);
            $permission = Permission::create(['name'  =>  'delete-periode']);

            $permission = Permission::create(['name'  =>  'read-pesan']);
            $permission = Permission::create(['name'  =>  'create-pesan']);
            $permission = Permission::create(['name'  =>  'store-pesan']);
            $permission = Permission::create(['name'  =>  'edit-pesan']);
            $permission = Permission::create(['name'  =>  'update-pesan']);
            $permission = Permission::create(['name'  =>  'delete-pesan']);

            $permission = Permission::create(['name'  =>  'read-presensi']);
            $permission = Permission::create(['name'  =>  'create-presensi']);
            $permission = Permission::create(['name'  =>  'store-presensi']);
            $permission = Permission::create(['name'  =>  'edit-presensi']);
            $permission = Permission::create(['name'  =>  'update-presensi']);
            $permission = Permission::create(['name'  =>  'delete-presensi']);

            $permission = Permission::create(['name'  =>  'read-rekap-daftar-nominatif']);
            $permission = Permission::create(['name'  =>  'create-rekap-daftar-nominatif']);
            $permission = Permission::create(['name'  =>  'store-rekap-daftar-nominatif']);
            $permission = Permission::create(['name'  =>  'edit-rekap-daftar-nominatif']);
            $permission = Permission::create(['name'  =>  'update-rekap-daftar-nominatif']);
            $permission = Permission::create(['name'  =>  'delete-rekap-daftar-nominatif']);

            $permission = Permission::create(['name'  =>  'read-riwayat-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'create-riwayat-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'store-riwayat-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'edit-riwayat-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'update-riwayat-jabatan-dt']);
            $permission = Permission::create(['name'  =>  'delete-riwayat-jabatan-dt']);

            $permission = Permission::create(['name'  =>  'read-riwayat-point']);
            $permission = Permission::create(['name'  =>  'create-riwayat-point']);
            $permission = Permission::create(['name'  =>  'store-riwayat-point']);
            $permission = Permission::create(['name'  =>  'edit-riwayat-point']);
            $permission = Permission::create(['name'  =>  'update-riwayat-point']);
            $permission = Permission::create(['name'  =>  'delete-riwayat-point']);

            $permission = Permission::create(['name'  =>  'read-user']);
            $permission = Permission::create(['name'  =>  'create-user']);
            $permission = Permission::create(['name'  =>  'store-user']);
            $permission = Permission::create(['name'  =>  'edit-user']);
            $permission = Permission::create(['name'  =>  'update-user']);
            $permission = Permission::create(['name'  =>  'delete-user']);

            $permission = Permission::create(['name'  =>  'read-r01-perkuliahan-teori']);
            $permission = Permission::create(['name'  =>  'store-r01-perkuliahan-teori']);
            $permission = Permission::create(['name'  =>  'edit-r01-perkuliahan-teori']);
            $permission = Permission::create(['name'  =>  'update-r01-perkuliahan-teori']);
            $permission = Permission::create(['name'  =>  'delete-r01-perkuliahan-teori']);

            $permission = Permission::create(['name'  =>  'read-r02-perkuliahan-praktikum']);
            $permission = Permission::create(['name'  =>  'store-r02-perkuliahan-praktikum']);
            $permission = Permission::create(['name'  =>  'edit-r02-perkuliahan-praktikum']);
            $permission = Permission::create(['name'  =>  'update-r02-perkuliahan-praktikum']);
            $permission = Permission::create(['name'  =>  'delete-r02-perkuliahan-praktikum']);

            $permission = Permission::create(['name'  =>  'read-r03-membimbing-capaian-kompetensi']);
            $permission = Permission::create(['name'  =>  'store-r03-membimbing-capaian-kompetensi']);
            $permission = Permission::create(['name'  =>  'edit-r03-membimbing-capaian-kompetensi']);
            $permission = Permission::create(['name'  =>  'update-r03-membimbing-capaian-kompetensi']);
            $permission = Permission::create(['name'  =>  'delete-r03-membimbing-capaian-kompetensi']);

            $permission = Permission::create(['name'  =>  'read-r04-membimbing-pendampingan-ukom']);
            $permission = Permission::create(['name'  =>  'store-r04-membimbing-pendampingan-ukom']);
            $permission = Permission::create(['name'  =>  'edit-r04-membimbing-pendampingan-ukom']);
            $permission = Permission::create(['name'  =>  'update-r04-membimbing-pendampingan-ukom']);
            $permission = Permission::create(['name'  =>  'delete-r04-membimbing-pendampingan-ukom']);

            $permission = Permission::create(['name'  =>  'read-r05-membimbing-praktik-pkk-pbl-klinik']);
            $permission = Permission::create(['name'  =>  'store-r05-membimbing-praktik-pkk-pbl-klinik']);
            $permission = Permission::create(['name'  =>  'edit-r05-membimbing-praktik-pkk-pbl-klinik']);
            $permission = Permission::create(['name'  =>  'update-r05-membimbing-praktik-pkk-pbl-klinik']);
            $permission = Permission::create(['name'  =>  'delete-r05-membimbing-praktik-pkk-pbl-klinik']);

            $permission = Permission::create(['name'  =>  'read-r06-menguji-ujian-osca']);
            $permission = Permission::create(['name'  =>  'store-r06-menguji-ujian-osca']);
            $permission = Permission::create(['name'  =>  'edit-r06-menguji-ujian-osca']);
            $permission = Permission::create(['name'  =>  'update-r06-menguji-ujian-osca']);
            $permission = Permission::create(['name'  =>  'delete-r06-menguji-ujian-osca']);

            $permission = Permission::create(['name'  =>  'read-r07-membimbing-skripsi-lta-la-profesi']);
            $permission = Permission::create(['name'  =>  'store-r07-membimbing-skripsi-lta-la-profesi']);
            $permission = Permission::create(['name'  =>  'edit-r07-membimbing-skripsi-lta-la-profesi']);
            $permission = Permission::create(['name'  =>  'update-r07-membimbing-skripsi-lta-la-profesi']);
            $permission = Permission::create(['name'  =>  'delete-r07-membimbing-skripsi-lta-la-profesi']);

            $permission = Permission::create(['name'  =>  'read-r08-menguji-seminar-proposal-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'store-r08-menguji-seminar-proposal-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'edit-r08-menguji-seminar-proposal-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'update-r08-menguji-seminar-proposal-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'delete-r08-menguji-seminar-proposal-kti-lta-skripsi']);

            $permission = Permission::create(['name'  =>  'read-r09-menguji-seminar-hasil-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'store-r09-menguji-seminar-hasil-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'edit-r09-menguji-seminar-hasil-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'update-r09-menguji-seminar-hasil-kti-lta-skripsi']);
            $permission = Permission::create(['name'  =>  'delete-r09-menguji-seminar-hasil-kti-lta-skripsi']);

            $permission = Permission::create(['name'  =>  'read-r010-menulis-buku-ajar-berisbn']);
            $permission = Permission::create(['name'  =>  'store-r010-menulis-buku-ajar-berisbn']);
            $permission = Permission::create(['name'  =>  'edit-r010-menulis-buku-ajar-berisbn']);
            $permission = Permission::create(['name'  =>  'update-r010-menulis-buku-ajar-berisbn']);
            $permission = Permission::create(['name'  =>  'delete-r010-menulis-buku-ajar-berisbn']);

            $permission = Permission::create(['name'  =>  'read-r011-mengembangkan-modul-berisbn']);
            $permission = Permission::create(['name'  =>  'store-r011-mengembangkan-modul-berisbn']);
            $permission = Permission::create(['name'  =>  'edit-r011-mengembangkan-modul-berisbn']);
            $permission = Permission::create(['name'  =>  'update-r011-mengembangkan-modul-berisbn']);
            $permission = Permission::create(['name'  =>  'delete-r011-mengembangkan-modul-berisbn']);

            $permission = Permission::create(['name'  =>  'read-r012-membimbing-pkm']);
            $permission = Permission::create(['name'  =>  'store-r012-membimbing-pkm']);
            $permission = Permission::create(['name'  =>  'edit-r012-membimbing-pkm']);
            $permission = Permission::create(['name'  =>  'update-r012-membimbing-pkm']);
            $permission = Permission::create(['name'  =>  'delete-r012-membimbing-pkm']);

            $permission = Permission::create(['name'  =>  'read-r013-orasi-ilmiah-narasumber-bidang-ilmu']);
            $permission = Permission::create(['name'  =>  'store-r013-orasi-ilmiah-narasumber-bidang-ilmu']);
            $permission = Permission::create(['name'  =>  'edit-r013-orasi-ilmiah-narasumber-bidang-ilmu']);
            $permission = Permission::create(['name'  =>  'update-r013-orasi-ilmiah-narasumber-bidang-ilmu']);
            $permission = Permission::create(['name'  =>  'delete-r013-orasi-ilmiah-narasumber-bidang-ilmu']);

            $permission = Permission::create(['name'  =>  'read-r014-karya-inovasi']);
            $permission = Permission::create(['name'  =>  'store-r014-karya-inovasi']);
            $permission = Permission::create(['name'  =>  'edit-r014-karya-inovasi']);
            $permission = Permission::create(['name'  =>  'update-r014-karya-inovasi']);
            $permission = Permission::create(['name'  =>  'delete-r014-karya-inovasi']);

            $permission = Permission::create(['name'  =>  'read-r015-menulis-karya-ilmiah-dipublikasikan']);
            $permission = Permission::create(['name'  =>  'store-r015-menulis-karya-ilmiah-dipublikasikan']);
            $permission = Permission::create(['name'  =>  'edit-r015-menulis-karya-ilmiah-dipublikasikan']);
            $permission = Permission::create(['name'  =>  'update-r015-menulis-karya-ilmiah-dipublikasikan']);
            $permission = Permission::create(['name'  =>  'delete-r015-menulis-karya-ilmiah-dipublikasikan']);

            $permission = Permission::create(['name'  =>  'read-r016-naskah-buku-bahasa-terbit-edar-inter']);
            $permission = Permission::create(['name'  =>  'store-r016-naskah-buku-bahasa-terbit-edar-inter']);
            $permission = Permission::create(['name'  =>  'edit-r016-naskah-buku-bahasa-terbit-edar-inter']);
            $permission = Permission::create(['name'  =>  'update-r016-naskah-buku-bahasa-terbit-edar-inter']);
            $permission = Permission::create(['name'  =>  'delete-r016-naskah-buku-bahasa-terbit-edar-inter']);

            $permission = Permission::create(['name'  =>  'read-r017-naskah-buku-bahasa-terbit-edar-nas']);
            $permission = Permission::create(['name'  =>  'store-r017-naskah-buku-bahasa-terbit-edar-nas']);
            $permission = Permission::create(['name'  =>  'edit-r017-naskah-buku-bahasa-terbit-edar-nas']);
            $permission = Permission::create(['name'  =>  'update-r017-naskah-buku-bahasa-terbit-edar-nas']);
            $permission = Permission::create(['name'  =>  'delete-r017-naskah-buku-bahasa-terbit-edar-nas']);

            $permission = Permission::create(['name'  =>  'read-r018-mendapat-hibah-pkm']);
            $permission = Permission::create(['name'  =>  'store-r018-mendapat-hibah-pkm']);
            $permission = Permission::create(['name'  =>  'edit-r018-mendapat-hibah-pkm']);
            $permission = Permission::create(['name'  =>  'update-r018-mendapat-hibah-pkm']);
            $permission = Permission::create(['name'  =>  'delete-r018-mendapat-hibah-pkm']);

            $permission = Permission::create(['name'  =>  'read-r019-latih-nyuluh-natar-ceramah-warga']);
            $permission = Permission::create(['name'  =>  'store-r019-latih-nyuluh-natar-ceramah-warga']);
            $permission = Permission::create(['name'  =>  'edit-r019-latih-nyuluh-natar-ceramah-warga']);
            $permission = Permission::create(['name'  =>  'update-r019-latih-nyuluh-natar-ceramah-warga']);
            $permission = Permission::create(['name'  =>  'delete-r019-latih-nyuluh-natar-ceramah-warga']);

            $permission = Permission::create(['name'  =>  'read-r020-assessor-bkd-lkd']);
            $permission = Permission::create(['name'  =>  'store-r020-assessor-bkd-lkd']);
            $permission = Permission::create(['name'  =>  'edit-r020-assessor-bkd-lkd']);
            $permission = Permission::create(['name'  =>  'update-r020-assessor-bkd-lkd']);
            $permission = Permission::create(['name'  =>  'delete-r020-assessor-bkd-lkd']);

            $permission = Permission::create(['name'  =>  'read-r021-reviewer-eclere-penelitian-dosen']);
            $permission = Permission::create(['name'  =>  'store-r021-reviewer-eclere-penelitian-dosen']);
            $permission = Permission::create(['name'  =>  'edit-r021-reviewer-eclere-penelitian-dosen']);
            $permission = Permission::create(['name'  =>  'update-r021-reviewer-eclere-penelitian-dosen']);
            $permission = Permission::create(['name'  =>  'delete-r021-reviewer-eclere-penelitian-dosen']);

            $permission = Permission::create(['name'  =>  'read-r022-reviewer-eclere-penelitian-mhs']);
            $permission = Permission::create(['name'  =>  'store-r022-reviewer-eclere-penelitian-mhs']);
            $permission = Permission::create(['name'  =>  'edit-r022-reviewer-eclere-penelitian-mhs']);
            $permission = Permission::create(['name'  =>  'update-r022-reviewer-eclere-penelitian-mhs']);
            $permission = Permission::create(['name'  =>  'delete-r022-reviewer-eclere-penelitian-mhs']);

            $permission = Permission::create(['name'  =>  'read-r023-auditor-mutu-assessor-akred-internal']);
            $permission = Permission::create(['name'  =>  'store-r023-auditor-mutu-assessor-akred-internal']);
            $permission = Permission::create(['name'  =>  'edit-r023-auditor-mutu-assessor-akred-internal']);
            $permission = Permission::create(['name'  =>  'update-r023-auditor-mutu-assessor-akred-internal']);
            $permission = Permission::create(['name'  =>  'delete-r023-auditor-mutu-assessor-akred-internal']);

            $permission = Permission::create(['name'  =>  'read-r024-tim-akred-prodi-dan-direktorat']);
            $permission = Permission::create(['name'  =>  'store-r024-tim-akred-prodi-dan-direktorat']);
            $permission = Permission::create(['name'  =>  'edit-r024-tim-akred-prodi-dan-direktorat']);
            $permission = Permission::create(['name'  =>  'update-r024-tim-akred-prodi-dan-direktorat']);
            $permission = Permission::create(['name'  =>  'delete-r024-tim-akred-prodi-dan-direktorat']);

            $permission = Permission::create(['name'  =>  'read-r025-kepanitiaan-kegiatan-institusi']);
            $permission = Permission::create(['name'  =>  'store-r025-kepanitiaan-kegiatan-institusi']);
            $permission = Permission::create(['name'  =>  'edit-r025-kepanitiaan-kegiatan-institusi']);
            $permission = Permission::create(['name'  =>  'update-r025-kepanitiaan-kegiatan-institusi']);
            $permission = Permission::create(['name'  =>  'delete-r025-kepanitiaan-kegiatan-institusi']);

            $permission = Permission::create(['name'  =>  'read-r026-pengelola-jurnal-buletin']);
            $permission = Permission::create(['name'  =>  'store-r026-pengelola-jurnal-buletin']);
            $permission = Permission::create(['name'  =>  'edit-r026-pengelola-jurnal-buletin']);
            $permission = Permission::create(['name'  =>  'update-r026-pengelola-jurnal-buletin']);
            $permission = Permission::create(['name'  =>  'delete-r026-pengelola-jurnal-buletin']);

            $permission = Permission::create(['name'  =>  'read-r027-keanggotaan-senat']);
            $permission = Permission::create(['name'  =>  'store-r027-keanggotaan-senat']);
            $permission = Permission::create(['name'  =>  'edit-r027-keanggotaan-senat']);
            $permission = Permission::create(['name'  =>  'update-r027-keanggotaan-senat']);
            $permission = Permission::create(['name'  =>  'delete-r027-keanggotaan-senat']);

            $permission = Permission::create(['name'  =>  'read-r028-melaksanakan-pengembangan-diri']);
            $permission = Permission::create(['name'  =>  'store-r028-melaksanakan-pengembangan-diri']);
            $permission = Permission::create(['name'  =>  'edit-r028-melaksanakan-pengembangan-diri']);
            $permission = Permission::create(['name'  =>  'update-r028-melaksanakan-pengembangan-diri']);
            $permission = Permission::create(['name'  =>  'delete-r028-melaksanakan-pengembangan-diri']);

            $permission = Permission::create(['name'  =>  'read-r029-memperoleh-penghargaan']);
            $permission = Permission::create(['name'  =>  'store-r029-memperoleh-penghargaan']);
            $permission = Permission::create(['name'  =>  'edit-r029-memperoleh-penghargaan']);
            $permission = Permission::create(['name'  =>  'update-r029-memperoleh-penghargaan']);
            $permission = Permission::create(['name'  =>  'delete-r029-memperoleh-penghargaan']);

            $permission = Permission::create(['name'  =>  'read-r030-pengelola-kepk']);
            $permission = Permission::create(['name'  =>  'store-r030-pengelola-kepk']);
            $permission = Permission::create(['name'  =>  'edit-r030-pengelola-kepk']);
            $permission = Permission::create(['name'  =>  'update-r030-pengelola-kepk']);
            $permission = Permission::create(['name'  =>  'delete-r030-pengelola-kepk']);

            $role_operator->givePermissionTo('read-r01-perkuliahan-teori');
            $role_operator->givePermissionTo('store-r01-perkuliahan-teori');
            $role_operator->givePermissionTo('edit-r01-perkuliahan-teori');
            $role_operator->givePermissionTo('update-r01-perkuliahan-teori');
            $role_operator->givePermissionTo('delete-r01-perkuliahan-teori');

            $role_operator->givePermissionTo('read-r02-perkuliahan-praktikum');
            $role_operator->givePermissionTo('store-r02-perkuliahan-praktikum');
            $role_operator->givePermissionTo('edit-r02-perkuliahan-praktikum');
            $role_operator->givePermissionTo('update-r02-perkuliahan-praktikum');
            $role_operator->givePermissionTo('delete-r02-perkuliahan-praktikum');

            $role_operator->givePermissionTo('read-r03-membimbing-capaian-kompetensi');
            $role_operator->givePermissionTo('store-r03-membimbing-capaian-kompetensi');
            $role_operator->givePermissionTo('edit-r03-membimbing-capaian-kompetensi');
            $role_operator->givePermissionTo('update-r03-membimbing-capaian-kompetensi');
            $role_operator->givePermissionTo('delete-r03-membimbing-capaian-kompetensi');

            $role_operator->givePermissionTo('read-r04-membimbing-pendampingan-ukom');
            $role_operator->givePermissionTo('store-r04-membimbing-pendampingan-ukom');
            $role_operator->givePermissionTo('edit-r04-membimbing-pendampingan-ukom');
            $role_operator->givePermissionTo('update-r04-membimbing-pendampingan-ukom');
            $role_operator->givePermissionTo('delete-r04-membimbing-pendampingan-ukom');

            $role_operator->givePermissionTo('read-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_operator->givePermissionTo('store-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_operator->givePermissionTo('edit-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_operator->givePermissionTo('update-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_operator->givePermissionTo('delete-r05-membimbing-praktik-pkk-pbl-klinik');

            $role_operator->givePermissionTo('read-r06-menguji-ujian-osca');
            $role_operator->givePermissionTo('store-r06-menguji-ujian-osca');
            $role_operator->givePermissionTo('edit-r06-menguji-ujian-osca');
            $role_operator->givePermissionTo('update-r06-menguji-ujian-osca');
            $role_operator->givePermissionTo('delete-r06-menguji-ujian-osca');

            $role_operator->givePermissionTo('read-r07-membimbing-skripsi-lta-la-profesi');
            $role_operator->givePermissionTo('store-r07-membimbing-skripsi-lta-la-profesi');
            $role_operator->givePermissionTo('edit-r07-membimbing-skripsi-lta-la-profesi');
            $role_operator->givePermissionTo('update-r07-membimbing-skripsi-lta-la-profesi');
            $role_operator->givePermissionTo('delete-r07-membimbing-skripsi-lta-la-profesi');

            $role_operator->givePermissionTo('read-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_operator->givePermissionTo('store-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_operator->givePermissionTo('edit-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_operator->givePermissionTo('update-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_operator->givePermissionTo('delete-r08-menguji-seminar-proposal-kti-lta-skripsi');

            $role_operator->givePermissionTo('read-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_operator->givePermissionTo('store-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_operator->givePermissionTo('edit-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_operator->givePermissionTo('update-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_operator->givePermissionTo('delete-r09-menguji-seminar-hasil-kti-lta-skripsi');

            $role_operator->givePermissionTo('read-r010-menulis-buku-ajar-berisbn');
            $role_operator->givePermissionTo('store-r010-menulis-buku-ajar-berisbn');
            $role_operator->givePermissionTo('edit-r010-menulis-buku-ajar-berisbn');
            $role_operator->givePermissionTo('update-r010-menulis-buku-ajar-berisbn');
            $role_operator->givePermissionTo('delete-r010-menulis-buku-ajar-berisbn');

            $role_operator->givePermissionTo('read-r011-mengembangkan-modul-berisbn');
            $role_operator->givePermissionTo('store-r011-mengembangkan-modul-berisbn');
            $role_operator->givePermissionTo('edit-r011-mengembangkan-modul-berisbn');
            $role_operator->givePermissionTo('update-r011-mengembangkan-modul-berisbn');
            $role_operator->givePermissionTo('delete-r011-mengembangkan-modul-berisbn');

            $role_operator->givePermissionTo('read-r012-membimbing-pkm');
            $role_operator->givePermissionTo('store-r012-membimbing-pkm');
            $role_operator->givePermissionTo('edit-r012-membimbing-pkm');
            $role_operator->givePermissionTo('update-r012-membimbing-pkm');
            $role_operator->givePermissionTo('delete-r012-membimbing-pkm');

            $role_operator->givePermissionTo('read-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_operator->givePermissionTo('store-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_operator->givePermissionTo('edit-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_operator->givePermissionTo('update-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_operator->givePermissionTo('delete-r013-orasi-ilmiah-narasumber-bidang-ilmu');

            $role_operator->givePermissionTo('read-r014-karya-inovasi');
            $role_operator->givePermissionTo('store-r014-karya-inovasi');
            $role_operator->givePermissionTo('edit-r014-karya-inovasi');
            $role_operator->givePermissionTo('update-r014-karya-inovasi');
            $role_operator->givePermissionTo('delete-r014-karya-inovasi');

            $role_operator->givePermissionTo('read-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_operator->givePermissionTo('store-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_operator->givePermissionTo('edit-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_operator->givePermissionTo('update-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_operator->givePermissionTo('delete-r015-menulis-karya-ilmiah-dipublikasikan');

            $role_operator->givePermissionTo('read-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_operator->givePermissionTo('store-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_operator->givePermissionTo('edit-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_operator->givePermissionTo('update-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_operator->givePermissionTo('delete-r016-naskah-buku-bahasa-terbit-edar-inter');

            $role_operator->givePermissionTo('read-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_operator->givePermissionTo('store-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_operator->givePermissionTo('edit-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_operator->givePermissionTo('update-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_operator->givePermissionTo('delete-r017-naskah-buku-bahasa-terbit-edar-nas');

            $role_operator->givePermissionTo('read-r018-mendapat-hibah-pkm');
            $role_operator->givePermissionTo('store-r018-mendapat-hibah-pkm');
            $role_operator->givePermissionTo('edit-r018-mendapat-hibah-pkm');
            $role_operator->givePermissionTo('update-r018-mendapat-hibah-pkm');
            $role_operator->givePermissionTo('delete-r018-mendapat-hibah-pkm');

            $role_operator->givePermissionTo('read-r019-latih-nyuluh-natar-ceramah-warga');
            $role_operator->givePermissionTo('store-r019-latih-nyuluh-natar-ceramah-warga');
            $role_operator->givePermissionTo('edit-r019-latih-nyuluh-natar-ceramah-warga');
            $role_operator->givePermissionTo('update-r019-latih-nyuluh-natar-ceramah-warga');
            $role_operator->givePermissionTo('delete-r019-latih-nyuluh-natar-ceramah-warga');

            $role_operator->givePermissionTo('read-r020-assessor-bkd-lkd');
            $role_operator->givePermissionTo('store-r020-assessor-bkd-lkd');
            $role_operator->givePermissionTo('edit-r020-assessor-bkd-lkd');
            $role_operator->givePermissionTo('update-r020-assessor-bkd-lkd');
            $role_operator->givePermissionTo('delete-r020-assessor-bkd-lkd');

            $role_operator->givePermissionTo('read-r021-reviewer-eclere-penelitian-dosen');
            $role_operator->givePermissionTo('store-r021-reviewer-eclere-penelitian-dosen');
            $role_operator->givePermissionTo('edit-r021-reviewer-eclere-penelitian-dosen');
            $role_operator->givePermissionTo('update-r021-reviewer-eclere-penelitian-dosen');
            $role_operator->givePermissionTo('delete-r021-reviewer-eclere-penelitian-dosen');

            $role_operator->givePermissionTo('read-r022-reviewer-eclere-penelitian-mhs');
            $role_operator->givePermissionTo('store-r022-reviewer-eclere-penelitian-mhs');
            $role_operator->givePermissionTo('edit-r022-reviewer-eclere-penelitian-mhs');
            $role_operator->givePermissionTo('update-r022-reviewer-eclere-penelitian-mhs');
            $role_operator->givePermissionTo('delete-r022-reviewer-eclere-penelitian-mhs');

            $role_operator->givePermissionTo('read-r023-auditor-mutu-assessor-akred-internal');
            $role_operator->givePermissionTo('store-r023-auditor-mutu-assessor-akred-internal');
            $role_operator->givePermissionTo('edit-r023-auditor-mutu-assessor-akred-internal');
            $role_operator->givePermissionTo('update-r023-auditor-mutu-assessor-akred-internal');
            $role_operator->givePermissionTo('delete-r023-auditor-mutu-assessor-akred-internal');

            $role_operator->givePermissionTo('read-r024-tim-akred-prodi-dan-direktorat');
            $role_operator->givePermissionTo('store-r024-tim-akred-prodi-dan-direktorat');
            $role_operator->givePermissionTo('edit-r024-tim-akred-prodi-dan-direktorat');
            $role_operator->givePermissionTo('update-r024-tim-akred-prodi-dan-direktorat');
            $role_operator->givePermissionTo('delete-r024-tim-akred-prodi-dan-direktorat');

            $role_operator->givePermissionTo('read-r025-kepanitiaan-kegiatan-institusi');
            $role_operator->givePermissionTo('store-r025-kepanitiaan-kegiatan-institusi');
            $role_operator->givePermissionTo('edit-r025-kepanitiaan-kegiatan-institusi');
            $role_operator->givePermissionTo('update-r025-kepanitiaan-kegiatan-institusi');
            $role_operator->givePermissionTo('delete-r025-kepanitiaan-kegiatan-institusi');

            $role_operator->givePermissionTo('read-r026-pengelola-jurnal-buletin');
            $role_operator->givePermissionTo('store-r026-pengelola-jurnal-buletin');
            $role_operator->givePermissionTo('edit-r026-pengelola-jurnal-buletin');
            $role_operator->givePermissionTo('update-r026-pengelola-jurnal-buletin');
            $role_operator->givePermissionTo('delete-r026-pengelola-jurnal-buletin');

            $role_operator->givePermissionTo('read-r027-keanggotaan-senat');
            $role_operator->givePermissionTo('store-r027-keanggotaan-senat');
            $role_operator->givePermissionTo('edit-r027-keanggotaan-senat');
            $role_operator->givePermissionTo('update-r027-keanggotaan-senat');
            $role_operator->givePermissionTo('delete-r027-keanggotaan-senat');

            $role_operator->givePermissionTo('read-r028-melaksanakan-pengembangan-diri');
            $role_operator->givePermissionTo('store-r028-melaksanakan-pengembangan-diri');
            $role_operator->givePermissionTo('edit-r028-melaksanakan-pengembangan-diri');
            $role_operator->givePermissionTo('update-r028-melaksanakan-pengembangan-diri');
            $role_operator->givePermissionTo('delete-r028-melaksanakan-pengembangan-diri');

            $role_operator->givePermissionTo('read-r029-memperoleh-penghargaan');
            $role_operator->givePermissionTo('store-r029-memperoleh-penghargaan');
            $role_operator->givePermissionTo('edit-r029-memperoleh-penghargaan');
            $role_operator->givePermissionTo('update-r029-memperoleh-penghargaan');
            $role_operator->givePermissionTo('delete-r029-memperoleh-penghargaan');

            $role_operator->givePermissionTo('read-r030-pengelola-kepk');
            $role_operator->givePermissionTo('store-r030-pengelola-kepk');
            $role_operator->givePermissionTo('edit-r030-pengelola-kepk');
            $role_operator->givePermissionTo('update-r030-pengelola-kepk');
            $role_operator->givePermissionTo('delete-r030-pengelola-kepk');

            $role_verifikator->givePermissionTo('read-r01-perkuliahan-teori');
            $role_verifikator->givePermissionTo('store-r01-perkuliahan-teori');
            $role_verifikator->givePermissionTo('edit-r01-perkuliahan-teori');
            $role_verifikator->givePermissionTo('update-r01-perkuliahan-teori');
            $role_verifikator->givePermissionTo('delete-r01-perkuliahan-teori');

            $role_verifikator->givePermissionTo('read-r02-perkuliahan-praktikum');
            $role_verifikator->givePermissionTo('store-r02-perkuliahan-praktikum');
            $role_verifikator->givePermissionTo('edit-r02-perkuliahan-praktikum');
            $role_verifikator->givePermissionTo('update-r02-perkuliahan-praktikum');
            $role_verifikator->givePermissionTo('delete-r02-perkuliahan-praktikum');

            $role_verifikator->givePermissionTo('read-r03-membimbing-capaian-kompetensi');
            $role_verifikator->givePermissionTo('store-r03-membimbing-capaian-kompetensi');
            $role_verifikator->givePermissionTo('edit-r03-membimbing-capaian-kompetensi');
            $role_verifikator->givePermissionTo('update-r03-membimbing-capaian-kompetensi');
            $role_verifikator->givePermissionTo('delete-r03-membimbing-capaian-kompetensi');

            $role_verifikator->givePermissionTo('read-r04-membimbing-pendampingan-ukom');
            $role_verifikator->givePermissionTo('store-r04-membimbing-pendampingan-ukom');
            $role_verifikator->givePermissionTo('edit-r04-membimbing-pendampingan-ukom');
            $role_verifikator->givePermissionTo('update-r04-membimbing-pendampingan-ukom');
            $role_verifikator->givePermissionTo('delete-r04-membimbing-pendampingan-ukom');

            $role_verifikator->givePermissionTo('read-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_verifikator->givePermissionTo('store-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_verifikator->givePermissionTo('edit-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_verifikator->givePermissionTo('update-r05-membimbing-praktik-pkk-pbl-klinik');
            $role_verifikator->givePermissionTo('delete-r05-membimbing-praktik-pkk-pbl-klinik');

            $role_verifikator->givePermissionTo('read-r06-menguji-ujian-osca');
            $role_verifikator->givePermissionTo('store-r06-menguji-ujian-osca');
            $role_verifikator->givePermissionTo('edit-r06-menguji-ujian-osca');
            $role_verifikator->givePermissionTo('update-r06-menguji-ujian-osca');
            $role_verifikator->givePermissionTo('delete-r06-menguji-ujian-osca');

            $role_verifikator->givePermissionTo('read-r07-membimbing-skripsi-lta-la-profesi');
            $role_verifikator->givePermissionTo('store-r07-membimbing-skripsi-lta-la-profesi');
            $role_verifikator->givePermissionTo('edit-r07-membimbing-skripsi-lta-la-profesi');
            $role_verifikator->givePermissionTo('update-r07-membimbing-skripsi-lta-la-profesi');
            $role_verifikator->givePermissionTo('delete-r07-membimbing-skripsi-lta-la-profesi');

            $role_verifikator->givePermissionTo('read-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('store-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('edit-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('update-r08-menguji-seminar-proposal-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('delete-r08-menguji-seminar-proposal-kti-lta-skripsi');

            $role_verifikator->givePermissionTo('read-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('store-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('edit-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('update-r09-menguji-seminar-hasil-kti-lta-skripsi');
            $role_verifikator->givePermissionTo('delete-r09-menguji-seminar-hasil-kti-lta-skripsi');

            $role_verifikator->givePermissionTo('read-r010-menulis-buku-ajar-berisbn');
            $role_verifikator->givePermissionTo('store-r010-menulis-buku-ajar-berisbn');
            $role_verifikator->givePermissionTo('edit-r010-menulis-buku-ajar-berisbn');
            $role_verifikator->givePermissionTo('update-r010-menulis-buku-ajar-berisbn');
            $role_verifikator->givePermissionTo('delete-r010-menulis-buku-ajar-berisbn');

            $role_verifikator->givePermissionTo('read-r011-mengembangkan-modul-berisbn');
            $role_verifikator->givePermissionTo('store-r011-mengembangkan-modul-berisbn');
            $role_verifikator->givePermissionTo('edit-r011-mengembangkan-modul-berisbn');
            $role_verifikator->givePermissionTo('update-r011-mengembangkan-modul-berisbn');
            $role_verifikator->givePermissionTo('delete-r011-mengembangkan-modul-berisbn');

            $role_verifikator->givePermissionTo('read-r012-membimbing-pkm');
            $role_verifikator->givePermissionTo('store-r012-membimbing-pkm');
            $role_verifikator->givePermissionTo('edit-r012-membimbing-pkm');
            $role_verifikator->givePermissionTo('update-r012-membimbing-pkm');
            $role_verifikator->givePermissionTo('delete-r012-membimbing-pkm');

            $role_verifikator->givePermissionTo('read-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_verifikator->givePermissionTo('store-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_verifikator->givePermissionTo('edit-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_verifikator->givePermissionTo('update-r013-orasi-ilmiah-narasumber-bidang-ilmu');
            $role_verifikator->givePermissionTo('delete-r013-orasi-ilmiah-narasumber-bidang-ilmu');

            $role_verifikator->givePermissionTo('read-r014-karya-inovasi');
            $role_verifikator->givePermissionTo('store-r014-karya-inovasi');
            $role_verifikator->givePermissionTo('edit-r014-karya-inovasi');
            $role_verifikator->givePermissionTo('update-r014-karya-inovasi');
            $role_verifikator->givePermissionTo('delete-r014-karya-inovasi');

            $role_verifikator->givePermissionTo('read-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_verifikator->givePermissionTo('store-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_verifikator->givePermissionTo('edit-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_verifikator->givePermissionTo('update-r015-menulis-karya-ilmiah-dipublikasikan');
            $role_verifikator->givePermissionTo('delete-r015-menulis-karya-ilmiah-dipublikasikan');

            $role_verifikator->givePermissionTo('read-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_verifikator->givePermissionTo('store-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_verifikator->givePermissionTo('edit-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_verifikator->givePermissionTo('update-r016-naskah-buku-bahasa-terbit-edar-inter');
            $role_verifikator->givePermissionTo('delete-r016-naskah-buku-bahasa-terbit-edar-inter');

            $role_verifikator->givePermissionTo('read-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_verifikator->givePermissionTo('store-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_verifikator->givePermissionTo('edit-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_verifikator->givePermissionTo('update-r017-naskah-buku-bahasa-terbit-edar-nas');
            $role_verifikator->givePermissionTo('delete-r017-naskah-buku-bahasa-terbit-edar-nas');

            $role_verifikator->givePermissionTo('read-r018-mendapat-hibah-pkm');
            $role_verifikator->givePermissionTo('store-r018-mendapat-hibah-pkm');
            $role_verifikator->givePermissionTo('edit-r018-mendapat-hibah-pkm');
            $role_verifikator->givePermissionTo('update-r018-mendapat-hibah-pkm');
            $role_verifikator->givePermissionTo('delete-r018-mendapat-hibah-pkm');

            $role_verifikator->givePermissionTo('read-r019-latih-nyuluh-natar-ceramah-warga');
            $role_verifikator->givePermissionTo('store-r019-latih-nyuluh-natar-ceramah-warga');
            $role_verifikator->givePermissionTo('edit-r019-latih-nyuluh-natar-ceramah-warga');
            $role_verifikator->givePermissionTo('update-r019-latih-nyuluh-natar-ceramah-warga');
            $role_verifikator->givePermissionTo('delete-r019-latih-nyuluh-natar-ceramah-warga');

            $role_verifikator->givePermissionTo('read-r020-assessor-bkd-lkd');
            $role_verifikator->givePermissionTo('store-r020-assessor-bkd-lkd');
            $role_verifikator->givePermissionTo('edit-r020-assessor-bkd-lkd');
            $role_verifikator->givePermissionTo('update-r020-assessor-bkd-lkd');
            $role_verifikator->givePermissionTo('delete-r020-assessor-bkd-lkd');

            $role_verifikator->givePermissionTo('read-r021-reviewer-eclere-penelitian-dosen');
            $role_verifikator->givePermissionTo('store-r021-reviewer-eclere-penelitian-dosen');
            $role_verifikator->givePermissionTo('edit-r021-reviewer-eclere-penelitian-dosen');
            $role_verifikator->givePermissionTo('update-r021-reviewer-eclere-penelitian-dosen');
            $role_verifikator->givePermissionTo('delete-r021-reviewer-eclere-penelitian-dosen');

            $role_verifikator->givePermissionTo('read-r022-reviewer-eclere-penelitian-mhs');
            $role_verifikator->givePermissionTo('store-r022-reviewer-eclere-penelitian-mhs');
            $role_verifikator->givePermissionTo('edit-r022-reviewer-eclere-penelitian-mhs');
            $role_verifikator->givePermissionTo('update-r022-reviewer-eclere-penelitian-mhs');
            $role_verifikator->givePermissionTo('delete-r022-reviewer-eclere-penelitian-mhs');

            $role_verifikator->givePermissionTo('read-r023-auditor-mutu-assessor-akred-internal');
            $role_verifikator->givePermissionTo('store-r023-auditor-mutu-assessor-akred-internal');
            $role_verifikator->givePermissionTo('edit-r023-auditor-mutu-assessor-akred-internal');
            $role_verifikator->givePermissionTo('update-r023-auditor-mutu-assessor-akred-internal');
            $role_verifikator->givePermissionTo('delete-r023-auditor-mutu-assessor-akred-internal');

            $role_verifikator->givePermissionTo('read-r024-tim-akred-prodi-dan-direktorat');
            $role_verifikator->givePermissionTo('store-r024-tim-akred-prodi-dan-direktorat');
            $role_verifikator->givePermissionTo('edit-r024-tim-akred-prodi-dan-direktorat');
            $role_verifikator->givePermissionTo('update-r024-tim-akred-prodi-dan-direktorat');
            $role_verifikator->givePermissionTo('delete-r024-tim-akred-prodi-dan-direktorat');

            $role_verifikator->givePermissionTo('read-r025-kepanitiaan-kegiatan-institusi');
            $role_verifikator->givePermissionTo('store-r025-kepanitiaan-kegiatan-institusi');
            $role_verifikator->givePermissionTo('edit-r025-kepanitiaan-kegiatan-institusi');
            $role_verifikator->givePermissionTo('update-r025-kepanitiaan-kegiatan-institusi');
            $role_verifikator->givePermissionTo('delete-r025-kepanitiaan-kegiatan-institusi');

            $role_verifikator->givePermissionTo('read-r026-pengelola-jurnal-buletin');
            $role_verifikator->givePermissionTo('store-r026-pengelola-jurnal-buletin');
            $role_verifikator->givePermissionTo('edit-r026-pengelola-jurnal-buletin');
            $role_verifikator->givePermissionTo('update-r026-pengelola-jurnal-buletin');
            $role_verifikator->givePermissionTo('delete-r026-pengelola-jurnal-buletin');

            $role_verifikator->givePermissionTo('read-r027-keanggotaan-senat');
            $role_verifikator->givePermissionTo('store-r027-keanggotaan-senat');
            $role_verifikator->givePermissionTo('edit-r027-keanggotaan-senat');
            $role_verifikator->givePermissionTo('update-r027-keanggotaan-senat');
            $role_verifikator->givePermissionTo('delete-r027-keanggotaan-senat');

            $role_verifikator->givePermissionTo('read-r028-melaksanakan-pengembangan-diri');
            $role_verifikator->givePermissionTo('store-r028-melaksanakan-pengembangan-diri');
            $role_verifikator->givePermissionTo('edit-r028-melaksanakan-pengembangan-diri');
            $role_verifikator->givePermissionTo('update-r028-melaksanakan-pengembangan-diri');
            $role_verifikator->givePermissionTo('delete-r028-melaksanakan-pengembangan-diri');

            $role_verifikator->givePermissionTo('read-r029-memperoleh-penghargaan');
            $role_verifikator->givePermissionTo('store-r029-memperoleh-penghargaan');
            $role_verifikator->givePermissionTo('edit-r029-memperoleh-penghargaan');
            $role_verifikator->givePermissionTo('update-r029-memperoleh-penghargaan');
            $role_verifikator->givePermissionTo('delete-r029-memperoleh-penghargaan');

            $role_verifikator->givePermissionTo('read-r030-pengelola-kepk');
            $role_verifikator->givePermissionTo('store-r030-pengelola-kepk');
            $role_verifikator->givePermissionTo('edit-r030-pengelola-kepk');
            $role_verifikator->givePermissionTo('update-r030-pengelola-kepk');
            $role_verifikator->givePermissionTo('delete-r030-pengelola-kepk');

            $role_administrator->givePermissionTo('read-user');
            $role_administrator->givePermissionTo('store-user');
            $role_administrator->givePermissionTo('edit-user');
            $role_administrator->givePermissionTo('update-user');
            $role_administrator->givePermissionTo('delete-user');

            $role_administrator->givePermissionTo('read-role');
            $role_administrator->givePermissionTo('store-role');
            $role_administrator->givePermissionTo('edit-role');
            $role_administrator->givePermissionTo('update-role');
            $role_administrator->givePermissionTo('delete-role');

            $role_administrator->givePermissionTo('read-role-has-permission');
            $role_administrator->givePermissionTo('store-role-has-permission');
            $role_administrator->givePermissionTo('edit-role-has-permission');
            $role_administrator->givePermissionTo('update-role-has-permission');
            $role_administrator->givePermissionTo('delete-role-has-permission');

            $role_administrator->givePermissionTo('read-dokumen');
            $role_administrator->givePermissionTo('create-dokumen');
            $role_administrator->givePermissionTo('store-dokumen');
            $role_administrator->givePermissionTo('edit-dokumen');
            $role_administrator->givePermissionTo('update-dokumen');
            $role_administrator->givePermissionTo('delete-dokumen');

            $role_administrator->givePermissionTo('read-jabatan-ds');
            $role_administrator->givePermissionTo('create-jabatan-ds');
            $role_administrator->givePermissionTo('store-jabatan-ds');
            $role_administrator->givePermissionTo('edit-jabatan-ds');
            $role_administrator->givePermissionTo('update-jabatan-ds');
            $role_administrator->givePermissionTo('delete-jabatan-ds');

            $role_administrator->givePermissionTo('read-jabatan-dt');
            $role_administrator->givePermissionTo('create-jabatan-dt');
            $role_administrator->givePermissionTo('store-jabatan-dt');
            $role_administrator->givePermissionTo('edit-jabatan-dt');
            $role_administrator->givePermissionTo('update-jabatan-dt');
            $role_administrator->givePermissionTo('delete-jabatan-dt');

            $role_administrator->givePermissionTo('read-jabatan-fungsional');
            $role_administrator->givePermissionTo('create-jabatan-fungsional');
            $role_administrator->givePermissionTo('store-jabatan-fungsional');
            $role_administrator->givePermissionTo('edit-jabatan-fungsional');
            $role_administrator->givePermissionTo('update-jabatan-fungsional');
            $role_administrator->givePermissionTo('delete-jabatan-fungsional');

            $role_administrator->givePermissionTo('read-kelompok-rubrik');
            $role_administrator->givePermissionTo('create-kelompok-rubrik');
            $role_administrator->givePermissionTo('store-kelompok-rubrik');
            $role_administrator->givePermissionTo('edit-kelompok-rubrik');
            $role_administrator->givePermissionTo('update-kelompok-rubrik');
            $role_administrator->givePermissionTo('delete-kelompok-rubrik');

            $role_administrator->givePermissionTo('read-nilai-ewmp');
            $role_administrator->givePermissionTo('create-nilai-ewmp');
            $role_administrator->givePermissionTo('store-nilai-ewmp');
            $role_administrator->givePermissionTo('edit-nilai-ewmp');
            $role_administrator->givePermissionTo('update-nilai-ewmp');
            $role_administrator->givePermissionTo('delete-nilai-ewmp');

            $role_administrator->givePermissionTo('read-pangkat-golongan');
            $role_administrator->givePermissionTo('create-pangkat-golongan');
            $role_administrator->givePermissionTo('store-pangkat-golongan');
            $role_administrator->givePermissionTo('edit-pangkat-golongan');
            $role_administrator->givePermissionTo('update-pangkat-golongan');
            $role_administrator->givePermissionTo('delete-pangkat-golongan');

            $role_administrator->givePermissionTo('read-pegawai');
            $role_administrator->givePermissionTo('create-pegawai');
            $role_administrator->givePermissionTo('store-pegawai');
            $role_administrator->givePermissionTo('edit-pegawai');
            $role_administrator->givePermissionTo('update-pegawai');

            $role_administrator->givePermissionTo('read-pengumumen');
            $role_administrator->givePermissionTo('create-pengumumen');
            $role_administrator->givePermissionTo('store-pengumumen');
            $role_administrator->givePermissionTo('edit-pengumumen');
            $role_administrator->givePermissionTo('update-pengumumen');
            $role_administrator->givePermissionTo('delete-pengumumen');

            $role_administrator->givePermissionTo('read-periode');
            $role_administrator->givePermissionTo('create-periode');
            $role_administrator->givePermissionTo('store-periode');
            $role_administrator->givePermissionTo('edit-periode');
            $role_administrator->givePermissionTo('update-periode');
            $role_administrator->givePermissionTo('delete-periode');

            $role_administrator->givePermissionTo('read-pesan');
            $role_administrator->givePermissionTo('create-pesan');
            $role_administrator->givePermissionTo('store-pesan');
            $role_administrator->givePermissionTo('edit-pesan');
            $role_administrator->givePermissionTo('update-pesan');
            $role_administrator->givePermissionTo('delete-pesan');

            $role_administrator->givePermissionTo('read-presensi');
            $role_administrator->givePermissionTo('create-presensi');
            $role_administrator->givePermissionTo('store-presensi');
            $role_administrator->givePermissionTo('edit-presensi');
            $role_administrator->givePermissionTo('update-presensi');
            $role_administrator->givePermissionTo('delete-presensi');

            $role_administrator->givePermissionTo('read-rekap-daftar-nominatif');
            $role_administrator->givePermissionTo('store-rekap-daftar-nominatif');
            $role_administrator->givePermissionTo('update-rekap-daftar-nominatif');
            $role_administrator->givePermissionTo('delete-rekap-daftar-nominatif');

            $role_administrator->givePermissionTo('read-riwayat-jabatan-dt');
            $role_administrator->givePermissionTo('store-riwayat-jabatan-dt');
            $role_administrator->givePermissionTo('update-riwayat-jabatan-dt');
            $role_administrator->givePermissionTo('delete-riwayat-jabatan-dt');

            $role_administrator->givePermissionTo('read-riwayat-point');
            $role_administrator->givePermissionTo('store-riwayat-point');
            $role_administrator->givePermissionTo('update-riwayat-point');
            $role_administrator->givePermissionTo('delete-riwayat-point');

            $role_administrator->givePermissionTo('read-user');
            $role_administrator->givePermissionTo('create-user');
            $role_administrator->givePermissionTo('store-user');
            $role_administrator->givePermissionTo('edit-user');
            $role_administrator->givePermissionTo('update-user');
            $role_administrator->givePermissionTo('delete-user');

            $role_pimpinan->givePermissionTo('read-rekap-daftar-nominatif');

            $operator->assignRole('operator');
            $verifikator1->assignRole('verifikator');
            $verifikator2->assignRole('verifikator');
            $verifikator3->assignRole('verifikator');
            $verifikator4->assignRole('verifikator');
            $verifikator5->assignRole('verifikator');
            $administrator->assignRole('administrator');
            $pimpinan->assignRole('pimpinan');

            DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        // }
    }
}
