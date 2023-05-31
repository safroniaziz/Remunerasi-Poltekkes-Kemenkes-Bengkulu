<?php

namespace Database\Seeders;

use App\Models\JabatanDt;
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
            DB::table('pegawais')->insert(array([
                'nip'                   =>  198909032015041004,
                'nidn'                  =>  30989,
                'nama'                  =>  'Yudi Setiawan, S.T., M.Eng',
                'slug'                  =>  'yudi-setiawan-s-t-m-eng.',
                'email'                 =>  'yudisetiawan@mail.com',
                'jenis_kelamin'         =>  'L',
                'jurusan'               =>  'gizi',
                'jabatan_dt_id'         =>  1,
                'nomor_rekening'        =>  1234,
                'npwp'                  =>  1234,
                'is_serdos'             =>  1,
                'no_sertifikat_serdos'  =>  1234,
                'no_whatsapp'           =>  1234,
                'is_active'             =>  1,
            ],
            [
                'nip'                   =>  199201312019031010,
                'nidn'                  =>  31019201,
                'nama'                  =>  'Andang Wijanarko, S.Kom., M.Kom.',
                'slug'                  =>  'andang-wijanarko-s-kom-m.kom',
                'email'                 =>  'andangwijanarko@mail.com',
                'jenis_kelamin'         =>  'L',
                'jurusan'               =>  'gizi',
                'jabatan_dt_id'         =>  1,
                'nomor_rekening'        =>  1234,
                'npwp'                  =>  1234,
                'is_serdos'             =>  1,
                'no_sertifikat_serdos'  =>  1234,
                'no_whatsapp'           =>  1234,
                'is_active'             =>  1,
            ],
            [
                'nip'                   =>  199308192022032013,
                'nidn'                  =>  1234,
                'nama'                  =>  'Tiara Eka Putri, S.T., M.Kom',
                'slug'                  =>  'tiara-eka-putri-s-t-m-kom',
                'email'                 =>  'tiaraekaputri@mail.com',
                'jenis_kelamin'         =>  'P',
                'jurusan'               =>  'kebidanan',
                'jabatan_dt_id'         =>  1,
                'nomor_rekening'        =>  1234,
                'npwp'                  =>  1234,
                'is_serdos'             =>  1,
                'no_sertifikat_serdos'  =>  1234,
                'no_whatsapp'           =>  1234,
                'is_active'             =>  1,
            ],
            [
                'nip'                   =>  198701272012122001,
                'nidn'                  =>  1234,
                'nama'                  =>  'Endina Putri Purwandari, S.T., M.Kom.',
                'slug'                  =>  'endina-putri-purwandari-s-t-m-kom',
                'email'                 =>  'endinaputripurwandari@mail.com',
                'jenis_kelamin'         =>  'P',
                'jurusan'               =>  'kebidanan',
                'jabatan_dt_id'         =>  1,
                'nomor_rekening'        =>  1234,
                'npwp'                  =>  1234,
                'is_serdos'             =>  1,
                'no_sertifikat_serdos'  =>  1234,
                'no_whatsapp'           =>  1234,
                'is_active'             =>  1,
            ],
            [
                'nip'                   =>  199007092019032025,
                'nidn'                  =>  1234,
                'nama'                  =>  'Julia Purnama Sari, S.T., M.Kom',
                'slug'                  =>  'julia-purnama-sari-s-t-m-kom',
                'email'                 =>  'juliapurnamasari@mail.com',
                'jenis_kelamin'         =>  'P',
                'jurusan'               =>  'kebidanan',
                'jabatan_dt_id'         =>  1,
                'nomor_rekening'        =>  1234,
                'npwp'                  =>  1234,
                'is_serdos'             =>  1,
                'no_sertifikat_serdos'  =>  1234,
                'no_whatsapp'           =>  1234,
                'is_active'             =>  1,
            ],
            ),
            );
    }
}
