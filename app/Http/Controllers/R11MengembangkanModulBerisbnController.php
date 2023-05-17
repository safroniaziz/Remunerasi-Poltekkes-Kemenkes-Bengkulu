<?php

namespace App\Http\Controllers;

use App\Models\R011MengembangkanModulBerisbn;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R11MengembangkanModulBerisbnController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r011mengembangkanmodulberisbns = R011MengembangkanModulBerisbn::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_011_mengembangkan_modul_berisbns.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $periode,
           'r011mengembangkanmodulberisbns'       =>  $r011mengembangkanmodulberisbns,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'                   =>  'required|numeric',
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',

       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',

       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R011MengembangkanModulBerisbn::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 11 mengembangkan modul berisbn baru berhasil ditambahkan',
               'url'   =>  url('/r_011_mengembangkan_modul_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn gagal disimpan']);
       }
   }
   public function edit(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
       return $r011mengembangkanmodulberisbn;
   }

   public function update(Request $request, R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
       $rules = [
           'nip'                   =>  'required|numeric',
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R011MengembangkanModulBerisbn::where('id',$request->r011mengembangkanmodulberisbn_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 11 mengembangkan modul berisbn berhasil diubah',
               'url'   =>  url('/r_011_mengembangkan_modul_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn anda gagal diubah']);
       }
   }
   public function delete(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
       $delete = $r011mengembangkanmodulberisbn->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, R09 Menguji Seminar hasil Kti Lta Skripsi remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_011_mengembangkan_modul_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, R09 Menguji Seminar hasil Kti Lta Skripsi remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
       $update = $r011mengembangkanmodulberisbn->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_011_mengembangkan_modul_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
       $update = $r011mengembangkanmodulberisbn->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_011_mengembangkan_modul_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
