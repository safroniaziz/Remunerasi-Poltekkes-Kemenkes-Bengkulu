<?php

namespace App\Http\Controllers;

use App\Models\R012MembimbingPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R12MembimbingPkmController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r012membimbingpkms = R012MembimbingPkm::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_012_membimbing_pkms.index',[
           'pegawais'                 =>  $pegawais,
           'periode'                  =>  $periode,
           'r012membimbingpkms'       =>  $r012membimbingpkms,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'                =>  'required|numeric',
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|numeric',

       ];
       $text = [
           'nip.required'                 => 'NIP harus dipilih',
           'nip.numeric'                  => 'NIP harus berupa angka',
           'tingkat_pkm.required'         => 'tingkat_pkm harus diisi',
           'juara_ke.required'            => 'Penulis harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Penulis harus berupa angka',

       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R012MembimbingPkm::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'tingkat_pkm'       =>  $request->tingkat_pkm,
        'juara_ke'          =>  $request->juara_ke,
        'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 12 Membimbing PKM baru berhasil ditambahkan',
               'url'   =>  url('/r_012_membimbing_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 12 Membimbing PKM gagal disimpan']);
       }
   }
   public function edit(R012MembimbingPkm $r012membimbingpkm){
       return $r012membimbingpkm;
   }

   public function update(Request $request, R012MembimbingPkm $r012membimbingpkm){
       $rules = [
           'nip'                =>  'required|numeric',
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|numeric',
       ];
       $text = [
           'nip.required'                 => 'NIP harus dipilih',
           'nip.numeric'                  => 'NIP harus berupa angka',
           'tingkat_pkm.required'         => 'Tingkat Pkm harus diisi',
           'juara_ke.required'            => 'Penulis harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Penulis harus berupa angka',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R012MembimbingPkm::where('id',$request->r012membimbingpkm_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'tingkat_pkm'       =>  $request->tingkat_pkm,
        'juara_ke'          =>  $request->juara_ke,
        'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 12 Membimbing PKM berhasil diubah',
               'url'   =>  url('/r_012_membimbing_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 12 Membimbing PKM anda gagal diubah']);
       }
   }
   public function delete(R012MembimbingPkm $r012membimbingpkm){
       $delete = $r012membimbingpkm->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 12 Membimbing PKM remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_012_membimbing_pkm')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 12 Membimbing PKM remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R012MembimbingPkm $r012membimbingpkm){
       $update = $r012membimbingpkm->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_012_membimbing_pkm')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R012MembimbingPkm $r012membimbingpkm){
       $update = $r012membimbingpkm->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_012_membimbing_pkm')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
