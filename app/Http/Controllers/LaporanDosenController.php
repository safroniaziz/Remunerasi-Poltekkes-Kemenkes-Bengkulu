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
        return $riwayatPoints;
        $pdf = PDF::loadView('backend/dosen/laporan.cetak', $riwayatPoints); // Ganti 'nama_view' dengan nama view Anda

        return $pdf->stream('laporan_remun_periode_'.$nama_periode.'.pdf');
    }
}
