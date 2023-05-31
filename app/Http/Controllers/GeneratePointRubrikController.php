<?php

namespace App\Http\Controllers;

use App\Models\NilaiEwmp;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\RekapPerRubrik;
use App\Models\RiwayatPoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneratePointRubrikController extends Controller
{
    public function index(){
        return view('backend/generate_point_rubrik.index');
    }

    public function generate(){
        $rubriks = NilaiEwmp::select('nama_tabel_rubrik')->get();
        $periode = Periode::select('id','nama_periode')->where('is_active','1')->first();
        $dosens = Pegawai::select('nip')->get();
        $totalPoint = array();
        $riwayatPoint = array();
        for ($i=0; $i <count($rubriks) ; $i++) { 
            $total_point = DB::table($rubriks[$i]['nama_tabel_rubrik'])->select(DB::raw('IFNULL(sum(point),0) as total_point'))
                            ->where('periode_id',$periode->id)
                            ->where('is_bkd',0)
                            ->where('is_verified',1)
                            ->first();
            $totalPoint[] = array(
                'periode_id'    =>  $periode->id,
                'nama_rubrik'   =>  $rubriks[$i]['nama_tabel_rubrik'],
                'total_point'   =>  $total_point->total_point,
                'created_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                'updated_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
            );
            for ($j=0; $j <count($dosens) ; $j++) { 
                $total_point_per_nip = DB::table($rubriks[$i]['nama_tabel_rubrik'])
                            ->select(DB::raw('IFNULL(sum(point),0) as total_point'))
                            ->where('periode_id',$periode->id)
                            ->where('is_bkd',0)
                            ->where('is_verified',1)
                            ->where('nip',$dosens[$j]['nip'])
                            ->first();
                $riwayatPoint[] = array(
                    'nama_rubrik'   =>  $rubriks[$i]['nama_tabel_rubrik'],
                    'periode_id'    =>  $periode->id,
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
}
