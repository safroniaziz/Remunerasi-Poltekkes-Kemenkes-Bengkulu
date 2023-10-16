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
        $data = [
            [
                "nama_jabatan_dt" => "Direktur",
                "grade" => "15",
                "harga_point_dt" => 4885714,
                "gaji_blu" => 1710000,
            ],
            [
                "nama_jabatan_dt" => "Wakil Direktur",
                "grade" => "14",
                "harga_point_dt" => 3427468,
                "gaji_blu" => 1199614,
            ],
            [
                "nama_jabatan_dt" => "Kepala Jurusan 3 Prodi",
                "grade" => "12a",
                "harga_point_dt" => 2261185,
                "gaji_blu" => 791415,
            ],
            [
                "nama_jabatan_dt" => "Kepala Jurusan 2 Prodi",
                "grade" => "12b",
                "harga_point_dt" => 2108727,
                "gaji_blu" => 738055,
            ],
            [
                "nama_jabatan_dt" => "Kepala Jurusan 1 Prodi",
                "grade" => "12c",
                "harga_point_dt" => 2006270,
                "gaji_blu" => 702194,
            ],
            [
                "nama_jabatan_dt" => "Kepala SPI",
                "grade" => "12d",
                "harga_point_dt" => 1794599,
                "gaji_blu" => 628110,
            ],
            [
                "nama_jabatan_dt" => "Kepala Pusat",
                "grade" => "12e",
                "harga_point_dt" => 1727099,
                "gaji_blu" => 628110,
            ],
            [
                "nama_jabatan_dt" => "Sekjur",
                "grade" => "11c",
                "harga_point_dt" => 1773614,
                "gaji_blu" => 620765,
            ],
            [
                "nama_jabatan_dt" => "Kepala Prodi Kampus B",
                "grade" => "11d",
                "harga_point_dt" => 1731776,
                "gaji_blu" => 606122,
            ],
            [
                "nama_jabatan_dt" => "Kepala Prodi/Kepala Unit",
                "grade" => "11e",
                "harga_point_dt" => 1694067,
                "gaji_blu" => 592923,
            ],
            [
                "nama_jabatan_dt" => "Lektor/AA/PJ Teknis/Sub Ur",
                "grade" => "10a",
                "harga_point_dt" => 1180095,
                "gaji_blu" => 413033,
            ],
            [
                "nama_jabatan_dt" => "Asisten Ahli (non serdos)/PJ Teknis/Sub Ur",
                "grade" => "9d",
                "harga_point_dt" => 1536355,
                "gaji_blu" => 537724,
            ],
            [
                "nama_jabatan_dt" => "Dosen (JFU)& adm",
                "grade" => "7a",
                "harga_point_dt" => 1430721,
                "gaji_blu" => 500752,
            ],
            [
                "nama_jabatan_dt" => "Administrasi JFU/Pelaksana >=S1",
                "grade" => "7a",
                "harga_point_dt" => 1430721,
                "gaji_blu" => 500752,
            ],
            [
                "nama_jabatan_dt" => "Dosen (JFU)",
                "grade" => "7b",
                "harga_point_dt" => 1378751,
                "gaji_blu" => 482563,
            ],
        ];

        foreach ($data as $jabatanData) {
            $slug = Str::slug($jabatanData['nama_jabatan_dt']);
            $jabatanData['slug'] = $slug;
            JabatanDt::create($jabatanData);
        }
    }
}
