<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class LaporanDosenController extends Controller
{
    public function cetakLaporan(){
        $riwayatPoints = Pegawai::where('id',$_SESSION['data']['kode'])->with(['riwayatPoints'])->first();
        return $riwayatPoints;
    }
}
