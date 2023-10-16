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
        $data = [
            [
                "nama_jabatan_ds" => "Lektor Kepala",
                "grade" => "11f",
                "harga_point_ds" => 1336652,
                "gaji_blu" => 467828,
            ],
            [
                "nama_jabatan_ds" => "Lektor (Serdos)",
                "grade" => "10b",
                "harga_point_ds" => 1082595,
                "gaji_blu" => 393908,
            ],
            [
                "nama_jabatan_ds" => "Lektor (non serdos)",
                "grade" => "10c",
                "harga_point_ds" => 1462569,
                "gaji_blu" => 511899,
            ],
            [
                "nama_jabatan_ds" => "Asisten Ahli (serdos)",
                "grade" => "9c",
                "harga_point_ds" => 1052595,
                "gaji_blu" => 368408,
            ],
            [
                "nama_jabatan_ds" => "Asisten Ahli (non serdos)",
                "grade" => "9e",
                "harga_point_ds" => 1393400,
                "gaji_blu" => 487690,
            ],
        ];

        foreach ($data as $jabatanData) {
            $slug = Str::slug($jabatanData['nama_jabatan_ds']);
            $jabatanData['slug'] = $slug;
            JabatanDs::create($jabatanData);
        }
    }
}
