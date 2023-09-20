<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use App\Models\RekapPerDosen;
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
        $this->periode = Periode::select('id','nama_periode')->where('is_active',1)->first();
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
            $total_point = DB::table($rubriks[$i]['nama_tabel_rubrik'])->select(DB::raw('IFNULL(sum(point),0) as total_point'),DB::raw('count(id) as jumlah_data_terhitung'))
                            ->where('periode_id',$this->periode->id)
                            ->where('is_bkd',0)
                            ->where('is_verified',1)
                            ->first();
            $tidak_terhitung = DB::table($rubriks[$i]['nama_tabel_rubrik'])
                            ->select(
                                DB::raw('IFNULL(SUM(point), 0) as jumlah_point'),
                                DB::raw('COUNT(id) as jumlah_data')
                            )
                            ->where('periode_id', $this->periode->id)
                            ->where(function ($query) {
                                $query->where('is_bkd', 1)
                                    ->orWhere('is_verified', 0);
                            })
                            ->first();
            $jumlah_data_seluruh = DB::table($rubriks[$i]['nama_tabel_rubrik'])
                                        ->where('periode_id',$this->periode->id)
                                        ->select(DB::raw('IFNULL(sum(point),0) as jumlah_point'),
                                        DB::raw('count(id) as jumlah_data'))->first();
            $totalPoint[] = array(
                'periode_id'    =>  $this->periode->id,
                'kode_rubrik'   =>  $rubriks[$i]['nama_tabel_rubrik'],
                'nama_rubrik'   =>  $rubriks[$i]['nama_rubrik'],
                'nama_rubrik'   =>  $rubriks[$i]['nama_rubrik'],
                'jumlah_data_seluruh'   =>  $jumlah_data_seluruh->jumlah_data,
                'jumlah_point_seluruh'   =>  $jumlah_data_seluruh->jumlah_point,
                'jumlah_data_terhitung'   =>  $total_point->jumlah_data_terhitung,
                'jumlah_data_tidak_terhitung'   =>  $tidak_terhitung->jumlah_data,
                'jumlah_point_tidak_terhitung'   =>  $tidak_terhitung->jumlah_point,
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
                    'kode_rubrik'   =>  $rubriks[$i]['nama_tabel_rubrik'],
                    'nama_rubrik'   =>  $rubriks[$i]['nama_rubrik'],
                    'periode_id'    =>  $this->periode->id,
                    'point'         =>  $total_point_per_nip->total_point,
                    'nip'           =>  $dosens[$j]['nip'],
                    'created_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                    'updated_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                );
            }
        }
        RekapPerRubrik::insert($totalPoint);
        $riwayat_point = RiwayatPoint::insert($riwayatPoint);
        $rekapPerDosen = array();
        for ($k=0; $k <count($dosens) ; $k++) { 
            $total_point = RiwayatPoint::select(DB::raw('sum(point) as total_point'))
                                        ->where('nip',$dosens[$k]['nip'])
                                        ->where('periode_id',$this->periode->id)
                                        ->first();
            $rekapPerDosen[] = array(
                'nip'           =>  $dosens[$k]['nip'],
                'periode_id'    =>  $this->periode->id,
                'total_point'   =>  $total_point->total_point,
                'created_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                'updated_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
            );
        }
        RekapPerDosen::insert($rekapPerDosen);
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

        RiwayatPoint::where('periode_id',$this->periode->id)->where('kode_rubrik',$rekapPerRubrik->kode_rubrik)->delete();

        $dosens = Pegawai::select('nip')->get();
        for ($i=0; $i <count($dosens) ; $i++) { 
            $total_point_per_nip = DB::table($rekapPerRubrik->kode_rubrik)
                        ->select(DB::raw('IFNULL(sum(point),0) as total_point'))
                        ->where('periode_id',$this->periode->id)
                        ->where('is_bkd',0)
                        ->where('is_verified',1)
                        ->where('nip',$dosens[$i]['nip'])
                        ->first();
            
            $riwayatPoint[] = array(
                'kode_rubrik'   =>  $rekapPerRubrik->kode_rubrik,
                'nama_rubrik'   =>  $rekapPerRubrik->nama_rubrik,
                'periode_id'    =>  $this->periode->id,
                'point'         =>  $total_point_per_nip->total_point,
                'nip'           =>  $dosens[$i]['nip'],
                'created_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
                'updated_at'    =>  Carbon::now()->format("Y-m-d H:i:s"),
            );
        }
        $riwayat_point = RiwayatPoint::insert($riwayatPoint);

        for ($k=0; $k <count($dosens) ; $k++) { 
            $total_point_baru = RiwayatPoint::select(DB::raw('sum(point) as total_point'))->where('nip',$dosens[$k]['nip'])->first();
            RekapPerDosen::where('nip',$dosens[$k]['nip'])->where('periode_id',$this->periode->id)->update([
                'total_point'   =>  $total_point_baru->total_point,
            ]);
        }

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

    public function generatePointMassal(Request $request){
        if (!empty($request->kode_rubriks)) {
            for ($i=0; $i < count($request->kode_rubriks); $i++) {
                $className = 'App\\Models\\' . Str::studly(Str::singular($request->kode_rubriks[$i]));
                $total_point = $className::select(DB::raw('IFNULL(sum(point),0) as total_point'))
                            ->where('periode_id',$this->periode->id)
                            ->where('is_bkd',0)
                            ->where('is_verified',1)
                            ->first();
                RekapPerRubrik::where('kode_rubrik',$request->kode_rubriks[$i])->update([
                    'total_point'   =>  $total_point->total_point,
                ]);
            }

            $notification = array(
                'message' => 'Berhasil, proses pembaruan data point rubrik berhasil dilakukan',
                'alert-type' => 'success'
            );
            return redirect()->route('generate_point_rubrik')->with($notification);
           
        }
        else{
            $notification = array(
                'message' => 'Ooopps, silahkan pilih beberapa rubrik terlebih dahulu',
                'alert-type' => 'error'
            );
            return redirect()->route('generate_point_rubrik')->with($notification);
        }
    }
}
