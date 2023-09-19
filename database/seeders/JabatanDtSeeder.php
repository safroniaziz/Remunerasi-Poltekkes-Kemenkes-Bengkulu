<?php

namespace Database\Seeders;

use App\Models\JabatanDt;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JabatanDtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanDosen = [
            [
                'nama_jabatan_dt' => 'Koordinator Program Studi',
                'grade'             =>  1,
                'harga_point_dt'    =>  1,
                'job_value'         =>  1,
                'pir'               =>  1,
                'harga_jabatan'     =>  1,
                'gaji_blu'          =>  1,
                'insentif_maximum'  =>  1,
            ],
            [
                'nama_jabatan_dt' => 'Ketua Jurusan',
                'grade'             =>  1,
                'harga_point_dt'    =>  1,
                'job_value'         =>  1,
                'pir'               =>  1,
                'harga_jabatan'     =>  1,
                'gaji_blu'          =>  1,
                'insentif_maximum'  =>  1,
            ],
            [
                'nama_jabatan_dt' => 'Pembantu Rektor',
                'grade'             =>  1,
                'harga_point_dt'    =>  1,
                'job_value'         =>  1,
                'pir'               =>  1,
                'harga_jabatan'     =>  1,
                'gaji_blu'          =>  1,
                'insentif_maximum'  =>  1,
            ],
            [
                'nama_jabatan_dt' => 'Pembimbing Akademik',
                'grade'             =>  1,
                'harga_point_dt'    =>  1,
                'job_value'         =>  1,
                'pir'               =>  1,
                'harga_jabatan'     =>  1,
                'gaji_blu'          =>  1,
                'insentif_maximum'  =>  1,
            ],
            // Tambahkan jabatan dosen dan tugas tambahan lainnya jika diperlukan
        ];

        foreach ($jabatanDosen as $jabatan) {
            $slug = Str::slug($jabatan['nama_jabatan_dt']);
            $jabatan['slug'] = $slug;
            JabatanDt::create($jabatan);
        }
    }
}
