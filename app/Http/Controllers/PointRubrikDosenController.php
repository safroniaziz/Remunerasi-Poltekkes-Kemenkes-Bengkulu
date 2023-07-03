<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
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
}
