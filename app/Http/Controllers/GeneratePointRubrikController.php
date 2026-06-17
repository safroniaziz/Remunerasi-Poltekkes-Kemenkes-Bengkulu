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
        $periodeId = $this->periode->id;
        $dataRubriks = RekapPerRubrik::with(['periode'])
            ->where('periode_id',$periodeId)
            ->get()
            ->map(function ($rubrik) use ($periodeId) {
                $rubrik->setAttribute('status_total_point', DB::table($rubrik->kode_rubrik)
                    ->where('periode_id',$periodeId)
                    ->where('is_bkd',0)
                    ->where('is_verified',1)
                    ->sum('point'));

                return $rubrik;
            });
        activity()
        ->causedBy(auth()->user()->id)
        ->event('accessed')
        ->log(auth()->user()->nama_user . ' has accessed the Generate Point Rubrik value page.');
        return view('backend/generate_point_rubrik.index',[
            'dataRubriks'   =>  $dataRubriks,
            'periode'       =>  $this->periode,
        ]);
    }

    public function generate(){
        activity()
        ->causedBy(auth()->user()->id)
        ->event('accessed')
        ->log(auth()->user()->nama_user . ' has Click the Generate Point Rubrik value page.');

        try {
            DB::beginTransaction();
            $rubriks = NilaiEwmp::select('nama_rubrik','nama_tabel_rubrik')->get();
            $dosens = Pegawai::select('nip')->get();
            $now = Carbon::now()->format("Y-m-d H:i:s");

            $totalPoint = array();
            $riwayatPoint = array();
            for ($i=0; $i <count($rubriks) ; $i++) {
                $kodeRubrik = $rubriks[$i]['nama_tabel_rubrik'];
                $namaRubrik = $rubriks[$i]['nama_rubrik'];

                $summary = DB::table($kodeRubrik)
                                ->where('periode_id',$this->periode->id)
                                ->selectRaw('IFNULL(SUM(point), 0) as jumlah_point_seluruh')
                                ->selectRaw('COUNT(id) as jumlah_data_seluruh')
                                ->selectRaw('IFNULL(SUM(CASE WHEN is_bkd = 0 AND is_verified = 1 THEN point ELSE 0 END), 0) as total_point')
                                ->selectRaw('COUNT(CASE WHEN is_bkd = 0 AND is_verified = 1 THEN id END) as jumlah_data_terhitung')
                                ->selectRaw('IFNULL(SUM(CASE WHEN is_bkd = 1 OR is_verified = 0 THEN point ELSE 0 END), 0) as jumlah_point_tidak_terhitung')
                                ->selectRaw('COUNT(CASE WHEN is_bkd = 1 OR is_verified = 0 THEN id END) as jumlah_data_tidak_terhitung')
                                ->first();
                $pointsByNip = DB::table($kodeRubrik)
                                ->select('nip', DB::raw('IFNULL(sum(point),0) as total_point'))
                                ->where('periode_id',$this->periode->id)
                                ->where('is_bkd',0)
                                ->where('is_verified',1)
                                ->groupBy('nip')
                                ->pluck('total_point', 'nip');

                $totalPoint[] = array(
                    'periode_id'    =>  $this->periode->id,
                    'kode_rubrik'   =>  $kodeRubrik,
                    'nama_rubrik'   =>  $namaRubrik,
                    'jumlah_data_seluruh'   =>  $summary->jumlah_data_seluruh,
                    'jumlah_point_seluruh'   =>  $summary->jumlah_point_seluruh,
                    'jumlah_data_terhitung'   =>  $summary->jumlah_data_terhitung,
                    'jumlah_data_tidak_terhitung'   =>  $summary->jumlah_data_tidak_terhitung,
                    'jumlah_point_tidak_terhitung'   =>  $summary->jumlah_point_tidak_terhitung,
                    'total_point'   =>  $summary->total_point,
                    'created_at'    =>  $now,
                    'updated_at'    =>  $now,
                );
                for ($j=0; $j <count($dosens) ; $j++) {
                    $nip = $dosens[$j]['nip'];

                    $riwayatPoint[] = array(
                        'kode_rubrik'   =>  $kodeRubrik,
                        'nama_rubrik'   =>  $namaRubrik,
                        'periode_id'    =>  $this->periode->id,
                        'point'         =>  $pointsByNip[$nip] ?? 0,
                        'nip'           =>  $nip,
                        'created_at'    =>  $now,
                        'updated_at'    =>  $now,
                    );
                }
            }
            RekapPerRubrik::insert($totalPoint);
            RiwayatPoint::insert($riwayatPoint);
            $totalsByNip = RiwayatPoint::select('nip', DB::raw('sum(point) as total_point'))
                                        ->where('periode_id',$this->periode->id)
                                        ->groupBy('nip')
                                        ->pluck('total_point', 'nip');
            $rekapPerDosen = array();
            for ($k=0; $k <count($dosens) ; $k++) {
                $nip = $dosens[$k]['nip'];
                $rekapPerDosen[] = array(
                    'nip'           =>  $nip,
                    'periode_id'    =>  $this->periode->id,
                    'total_point'   =>  $totalsByNip[$nip] ?? 0,
                    'created_at'    =>  $now,
                    'updated_at'    =>  $now,
                );
            }
            RekapPerDosen::insert($rekapPerDosen);

            DB::commit();
            $success = array(
                'message' => 'Berhasil, Generate Point Rubrik Berhasil Dilakukan',
                'alert-type' => 'success'
            );
            return redirect()->route('generate_point_rubrik')->with($success);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika ada kesalahan
            return redirect()->route('generate_point_rubrik')->withErrors(['message' => 'Gagal, terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function rekapPointPerRubrik(RekapPerRubrik $rekapPerRubrik){
        $summary = DB::table($rekapPerRubrik->kode_rubrik)
                        ->where('periode_id',$this->periode->id)
                        ->selectRaw('IFNULL(SUM(point), 0) as jumlah_point_seluruh')
                        ->selectRaw('COUNT(id) as jumlah_data_seluruh')
                        ->selectRaw('IFNULL(SUM(CASE WHEN is_bkd = 0 AND is_verified = 1 THEN point ELSE 0 END), 0) as total_point')
                        ->selectRaw('COUNT(CASE WHEN is_bkd = 0 AND is_verified = 1 THEN id END) as jumlah_data_terhitung')
                        ->selectRaw('IFNULL(SUM(CASE WHEN is_bkd = 1 OR is_verified = 0 THEN point ELSE 0 END), 0) as jumlah_point_tidak_terhitung')
                        ->selectRaw('COUNT(CASE WHEN is_bkd = 1 OR is_verified = 0 THEN id END) as jumlah_data_tidak_terhitung')
                        ->first();
        $rekapPerRubrik->update([
            'total_point'   =>  $summary->total_point,
            'jumlah_data_seluruh'   =>  $summary->jumlah_data_seluruh,
            'jumlah_point_seluruh'   =>  $summary->jumlah_point_seluruh,
            'jumlah_data_terhitung'   =>  $summary->jumlah_data_terhitung,
            'jumlah_data_tidak_terhitung'   =>  $summary->jumlah_data_tidak_terhitung,
            'jumlah_point_tidak_terhitung'   =>  $summary->jumlah_point_tidak_terhitung,
        ]);

        RiwayatPoint::where('periode_id',$this->periode->id)->where('kode_rubrik',$rekapPerRubrik->kode_rubrik)->delete();

        $dosens = Pegawai::select('nip')->get();
        $now = Carbon::now()->format("Y-m-d H:i:s");
        $riwayatPoint = array();
        $pointsByNip = DB::table($rekapPerRubrik->kode_rubrik)
                    ->select('nip', DB::raw('IFNULL(sum(point),0) as total_point'))
                    ->where('periode_id',$this->periode->id)
                    ->where('is_bkd',0)
                    ->where('is_verified',1)
                    ->groupBy('nip')
                    ->pluck('total_point', 'nip');

        for ($i=0; $i <count($dosens) ; $i++) {
            $nip = $dosens[$i]['nip'];

            $riwayatPoint[] = array(
                'kode_rubrik'   =>  $rekapPerRubrik->kode_rubrik,
                'nama_rubrik'   =>  $rekapPerRubrik->nama_rubrik,
                'periode_id'    =>  $this->periode->id,
                'point'         =>  $pointsByNip[$nip] ?? 0,
                'nip'           =>  $nip,
                'created_at'    =>  $now,
                'updated_at'    =>  $now,
            );
        }
        RiwayatPoint::insert($riwayatPoint);

        $totalsByNip = RiwayatPoint::select('nip', DB::raw('sum(point) as total_point'))
                    ->groupBy('nip')
                    ->pluck('total_point', 'nip');

        for ($k=0; $k <count($dosens) ; $k++) {
            $nip = $dosens[$k]['nip'];
            RekapPerDosen::where('nip',$nip)->where('periode_id',$this->periode->id)->update([
                'total_point'   =>  $totalsByNip[$nip] ?? 0,
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
        if ($className === 'App\\Models\\R017NaskahBukuBahasaTerbitEdarNa') {
            $className = str_replace('R017NaskahBukuBahasaTerbitEdarNa', 'R017NaskahBukuBahasaTerbitEdarNas', $className);
        }elseif ($className === 'App\\Models\\R022ReviewerEclerePenelitianMh') {
            $className = str_replace('R022ReviewerEclerePenelitianMh', 'R022ReviewerEclerePenelitianMhs', $className);
        }
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
        activity()
        ->causedBy(auth()->user()->id)
        ->event('accessed')
        ->log(auth()->user()->nama_user . ' has Click the Generate Point value page.');

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
