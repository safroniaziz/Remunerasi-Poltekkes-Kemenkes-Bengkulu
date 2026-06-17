<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapLaporanNominatifExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting, WithEvents, WithTitle
{
    protected $data;

    public function __construct($nominatifs)
    {
        $this->data = $nominatifs;
    }

    public function collection()
    {
        $rows = [];
        foreach ($this->data as $index => $nominatif) {
            $dosen = $nominatif->dosen;
            $jabatan = $this->resolveJabatan($dosen);
            $golongan = $dosen->nama_pangkat_golongan_aktif ?: '-';
            $pajakPersen = $this->resolvePajakPersen($golongan);
            $totalPoint = (float) $nominatif->total_point;
            $totalRemun = $jabatan['gaji_blu'] + ($totalPoint * $jabatan['harga_point']);
            $potonganPajak = ($pajakPersen / 100) * $totalRemun;
            $remunDiterima = $totalRemun - $potonganPajak;

            $rows[] = [
                $index + 1,
                $dosen->nip,
                $dosen->nama,
                $jabatan['jabatan_fungsional'],
                $jabatan['jabatan_dt'],
                $jabatan['grade'],
                $jabatan['gaji_blu'],
                $jabatan['harga_point'],
                $totalPoint,
                $golongan,
                $pajakPersen,
                $totalRemun,
                $potonganPajak,
                $remunDiterima,
            ];
        }

        return new Collection($rows);
    }

    public function headings(): array
    {
        return [
            'No',
            'NIP',
            'Nama Dosen',
            'Jabatan Fungsional',
            'Jabatan DT',
            'Grade Jabatan',
            'Gaji BLU',
            'Harga Point',
            'Total Point',
            'Golongan',
            'Pajak (%)',
            'Total Remun',
            'Potongan Pajak',
            'Remun Diterima',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => '"Rp" #,##0',
            'H' => '"Rp" #,##0',
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => '0"%"',
            'L' => '"Rp" #,##0',
            'M' => '"Rp" #,##0',
            'N' => '"Rp" #,##0',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->freezePane('A2');
                $event->sheet->setAutoFilter('A1:N1');
            },
        ];
    }

    public function title(): string
    {
        return 'Laporan Keuangan';
    }

    private function resolveJabatan($dosen): array
    {
        $jabatanFungsional = $dosen->nama_jabatan_fungsional_aktif;
        $jabatanDt = $dosen->nama_jabatan_dt_aktif;

        $data = [
            'jabatan_fungsional' => $jabatanFungsional ?: '-',
            'jabatan_dt' => $jabatanDt ?: '-',
            'grade' => '-',
            'gaji_blu' => 0,
            'harga_point' => 0,
        ];

        if ($jabatanFungsional && $jabatanDt) {
            $gradeFungsional = $dosen->grade_jabatan_fungsional_aktif;
            $gradeDt = $dosen->grade_jabatan_dt_aktif;

            if ($gradeFungsional >= $gradeDt) {
                $data['grade'] = $gradeFungsional;
                $data['gaji_blu'] = (float) $dosen->gaji_blu_jabatan_fungsional_aktif;
                $data['harga_point'] = (float) $dosen->harga_point_jabatan_fungsional_aktif;
            } else {
                $data['grade'] = $gradeDt;
                $data['gaji_blu'] = (float) $dosen->gaji_blu_jabatan_dt_aktif;
                $data['harga_point'] = (float) $dosen->harga_point_jabatan_dt_aktif;
            }
        } elseif (! $jabatanFungsional && $jabatanDt) {
            $data['grade'] = $dosen->grade_jabatan_dt_aktif;
            $data['gaji_blu'] = (float) $dosen->gaji_blu_jabatan_dt_aktif;
            $data['harga_point'] = (float) $dosen->harga_point_jabatan_dt_aktif;
        } elseif ($jabatanFungsional && ! $jabatanDt) {
            $data['grade'] = $dosen->grade_jabatan_fungsional_aktif;
            $data['gaji_blu'] = (float) $dosen->gaji_blu_jabatan_fungsional_aktif;
            $data['harga_point'] = (float) $dosen->harga_point_jabatan_fungsional_aktif;
        }

        return $data;
    }

    private function resolvePajakPersen($golongan): int
    {
        if (in_array($golongan, ['IIIA', 'IIIB', 'IIIC', 'IIID'])) {
            return 5;
        }

        if (in_array($golongan, ['IVA', 'IVB', 'IVC', 'IVD'])) {
            return 15;
        }

        return 100;
    }
}
