<?php

namespace App\Http\Controllers;

use App\Models\R017NaskahBukuBahasaTerbitEdarNa;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R17NaskahBukuBahasaTerbitEdarNasController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r017_naskah_buku_bahasa_terbit_edar_nas')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r017-naskah-buku-bahasa-terbit-edar-nas')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $R017NaskahBukuBahasaTerbitEdarNa = R017NaskahBukuBahasaTerbitEdarNa::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_017_naskah_buku_bahasa_terbit_edar_nas.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $periode,
           'R017NaskahBukuBahasaTerbitEdarNa'    =>  $R017NaskahBukuBahasaTerbitEdarNa,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       $rules = [
           'judul_buku'      =>  'required',
           'isbn'            =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_buku.required'       => 'Judul_buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R017NaskahBukuBahasaTerbitEdarNa::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas baru berhasil ditambahkan',
               'url'   =>  url('/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 17 naskah buku bahasa terbit edar nas gagal disimpan']);
       }
   }
   public function edit(R017NaskahBukuBahasaTerbitEdarNa $r017naskahbukuterbitedarnas){
    if (!Gate::allows('edit-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       return $r017naskahbukuterbitedarnas;
   }

   public function update(Request $request, R017NaskahBukuBahasaTerbitEdarNa $r017naskahbukuterbitedarnas){
    if (!Gate::allows('update-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       $rules = [
           'judul_buku'           =>  'required',
           'isbn'                 =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_buku.required'       => 'Judul buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $update = R017NaskahBukuBahasaTerbitEdarNa::where('id',$request->r017naskahbukuterbitedarnas_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas berhasil diubah',
               'url'   =>  url('/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 17 naskah buku bahasa terbit edar nas anda gagal diubah']);
       }
   }
   public function delete(R017NaskahBukuBahasaTerbitEdarNa $r017naskahbukuterbitedarnas){
    if (!Gate::allows('delete-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
    $delete = $r017naskahbukuterbitedarnas->delete();
    if ($delete) {
        $notification = array(
            'message' => 'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas remunerasi berhasil dihapus',
            'alert-type' => 'success'
        );
        return redirect()->route('r_017_naskah_buku_bahasa_terbit_edar_nas')->with($notification);
    }else {
        $notification = array(
            'message' => 'Ooopps, Rubrik 17 naskah buku bahasa terbit edar nas remunerasi gagal dihapus',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}
   public function bkdSetNonActive(R017NaskahBukuBahasaTerbitEdarNa $R017NaskahBukuBahasaTerbitEdarNa){
       $update = $R017NaskahBukuBahasaTerbitEdarNa->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'mesage' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'succes'
           );
           return redirect()->route('r_017_naskah_buku_bahasa_terbit_edar_nas')->with($notification);
       }else {
           $notification = array(
               'mesage' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R017NaskahBukuBahasaTerbitEdarNa $R017NaskahBukuBahasaTerbitEdarNa){
       $update = $R017NaskahBukuBahasaTerbitEdarNa->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'mesage' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'succes'
           );
           return redirect()->route('r_017_naskah_buku_bahasa_terbit_edar_nas')->with($notification);
       }else {
           $notification = array(
               'mesage' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
