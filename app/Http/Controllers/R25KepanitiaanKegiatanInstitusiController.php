<?php

namespace App\Http\Controllers;

use App\Models\R025KepanitiaanKegiatanInstitusi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R25KepanitiaanKegiatanInstitusiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r025-kepanitiaan-kegiatan-institusi')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r025kepanitiaankegiataninstitusis = R025KepanitiaanKegiatanInstitusi::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_025_kepanitiaan_kegiatan_institusis.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
           'r025kepanitiaankegiataninstitusis'     =>  $r025kepanitiaankegiataninstitusis,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r025-kepanitiaan-kegiatan-institusi')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jabatan.required'          => 'Jabatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua" || $request->jabatan == "wakil") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $simpan = R025KepanitiaanKegiatanInstitusi::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 25 Kepanitiaan Kegiatan Institusi baru berhasil ditambahkan',
               'url'   =>  url('/r_025_kepanitiaan_kegiatan_institusi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 25 Kepanitiaan Kegiatan Institusi gagal disimpan']);
       }
   }
   public function edit(R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
    if (!Gate::allows('edit-r025-kepanitiaan-kegiatan-institusi')) {
        abort(403);
    }
       return $r25panitiakegiataninstitusi;
   }

   public function update(Request $request, R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
    if (!Gate::allows('update-r025-kepanitiaan-kegiatan-institusi')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'jabatan.required'        => 'Jabatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua" || $request->jabatan == "wakil") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $update = R025KepanitiaanKegiatanInstitusi::where('id',$request->r25panitiakegiataninstitusi_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 25 Kepanitiaan Kegiatan Institusi diubah',
               'url'   =>  url('/r_025_kepanitiaan_kegiatan_institusi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 25 Kepanitiaan Kegiatan Institusi gagal diubah']);
       }
   }
   public function delete(R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
    if (!Gate::allows('delete-r025-kepanitiaan-kegiatan-institusi')) {
        abort(403);
    }
       $delete = $r25panitiakegiataninstitusi->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 25 Kepanitiaan Kegiatan Institusi remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_025_kepanitiaan_kegiatan_institusi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 25 Kepanitiaan Kegiatan Institusi remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R025KepanitiaanKegiatanInstitusi $r025kepanitiaankegiataninstitusi){
       $update = $r025kepanitiaankegiataninstitusi->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_025_kepanitiaan_kegiatan_institusi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R025KepanitiaanKegiatanInstitusi $r025kepanitiaankegiataninstitusi){
       $update = $r025kepanitiaankegiataninstitusi->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_025_kepanitiaan_kegiatan_institusi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
