<?php

namespace App\Http\Controllers;

use App\Models\R026PengelolaJurnalBuletin;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R26PengelolaJurnalBuletinController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r026-pengelola-jurnal-buletin')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r026pengelolajurnalbuletins = R026PengelolaJurnalBuletin::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_026_pengelola_jurnal_buletins.index',[
           'pegawais'                        =>  $pegawais,
           'periode'                         =>  $periode,
           'r026pengelolajurnalbuletins'     =>  $r026pengelolajurnalbuletins,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'edisi_terbit'            =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jabatan.required'          => 'Jabatan harus diisi',
           'edisi_terbit.required'     => 'Edisi Terbit harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $simpan = R026PengelolaJurnalBuletin::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'jabatan'           =>  $request->jabatan,
           'edisi_terbit'      =>  $request->edisi_terbit,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 26 Pengelola Jurnal Buletin baru berhasil ditambahkan',
               'url'   =>  url('/r_026_pengelola_jurnal_buletin/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 26 Pengelola Jurnal Buletin gagal disimpan']);
       }
   }
   public function edit(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
    if (!Gate::allows('edit-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       return $r26pengelolajurnalbuletin;
   }

   public function update(Request $request, R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
    if (!Gate::allows('update-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'edisi_terbit'            =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'jabatan.required'        => 'Jabatan harus diisi',
           'edisi_terbit.required'   => 'Edisi Terbit harus diisi',
           'is_bkd.required'         => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $update = R026PengelolaJurnalBuletin::where('id',$request->r26pengelolajurnalbuletin_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'jabatan'                    =>  $request->jabatan,
           'edisi_terbit'               =>  $request->edisi_terbit,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 26 Pengelola Jurnal Buletin diubah',
               'url'   =>  url('/r_026_pengelola_jurnal_buletin/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 26 Pengelola Jurnal Buletin gagal diubah']);
       }
   }
   public function delete(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
    if (!Gate::allows('delete-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       $delete = $r26pengelolajurnalbuletin->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 26 Pengelola Jurnal Buletin remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_026_pengelola_jurnal_buletin')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 26 Pengelola Jurnal Buletin remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R026PengelolaJurnalBuletin $r026pengelolajurnalbuletin){
       $update = $r026pengelolajurnalbuletin->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_026_pengelola_jurnal_buletin')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R026PengelolaJurnalBuletin $r026pengelolajurnalbuletin){
       $update = $r026pengelolajurnalbuletin->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_026_pengelola_jurnal_buletin')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
