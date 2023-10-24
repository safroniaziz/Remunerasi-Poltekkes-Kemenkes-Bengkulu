<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class RekapLaporanNominatifExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($nominatifs)
    {
        $this->data = $nominatifs;
    }

    public function collection()
    {
        $data = [];
        foreach ($this->data as $index => $nominatif) {
            $harga_point = 0; // Inisialisasi harga_point
            $gaji_blu = 0; // Inisialisasi harga_point
            $rowData = [
                'No' => $index + 1,
                'Nama Dosen' => $nominatif->dosen->nama,
                'Jabatan Fungsional' => $nominatif->dosen->nama_jabatan_fungsional_aktif ? $nominatif->dosen->nama_jabatan_fungsional_aktif : '-',
                'Jabatan DT' => $nominatif->dosen->nama_jabatan_dt_aktif ? $nominatif->dosen->nama_jabatan_dt_aktif : '-',
                'Grade Jabatan' => '-', // Inisialisasi dengan '-' untuk menghindari kesalahan jika tidak ada kondisi yang terpenuhi
                'Gaji BLU' => '-',
                'Harga Point' => '-',
                'Total Point' => $nominatif->total_point,
                'Golongan' => $nominatif->dosen->nama_pangkat_golongan_aktif,
                'Pajak' => '-', // Inisialisasi dengan '-' untuk menghindari kesalahan jika tidak ada kondisi yang terpenuhi
                'Remun Diterima' => '-', // Inisialisasi dengan '-' untuk menghindari kesalahan jika tidak ada kondisi yang terpenuhi
            ];
    
            if ($nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif) {
                if ($nominatif->dosen->grade_jabatan_fungsional_aktif > $nominatif->dosen->grade_jabatan_dt_aktif) {
                    $rowData['Grade Jabatan'] = $nominatif->dosen->grade_jabatan_fungsional_aktif;
                    $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_fungsional_aktif;
                    $rowData['Gaji BLU'] = $gaji_blu;
                    $harga_point = $nominatif->dosen->harga_point_jabatan_fungsional_aktif;
                    $rowData['Harga Point'] = $harga_point;
                } elseif ($nominatif->dosen->grade_jabatan_fungsional_aktif < $nominatif->dosen->grade_jabatan_dt_aktif) {
                    $rowData['Grade Jabatan'] = $nominatif->dosen->grade_jabatan_dt_aktif;
                    $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_dt_aktif;
                    $rowData['Gaji BLU'] = $gaji_blu;
                    $harga_point = $nominatif->dosen->harga_point_jabatan_dt_aktif;
                    $rowData['Harga Point'] = $harga_point;
                }
            } elseif (!$nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif) {
                $rowData['Grade Jabatan'] = $nominatif->dosen->grade_jabatan_dt_aktif;
                $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_dt_aktif;
                $rowData['Gaji BLU'] = $gaji_blu;
                $harga_point = $nominatif->dosen->harga_point_jabatan_dt_aktif;
                $rowData['Harga Point'] = $harga_point;
            } elseif ($nominatif->dosen->nama_jabatan_fungsional_aktif && !$nominatif->dosen->nama_jabatan_dt_aktif) {
                $rowData['Grade Jabatan'] = $nominatif->dosen->grade_jabatan_fungsional_aktif;
                $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_fungsional_aktif;
                $rowData['Gaji BLU'] = $gaji_blu;
                $harga_point = $nominatif->dosen->harga_point_jabatan_fungsional_aktif;
                $rowData['Harga Point'] = $harga_point;
            }
    
            if ($nominatif->dosen->nama_pangkat_golongan_aktif == "IIIA" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IIIB" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IIIC" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IIID") {
                $totalRemun = ($gaji_blu + ($nominatif->total_point * $harga_point));
                $pajak = $totalRemun * (5/100);
                $rowData['Remun Diterima'] = 'Rp. ' . number_format($totalRemun - $pajak);
            } elseif ($nominatif->dosen->nama_pangkat_golongan_aktif == "IVA" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IVB" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IVC" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IVD") {
                $totalRemun = ($gaji_blu + ($nominatif->total_point * $harga_point));
                $pajak = $totalRemun * (15/100);
                $rowData['Remun Diterima'] = 'Rp. ' . number_format($totalRemun - $pajak);
            } else {
                $rowData['Pajak'] = '100%';
                $rowData['Remun Diterima'] = 'Rp. -';
            }
    
            $data[] = $rowData;
        }
    
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dosen',
            'Jabatan Fungsional',
            'Jabatan DT',
            'Grade Jabatan',
            'Gaji BLU',
            'Harga Point',
            'Total Point',
            'Golongan',
            'Pajak',
            'Remun Diterima',
        ];
    }
}
