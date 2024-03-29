<?php

namespace App\Http\Controllers\Dosen;


use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RekapPerDosen;
use PDF;

class LaporanDosenController extends Controller
{
    public function cetakLaporan(){
        $periode = Periode::where('is_active',1)->first();
        $nama_periode = str_replace(' ', '_', $periode->nama_periode);
        $riwayatPoints = Pegawai::where('nip', $_SESSION['data']['kode'])
                        ->with(['riwayatPointAlls' => function ($query) use ($periode) {
                            $query->where('periode_id', $periode->id);
                        }])
                        ->first();
        $pegawai = Pegawai::with(['prodi'])->where('nip',$_SESSION['data']['kode'])->first();
        $judul = $periode->nama_periode;
        $data = [
            'riwayatPoints' => $riwayatPoints,
            'judul' => $judul,
            'periode' => $periode,
            'pegawai' => $pegawai,
            'nip'       =>  $_SESSION['data']['kode'],
        ];
        $pdf = PDF::loadView('backend/dosen/laporan.cetak', $data); // Ganti 'nama_view' dengan nama view Anda
        return $pdf->stream('laporan_remun_periode_'.$nama_periode.'.pdf');
    }

    public function riwayatKinerja(){
        $periodes = Periode::orderBy('created_at','desc')->get();
        $riwayatKinerjas = RekapPerDosen::with(['periode','dosen'])->where('nip',$_SESSION['data']['kode'])->orderBy('periode_id','desc')->get();
        return view('backend/dosen/laporan.riwayat_kinerja',[
            'periodes'   =>  $periodes,
            'riwayatKinerjas'   =>  $riwayatKinerjas,
        ]);
    }

    public function riwayatKinerjaCetak(Request $request){
        $periode = Periode::where('id',$request->periode_id)->first();
        $nama_periode = str_replace(' ', '_', $periode->nama_periode);
        $riwayatPoints = Pegawai::where('nip', $_SESSION['data']['kode'])
                        ->with(['riwayatPointAlls' => function ($query) use ($periode) {
                            $query->where('periode_id', $periode->id);
                        }])
                        ->first();
        if ($riwayatPoints && $riwayatPoints->riwayatPointAlls->count() > 0) {
            $judul = $periode->nama_periode;
            $data = [
                'riwayatPoints' => $riwayatPoints,
                'judul' => $judul,
                'periode' => $periode,
                'nip'       =>  $_SESSION['data']['kode'],
            ];
            $pdf = PDF::loadView('backend/dosen/laporan.cetak', $data); // Ganti 'nama_view' dengan nama view Anda
            return $pdf->stream('laporan_remun_periode_'.$nama_periode.'.pdf');
        }
    }
}
