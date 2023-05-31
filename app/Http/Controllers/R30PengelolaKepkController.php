<?php

namespace App\Http\Controllers;

use App\Models\R030PengelolaKepk;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R30PengelolaKepkController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r030-pengelola-kepk')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r030pengelolakepks = R030PengelolaKepk::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_030_pengelola_kepks.index',[
           'pegawais'               =>  $pegawais,
           'periode'                =>  $periode,
           'r030pengelolakepks'     =>  $r030pengelolakepks,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r030-pengelola-kepk')) {
        abort(403);
    }
       $rules = [
           'jabatan'     =>  'required',
       ];
       $text = [
           'jabatan.required'  => 'Jabatan harus diisi',

       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.50;
        }elseif ($request->jabatan == "wakil" || $request->jabatan == "sekretaris") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.75;
        }
        $point = $ewmp;
       $simpan = R030PengelolaKepk::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 30 Pengelola KEPK baru berhasil ditambahkan',
               'url'   =>  url('/r_030_pengelola_kepk/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 30 Pengelola KEPK gagal disimpan']);
       }
   }
   public function edit(R030PengelolaKepk $r030pengelolakepk){
    if (!Gate::allows('edit-r030-pengelola-kepk')) {
        abort(403);
    }
       return $r030pengelolakepk;
   }

   public function update(Request $request, R030PengelolaKepk $r030pengelolakepk){
    if (!Gate::allows('update-r030-pengelola-kepk')) {
        abort(403);
    }
       $rules = [
           'jabatan'                 =>  'required',
       ];
       $text = [
           'jabatan.required'        => 'Jabatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.50;
        }elseif ($request->jabatan == "wakil" || $request->jabatan == "sekretaris") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $update = R030PengelolaKepk::where('id',$request->r030pengelolakepk_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 30 Pengelola KEPK diubah',
               'url'   =>  url('/r_030_pengelola_kepk/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 30 Pengelola KEPK gagal diubah']);
       }
   }
   public function delete(R030PengelolaKepk $r030pengelolakepk){
    if (!Gate::allows('delete-r030-pengelola-kepk')) {
        abort(403);
    }
       $delete = $r030pengelolakepk->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 30 Pengelola KEPK remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_030_pengelola_kepk')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 30 Pengelola KEPK remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R030PengelolaKepk $r030pengelolakepk){
       $update = $r030pengelolakepk->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_030_pengelola_kepk')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R030PengelolaKepk $r030pengelolakepk){
       $update = $r030pengelolakepk->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_030_pengelola_kepk')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
