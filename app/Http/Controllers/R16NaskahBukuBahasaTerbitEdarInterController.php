<?php

namespace App\Http\Controllers;

use App\Models\R016NaskahBukuBahasaTerbitEdarInter;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R16NaskahBukuBahasaTerbitEdarInterController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r016naskahbukubahasaterbitedarinters = R016NaskahBukuBahasaTerbitEdarInter::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_016_naskah_buku_bahasa_terbit_edar_inters.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $periode,
           'r016naskahbukubahasaterbitedarinters' =>  $r016naskahbukubahasaterbitedarinters,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'             =>  'required|numeric',
           'judul_buku'           =>  'required',
           'isbn'            =>  'required',

       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_buku.required'            => 'Judul_buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R016NaskahBukuBahasaTerbitEdarInter::create([
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
               'text'  =>  'Yeay, Rubrik 16 naskah buku bahasa terbit edar inter baru berhasil ditambahkan',
               'url'   =>  url('/r_016_naskah_buku_bahasa_terbit_edar_inter/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 16 naskah buku bahasa terbit edar inter gagal disimpan']);
       }
   }
   public function edit(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
       return $r016naskahbukuterbitedarinter;
   }

   public function update(Request $request, R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
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

       $update = R016NaskahBukuBahasaTerbitEdarInter::where('id',$request->r016naskahbukuterbitedarinter_id_edit)->update([
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
               'text'  =>  'Yeay, Rubrik 16 naskah buku bahasa terbit edar inter berhasil diubah',
               'url'   =>  url('/r_016_naskah_buku_bahasa_terbit_edar_inter/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 16 naskah buku bahasa terbit edar inter anda gagal diubah']);
       }
   }
   public function delete(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
       $delete = $r016naskahbukuterbitedarinter->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 16 naskah buku bahasa terbit edar inter remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_016_naskah_buku_bahasa_terbit_edar_inter')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 16 naskah buku bahasa terbit edar inter remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukubahasaterbitedarinter){
       $update = $r016naskahbukubahasaterbitedarinter->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_016_naskah_buku_bahasa_terbit_edar_inter')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukubahasaterbitedarinter){
       $update = $r016naskahbukubahasaterbitedarinter->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_016_naskah_buku_bahasa_terbit_edar_inter')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}