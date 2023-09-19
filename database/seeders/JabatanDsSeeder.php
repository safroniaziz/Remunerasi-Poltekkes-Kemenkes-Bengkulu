<?php

namespace Database\Seeders;

use App\Models\JabatanDs;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JabatanDsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanFungsional = [
            [
                'nama_jabatan_ds' => 'Asisten Ahli',
                'grade' =>  1,
                'harga_point_ds'    =>  1,
                'job_value' =>  1,
                'pir'   =>  1,
                'harga_jabatan' =>  1,
                'gaji_blu'  =>  1,
                'insentif_maximum'  =>  1,
            ],
            [
                'nama_jabatan_ds' => 'Dosen',
                'grade' =>  1,
                'harga_point_ds'    =>  1,
                'job_value' =>  1,
                'pir'   =>  1,
                'harga_jabatan' =>  1,
                'gaji_blu'  =>  1,
                'insentif_maximum'  =>  1,
            ],
            [
                'nama_jabatan_ds' => 'Lektor',
                'grade' =>  1,
                'harga_point_ds'    =>  1,
                'job_value' =>  1,
                'pir'   =>  1,
                'harga_jabatan' =>  1,
                'gaji_blu'  =>  1,
                'insentif_maximum'  =>  1,
            ],
            [
                'nama_jabatan_ds' => 'Guru Besar',
                'grade' =>  1,
                'harga_point_ds'    =>  1,
                'job_value' =>  1,
                'pir'   =>  1,
                'harga_jabatan' =>  1,
                'gaji_blu'  =>  1,
                'insentif_maximum'  =>  1,
            ],
            // Tambahkan jabatan fungsional lain jika diperlukan
        ];

        // Tambahkan data ke tabel 'jabatan_ds'
        foreach ($jabatanFungsional as $jabatan) {
            $slug = Str::slug($jabatan['nama_jabatan_ds']);
            $jabatan['slug'] = $slug;
            JabatanDs::create($jabatan);
        }
        
    }
}
