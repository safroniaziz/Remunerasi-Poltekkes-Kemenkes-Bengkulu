<?php

namespace App\Http\Controllers;

use App\Models\R014KaryaInovasi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R14KaryaInovasiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r014-karya-inovasi')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r014karyainovasis = R014KaryaInovasi::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_014_karya_inovasis.index',[
           'pegawais'                =>  $pegawais,
           'periode'                 =>  $periode,
           'r014karyainovasis'       =>  $r014karyainovasis,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r014-karya-inovasi')) {
        abort(403);
    }
       $rules = [
           'nip'             =>  'required|numeric',
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',

       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jenis.required'            => 'Jumlah Penulis harus diisi',

       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R014KaryaInovasi::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 14 Karya Inovasi baru berhasil ditambahkan',
               'url'   =>  url('/r_014_karya_inovasi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 14 Karya Inovasi gagal disimpan']);
       }
   }
   public function edit(R014KaryaInovasi $r014karyainovasi){
    if (!Gate::allows('edit-r014-karya-inovasi')) {
        abort(403);
    }
       return $r014karyainovasi;
   }

   public function update(Request $request, R014KaryaInovasi $r014karyainovasi){
    if (!Gate::allows('update-r014-karya-inovasi')) {
        abort(403);
    }
       $rules = [
           'nip'             =>  'required|numeric',
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jenis.required'            => 'Jumlah Penulis harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R014KaryaInovasi::where('id',$request->r014karyainovasi_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 14 Karya Inovasi berhasil diubah',
               'url'   =>  url('/r_014_karya_inovasi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 14 Karya Inovasi anda gagal diubah']);
       }
   }
   public function delete(R014KaryaInovasi $r014karyainovasi){
    if (!Gate::allows('delete-r014-karya-inovasi')) {
        abort(403);
    }
       $delete = $r014karyainovasi->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 14 Karya Inovasi remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_014_karya_inovasi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 14 Karya Inovasi remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R014KaryaInovasi $r014karyainovasi){
       $update = $r014karyainovasi->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_014_karya_inovasi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R014KaryaInovasi $r014karyainovasi){
       $update = $r014karyainovasi->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_014_karya_inovasi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
