<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RiwayatPoint;
use App\Models\Periode;
use App\Models\Rubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RiwayatPointController extends Controller
{
    public function index(Request $request){
        $nip = $request->query('nip');
        if (!empty($nip)) {
            $riwayatpoints = RiwayatPoint::where('nip','LIKE','%'.$nip.'%')
                                ->paginate(10);

        }else {
            $riwayatpoints = RiwayatPoint::paginate(10);
        }
        return view('backend/riwayat_points.index',[
            'riwayatpoints'         =>  $riwayatpoints,
            'nip'        =>  $nip,
        ]);
    }

    public function create(){
        $dosens = Pegawai::all();
        $periodes = Periode::all();
        return view('backend/riwayat_points.create',compact('dosens','periodes'));
    }

    public function store(Request $request){
        $rules = [
            'rubrik_id'       =>  'required',
            'periode_id'      =>  'required',
            'nip'             =>  'required',
            'point'           =>  'required',
        ];
        $text = [
            'rubrik_id.required'    => 'rubrik harus diisi',
            'periode_id.required'   => 'periode harus dipilih',
            'nip.numeric'           => 'Nip harus berupa angka',
            'point.required'        => 'point harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = RiwayatPoint::create([
            'rubrik_id'  =>  $request->rubrik_id,
            'periode_id' =>  $request->periode_id,
            'nip'        =>  $request->nip,
            'point'      =>  $request->point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Riwayat Point baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_riwayat_point/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Riwayat Point gagal disimpan']);
        }
    }
    public function edit(RiwayatPoint $riwayatpoint){
        $dosens = Pegawai::all();
        $periodes = Periode::all();
        return view('backend.riwayat_points.edit',compact('dosens','periodes'),[
            'pegawai'   =>  $riwayatpoint,
        ]);
    }

    public function update(Request $request, RiwayatPoint $riwayatpoint){
        $rules = [
            'rubrik_id'       =>  'required',
            'periode_id'      =>  'required',
            'nip'             =>  'required',
            'point'           =>  'required',
        ];
        $text = [
            'rubrik_id.required'    => 'rubrik harus diisi',
            'periode_id.required'   => 'periode harus dipilih',
            'nip.numeric'           => 'Nip harus berupa angka',
            'point.required'        => 'point harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = RiwayatPoint::where('id',$request->nip_edit)->update([
            'rubrik_id'  =>  $request->rubrik_id,
            'periode_id' =>  $request->periode_id,
            'nip'        =>  $request->nip,
            'point'      =>  $request->point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Riwayat Point berhasil diubah',
                'url'   =>  url('/manajemen_riwayat_point/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Riwayat Point anda gagal diubah']);
        }
    }
    public function delete(RiwayatPoint $riwayatpoint){
        $delete = $riwayatpoint->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Riwayat Point remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('pegawai')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Riwayat Point remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
