<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Support\Str;
use App\Models\RiwayatPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;


class PointRubrikDosenController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pointTotals = RiwayatPoint::select('nip', DB::raw('SUM(point) as total_point'))
                            ->groupBy('nip');

        $dosens = Pegawai::leftJoinSub($pointTotals, 'point_totals', function ($join) {
                                $join->on('pegawais.nip', '=', 'point_totals.nip');
                            })
                            ->select('pegawais.*', DB::raw('COALESCE(point_totals.total_point, 0) as total_point'))
                            ->orderBy('total_point', 'desc')
                            ->get();

        return view('backend/point_rubrik_dosen.index',[
            'dosens'    =>  $dosens,
        ]);
    }

    public function pointDetail(Pegawai $dosen) {
        $riwayatPoints = Pegawai::with('riwayatPoints')->where('nip',$dosen->nip)->first();

        return view('backend.point_rubrik_dosen.detail', compact('riwayatPoints','dosen'));
    }

    public function pointDetailRubrik(Pegawai $dosen, RiwayatPoint $riwayatPoint){
        $className = 'App\\Models\\' . Str::studly(Str::singular($riwayatPoint->kode_rubrik));
        $borangs = $className::where('periode_id',$this->periode->id)
                            ->where('nip',$dosen->nip)
                            ->where('is_verified',1)
                            ->get();

        return view('backend/point_rubrik_dosen.detail_borang',[
            'dosen'    =>  $dosen,
            'borangs'    =>  $borangs,
            'kodeRubrik'    =>  $riwayatPoint->kode_rubrik,
        ]);
    }
}
