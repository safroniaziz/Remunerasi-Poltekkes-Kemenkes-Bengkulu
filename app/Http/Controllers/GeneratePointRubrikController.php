<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Str;
use App\Models\RiwayatPoint;
use Illuminate\Http\Request;
use App\Models\RekapPerRubrik;
use Illuminate\Support\Facades\DB;

class GeneratePointRubrikController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::select('id','nama_periode')->where('is_active','1')->first();
    }

    public function index(){
        $dataRubriks = RekapPerRubrik::with(['periode'])->where('periode_id',$this->periode->id)->get();
        return view('backend/generate_point_rubrik.index',[
            'dataRubriks'   =>  $dataRubriks,
            'periode'       =>  $this->periode,
        ]);
    }

    public function generate(){
        $rubriks = NilaiEwmp::select('nama_rubrik','nama_tabel_rubrik')->get();
        $dosens = Pegawai::select('nip')->get();
        $totalPoint = array();
        $riwayatPoint = array();
        for ($i=0; $i <count($rubriks) ; $i++) { 
            $total_point = DB::table($rubriks[$i]['nama_tabel_rubrik'])->select(DB::raw('IFNULL(sum(point),0) as total_point'))
                            ->where('periode_id',$this->periode->id)
                            ->where('is_bkd',0)
                            ->where('is_verified',1)
                            ->first();
            $totalPoint[] = array(
                'periode_id'    =>  $this->periode->id,
                'kode_rubrik'   =>  $rubriks[$i]['nama_tabel_rubrik'],
                'nama_rubrik'   =>  $rubriks[$i]['nama_rubrik'],
                'total_point'   =>  $total_point->total_point,
                'created_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                'updated_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
            );
            for ($j=0; $j <count($dosens) ; $j++) { 
                $total_point_per_nip = DB::table($rubriks[$i]['nama_tabel_rubrik'])
                            ->select(DB::raw('IFNULL(sum(point),0) as total_point'))
                            ->where('periode_id',$this->periode->id)
                            ->where('is_bkd',0)
                            ->where('is_verified',1)
                            ->where('nip',$dosens[$j]['nip'])
                            ->first();
                $riwayatPoint[] = array(
                    'nama_rubrik'   =>  $rubriks[$i]['nama_tabel_rubrik'],
                    'periode_id'    =>  $this->periode->id,
                    'point'         =>  $total_point_per_nip->total_point,
                    'nip'           =>  $dosens[$j]['nip'],
                    'created_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                    'updated_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                );
            }
        }
        RekapPerRubrik::insert($totalPoint);
        RiwayatPoint::insert($riwayatPoint);

        $success = array(
            'message' => 'Berhasil, Generate Point Rubrik Berhasil Dilakukan',
            'alert-type' => 'success'
        );
        return redirect()->route('generate_point_rubrik')->with($success);
    }

    public function rekapPointPerRubrik(RekapPerRubrik $rekapPerRubrik){
        $total_point = DB::table($rekapPerRubrik->kode_rubrik)->select(DB::raw('IFNULL(sum(point),0) as total_point'))
                            ->where('periode_id',$this->periode->id)
                            ->where('is_bkd',0)
                            ->where('is_verified',1)
                            ->first();
        $rekapPerRubrik->update([
            'total_point'   =>  $total_point->total_point,
        ]);

        $success = array(
            'message' => 'Berhasil, Perbarui Point Per Rubrik Berhasil Dilakukan',
            'alert-type' => 'success'
        );
        return redirect()->route('generate_point_rubrik')->with($success);
    }

    public function detailIsianRubrik(RekapPerRubrik $rekapPerRubrik){
        $className = 'App\\Models\\' . Str::studly(Str::singular($rekapPerRubrik->kode_rubrik));
        $detailIsianRubriks = $className::with(['pegawai'])
                                ->where('periode_id',$this->periode->id)
                                ->where('is_bkd',0)
                                ->where('is_verified',1)
                                ->get();
        return view('backend/generate_point_rubrik.detail_isian_rubrik',[
            'detailIsianRubriks'   =>  $detailIsianRubriks,
            'rekapPerRubrik'   =>  $rekapPerRubrik,
        ]);
    }
}
