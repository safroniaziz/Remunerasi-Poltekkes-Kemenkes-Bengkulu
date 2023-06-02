<?php

namespace App\Http\Controllers;

use App\Models\R024TimAkredProdiDanDirektorat;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R24TimAkredProdiDanDirektoratController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r024_tim_akred_prodi_dan_direktorats')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r024-tim-akred-prodi-dan-direktorat')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r024timakredprodirektorats = R024TimAkredProdiDanDirektorat::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_024_tim_akred_prodi_dan_direktorats.index',[
           'pegawais'                       =>  $pegawais,
           'periode'                        =>  $periode,
           'r024timakredprodirektorats'     =>  $r024timakredprodirektorats,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r024-tim-akred-prodi-dan-direktorat')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'    => 'Judul Kegiatan harus diisi',
           'is_bkd.required'            => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R024TimAkredProdiDanDirektorat::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 24 Tim Akreditasi Prodi dan Direktorat baru berhasil ditambahkan',
               'url'   =>  url('/r_024_tim_akred_prodi_dan_direktorat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 24 Tim Akreditasi Prodi dan Direktorat gagal disimpan']);
       }
   }
   public function edit(R024TimAkredProdiDanDirektorat $r24timakredprodirektorat){
    if (!Gate::allows('edit-r024-tim-akred-prodi-dan-direktorat')) {
        abort(403);
    }
       return $r24timakredprodirektorat;
   }

   public function update(Request $request, R024TimAkredProdiDanDirektorat $r24timakredprodirektorat){
    if (!Gate::allows('update-r024-tim-akred-prodi-dan-direktorat')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'is_bkd.required'         => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $update = R024TimAkredProdiDanDirektorat::where('id',$request->r24timakredprodirektorat_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 24 Tim Akreditasi Prodi dan Direktorat diubah',
               'url'   =>  url('/r_024_tim_akred_prodi_dan_direktorat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 24 Tim Akreditasi Prodi dan Direktorat gagal diubah']);
       }
   }
   public function delete(R024TimAkredProdiDanDirektorat $r24timakredprodirektorat){
    if (!Gate::allows('delete-r024-tim-akred-prodi-dan-direktorat')) {
        abort(403);
    }
       $delete = $r24timakredprodirektorat->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 24 Tim Akreditasi Prodi dan Direktorat remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_024_tim_akred_prodi_dan_direktorat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 24 Tim Akreditasi Prodi dan Direktorat remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R024TimAkredProdiDanDirektorat $r024timakredprodirektorat){
       $update = $r024timakredprodirektorat->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_024_tim_akred_prodi_dan_direktorat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R024TimAkredProdiDanDirektorat $r024timakredprodirektorat){
       $update = $r024timakredprodirektorat->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_024_tim_akred_prodi_dan_direktorat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
