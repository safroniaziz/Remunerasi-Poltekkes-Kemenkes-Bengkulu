<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointRubrikDosenController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

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
        $riwayatPoints = Pegawai::with('riwayatPoints')->where('nip',$dosen->nip)->first();
        return $riwayatPoints;
        return view('backend.point_rubrik_dosen.detail', compact('riwayatPoints','dosen'));
    }
}
