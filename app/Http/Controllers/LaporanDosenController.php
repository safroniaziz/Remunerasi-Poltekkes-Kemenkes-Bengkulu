<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use PDF;

class LaporanDosenController extends Controller
{
    public function cetakLaporan(){
        $periode = Periode::where('is_active',1)->first();
        $nama_periode = str_replace(' ', '_', $periode->nama_periode);
        $riwayatPoints = Pegawai::where('nip',$_SESSION['data']['kode'])->with(['riwayatPoints'])->first();
        $judul = $periode->nama_periode;
        $data = [
            'riwayatPoints' => $riwayatPoints,
            'judul' => $judul,
        ];
        return $data;
        $pdf = PDF::loadView('backend/dosen/laporan.cetak', $data); // Ganti 'nama_view' dengan nama view Anda
        return $pdf->stream('laporan_remun_periode_'.$nama_periode.'.pdf');
    }
}