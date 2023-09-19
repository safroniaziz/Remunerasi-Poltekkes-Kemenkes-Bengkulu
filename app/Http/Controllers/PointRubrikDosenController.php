<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointRubrikDosenController extends Controller
{
    public function index(){
        $dosens = Pegawai::leftJoin('riwayat_points', 'pegawais.nip', '=', 'riwayat_points.nip')
                            ->select('pegawais.*', DB::raw('SUM(riwayat_points.point) as total_point'))
                            ->groupBy('pegawais.nip')
                            ->orderBy('total_point', 'desc')
                            ->get();
        return view('backend/point_rubrik_dosen.index',[
            'dosens'    =>  $dosens,
        ]);
    }

    public function pointDetail(Pegawai $dosen) {
        $periode = Periode::select('nama_periode')->where('is_active', '1')->first();
        $riwayatPoints = $dosen->riwayatPoints()->where('point', '>', 0)->get(); // Mengambil relasi hasMany riwayatPoints
        return view('backend.point_rubrik_dosen.detail', compact('riwayatPoints'));
    }
}
