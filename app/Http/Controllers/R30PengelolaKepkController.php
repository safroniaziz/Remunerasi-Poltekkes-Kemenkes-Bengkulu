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
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r030-pengelola-kepk')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r030pengelolakepks = R030PengelolaKepk::where('nip',$request->session()->get('nip_dosen'))
                                                ->where('periode_id',$this->periode->id)
                                                ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_030_pengelola_kepks.index',[
           'pegawais'               =>  $pegawais,
           'periode'                =>  $this->periode,
           'r030pengelolakepks'     =>  $r030pengelolakepks,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r030-pengelola-kepk')) {
        abort(403);
    }
       $rules = [
           'jabatan'     =>  'required',
           'is_bkd'      =>  'required',
       ];
       $text = [
           'jabatan.required'  => 'Jabatan harus diisi',
           'is_bkd.required'   => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "ketua") {
            $ewmp = 1.50;
        }elseif ($request->jabatan == "wakil" || $request->jabatan == "sekretaris") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.75;
        }
        $point = $ewmp;
       $simpan = R030PengelolaKepk::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  $request->is_bkd,
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
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jabatan.required'        => 'Jabatan harus diisi',
           'is_bkd.required'         => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "ketua") {
            $ewmp = 1.50;
        }elseif ($request->jabatan == "wakil" || $request->jabatan == "sekretaris") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $update = R030PengelolaKepk::where('id',$request->r030pengelolakepk_id_edit)->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
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
