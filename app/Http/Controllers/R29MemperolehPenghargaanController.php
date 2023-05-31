<?php

namespace App\Http\Controllers;

use App\Models\R029MemperolehPenghargaan;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R29MemperolehPenghargaanController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r029-memperoleh-penghargaan')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r029memperolehpenghargaans = R029MemperolehPenghargaan::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_029_memperoleh_penghargaans.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
           'r029memperolehpenghargaans'     =>  $r029memperolehpenghargaans,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r029-memperoleh-penghargaan')) {
        abort(403);
    }
       $rules = [
           'judul_penghargaan'       =>  'required',
       ];
       $text = [
           'judul_penghargaan.required' => 'Judul Penghargaan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "dosen_berprestasi_nasional") {
            $ewmp = 0.5;
        }else{
            $ewmp = 0.5;
        }
        $point = $ewmp;
       $simpan = R029MemperolehPenghargaan::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'judul_penghargaan' =>  $request->judul_penghargaan,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 29 Memperoleh Penghargaan baru berhasil ditambahkan',
               'url'   =>  url('/r_029_memperoleh_penghargaan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 29 Memperoleh Penghargaan gagal disimpan']);
       }
   }
   public function edit(R029MemperolehPenghargaan $r29memperolehpenghargaan){
    if (!Gate::allows('edit-r029-memperoleh-penghargaan')) {
        abort(403);
    }
       return $r29memperolehpenghargaan;
   }

   public function update(Request $request, R029MemperolehPenghargaan $r29memperolehpenghargaan){
    if (!Gate::allows('update-r029-memperoleh-penghargaan')) {
        abort(403);
    }
       $rules = [
           'judul_penghargaan'       =>  'required',
       ];
       $text = [
           'judul_penghargaan.required' => 'Judul Penghargaan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "dosen_berprestasi_nasional") {
            $ewmp = 0.5;
        }else{
            $ewmp = 0.5;
        }
        $point = $ewmp;
       $update = R029MemperolehPenghargaan::where('id',$request->r29memperolehpenghargaan_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'judul_penghargaan'          =>  $request->judul_penghargaan,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 29 Memperoleh Penghargaan diubah',
               'url'   =>  url('/r_029_memperoleh_penghargaan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 29 Memperoleh Penghargaan gagal diubah']);
       }
   }
   public function delete(R029MemperolehPenghargaan $r29memperolehpenghargaan){
    if (!Gate::allows('delete-r029-memperoleh-penghargaan')) {
        abort(403);
    }
       $delete = $r29memperolehpenghargaan->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 29 Memperoleh Penghargaan remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_029_memperoleh_penghargaan')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 29 Memperoleh Penghargaan remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R029MemperolehPenghargaan $r029memperolehpenghargaan){
       $update = $r029memperolehpenghargaan->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_029_memperoleh_penghargaan')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R029MemperolehPenghargaan $r029memperolehpenghargaan){
       $update = $r029memperolehpenghargaan->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_029_memperoleh_penghargaan')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
