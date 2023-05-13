<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PeriodeController extends Controller
{
    public function index(){
        $periodes = Periode::orderBy('created_at','desc')->get();
        return view('backend/periode_penilaians.index',[
            'periodes'    =>  $periodes,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'nama_periode'              =>  'required',
            'periode_siakad_id'         =>  'required',
            'semester'                  =>  'required|numeric',
            'tahun_ajaran'              =>  'required|numeric',
            'bulan_pembayaran'          =>  'required',
            'bulan'                     =>  'required',

        ];
        $text = [
            'nama_periode.required'             => 'Nama Periode Penilaian harus diisi',
            'periode_siakad_id.required'        => 'Periode Siakad harus diisi',
            'semester.numeric'                  => 'Semester harus berupa angka',
            'semester.required'                 => 'Semester harus diisi',
            'tahun_ajaran.required'             => 'Tahun Ajaran harus diisi',
            'tahun_ajaran.numeric '             => 'Tahun ajaran harus berupa angka',
            'bulan_pembayaran.required'         => 'Bulan Pembayaran harus dipilih',
            'bulan.required'                    => 'Bulan harus diisi',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = Periode::create([
            'nama_periode'          =>  $request->nama_periode,
            'slug'                  =>  Str::slug($request->nama_periode),
            'periode_siakad_id'     =>  $request->periode_siakad_id,
            'semester'              =>  $request->semester,
            'tahun_ajaran'          =>  $request->tahun_ajaran,
            'bulan'                 =>  $request->bulan,
            'bulan_pembayaran'      =>  $request->bulan_pembayaran,
            'is_active'             =>  0,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, periode remunerasi berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_periode/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, periode remunerasi gagal ditambahkan']);
        }
    }

    public function edit(Periode $periode){
        return $periode;
    }

    public function update(Request $request){
        $rules = [
            'nama_periode_edit'              =>  'required',
            'periode_siakad_id_edit'         =>  'required',
            'semester_edit'                  =>  'required|numeric',
            'tahun_ajaran_edit'              =>  'required|numeric',
            'bulan_pembayaran_edit'          =>  'required',
        ];
        $text = [
            'nama_periode_edit.required'             => 'Nama Periode Penilaian harus diisi',
            'periode_siakad_id_edit.required'        => 'Periode Siakad harus diisi',
            'semester_edit.numeric'                  => 'Semester harus berupa angka',
            'semester.required'                 => 'Semester harus diisi',
            'tahun_ajaran_edit.required'             => 'Tahun Ajaran harus diisi',
            'tahun_ajaran_edit.numeric '             => 'Tahun ajaran harus berupa angka',
            'bulan_pembayaran_edit.required'         => 'Bulan Pembayaran harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = Periode::where('id',$request->periode_id_edit)->update([
            'nama_periode'          =>  $request->nama_periode_edit,
            'slug'                  =>  Str::slug($request->nama_periode_edit),
            'periode_siakad_id'     =>  $request->periode_siakad_id_edit,
            'semester'              =>  $request->semester_edit,
            'tahun_ajaran'          =>  $request->tahun_ajaran_edit,
            'bulan_pembayaran'      =>  $request->bulan_pembayaran_edit,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay,periode remunerasi berhasil diubah',
                'url'   =>  url('/manajemen_data_periode/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, periode remunerasi gagal diubah']);
        }
    }

    public function setNonActive(Periode $periode){
        $update = $periode->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, periode remunerasi berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('periode_penilaian')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, periode remunerasi gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(Periode $periode){
        Periode::where('id','!=',$periode->id)->update([
            'is_active' =>  0,
        ]);
        $update = $periode->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, periode remunerasi berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('periode_penilaian')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, periode remunerasi gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function delete(Periode $periode){
        $delete = $periode->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, periode remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('periode_penilaian')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, periode remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
