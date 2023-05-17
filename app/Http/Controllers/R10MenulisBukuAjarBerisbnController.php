<?php

namespace App\Http\Controllers;

use App\Models\R010MenulisBukuAjarBerisbn;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R10MenulisBukuAjarBerisbnController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r010menulisbukuajarberisbns = R010MenulisBukuAjarBerisbn::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_010_menulis_buku_ajar_berisbns.index',[
           'pegawais'                          =>  $pegawais,
           'periode'                           =>  $periode,
           'r010menulisbukuajarberisbns'       =>  $r010menulisbukuajarberisbns,
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

       $simpan = R010MenulisBukuAjarBerisbn::create([
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
               'url'   =>  url('/r_010_menulis_buku_ajar_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn gagal disimpan']);
       }
   }
   public function edit(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
       return $r010menulisbukuajarberisbn;
   }

   public function update(Request $request, R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
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

       $update = R010MenulisBukuAjarBerisbn::where('id',$request->r010menulisbukuajarberisbn_id_edit)->update([
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
               'url'   =>  url('/r_010_menulis_buku_ajar_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn anda gagal diubah']);
       }
   }
   public function delete(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
       $delete = $r010menulisbukuajarberisbn->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, R09 Menguji Seminar hasil Kti Lta Skripsi remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_010_menulis_buku_ajar_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, R09 Menguji Seminar hasil Kti Lta Skripsi remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
       $update = $r010menulisbukuajarberisbn->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_010_menulis_buku_ajar_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
       $update = $r010menulisbukuajarberisbn->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_010_menulis_buku_ajar_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
