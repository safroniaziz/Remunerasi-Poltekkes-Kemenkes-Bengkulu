<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R030PengelolaKepk;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R30DosenPengelolaKepkController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r030pengelolakepks = R030PengelolaKepk::where('nip',$_SESSION['data']['kode'])
                                               ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_030_pengelola_kepks.index',[
           'pegawais'               =>  $pegawais,
           'periode'                =>  $periode,
           'r030pengelolakepks'     =>  $r030pengelolakepks,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jabatan'     =>  'required',
           'is_bkd'      =>  'required',
       ];
       $text = [
           'jabatan.required'  => 'Jabatan harus diisi',
           'is_bkd.required'   => 'Rubrik BKD harus dipilih',
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
           'nip'               =>  $_SESSION['data']['kode'],
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 30 Pengelola KEPK baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_030_pengelola_kepk/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 30 Pengelola KEPK gagal disimpan']);
       }
   }
   public function edit(R030PengelolaKepk $r030pengelolakepk){
       return $r030pengelolakepk;
   }

   public function update(Request $request, R030PengelolaKepk $r030pengelolakepk){
       $rules = [
           'jabatan'                 =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jabatan.required'        => 'Jabatan harus diisi',
           'is_bkd.required'         => 'Rubrik BKD harus dipilih',
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
           'nip'                        =>  $_SESSION['data']['kode'],
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 30 Pengelola KEPK diubah',
               'url'   =>  url('/dosen/r_030_pengelola_kepk/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 30 Pengelola KEPK gagal diubah']);
       }
   }
   public function delete(R030PengelolaKepk $r030pengelolakepk){
       $delete = $r030pengelolakepk->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 30 Pengelola KEPK remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('dosen.r_030_pengelola_kepk')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 30 Pengelola KEPK remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function verifikasi(R030PengelolaKepk $r030pengelolakepk){
        $r030pengelolakepk->update([
            'is_verified'   =>  1,
        ]);
        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R030PengelolaKepk $r030pengelolakepk){
        $r030pengelolakepk->update([
            'is_verified'   =>  0,
        ]);
        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
