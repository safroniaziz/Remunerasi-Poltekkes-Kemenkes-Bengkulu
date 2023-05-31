<?php

namespace App\Http\Controllers;

use App\Models\R017NaskahBukuBahasaTerbitEdarNas;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R17NaskahBukuBahasaTerbitEdarNasController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r017-naskah-buku-bahasa-terbit-edar-nas')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r017naskahbukubahasaterbitedarnas = R017NaskahBukuBahasaTerbitEdarNas::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_017_naskah_buku_bahasa_terbit_edar_nas.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $periode,
           'r017naskahbukubahasaterbitedarnas' =>  $r017naskahbukubahasaterbitedarnas,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       $rules = [
           'nip'             =>  'required|numeric',
           'judul_buku'      =>  'required',
           'isbn'            =>  'required',

       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_buku.required'       => 'Judul_buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R017NaskahBukuBahasaTerbitEdarNas::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul_buku'             =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
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
   public function edit(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
    if (!Gate::allows('edit-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       return $r017naskahbukuterbitedarnas;
   }

   public function update(Request $request, R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
    if (!Gate::allows('update-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       $rules = [
           'nip'                  =>  'required|numeric',
           'judul_buku'           =>  'required',
           'isbn'                 =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_buku.required'       => 'Judul buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R017NaskahBukuBahasaTerbitEdarNas::where('id',$request->r017naskahbukuterbitedarnas_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
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
   public function delete(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
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
   public function bkdSetNonActive(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukubahasaterbitedarnas){
       $update = $r017naskahbukubahasaterbitedarnas->update([
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

   public function bkdSetActive(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukubahasaterbitedarnas){
       $update = $r017naskahbukubahasaterbitedarnas->update([
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
