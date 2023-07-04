<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R012MembimbingPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R12DosenMembimbingPkmController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r012membimbingpkms = R012MembimbingPkm::where('nip',$_SESSION['data']['kode'])
                                               ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_012_membimbing_pkms.index',[
           'pegawais'                 =>  $pegawais,
           'periode'                  =>  $periode,
           'r012membimbingpkms'       =>  $r012membimbingpkms,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|numeric',
           'is_bkd'             =>  'required',
       ];
       $text = [
           'tingkat_pkm.required'         => 'tingkat_pkm harus diisi',
           'juara_ke.required'            => 'Penulis harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Penulis harus berupa angka',
           'is_bkd.required'              => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->tingkat_pkm == "internasional") {
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 2;
            }else{
                $ewmp = 1;
            }
        }else{
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 1;
            }else{
                $ewmp = 0.5;
            }
        }
        $point = $ewmp/$request->jumlah_pembimbing;
       $simpan = R012MembimbingPkm::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'tingkat_pkm'       =>  $request->tingkat_pkm,
        'juara_ke'          =>  $request->juara_ke,
        'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 12 Membimbing PKM baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_012_membimbing_pkm/'),
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
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|numeric',
           'is_bkd'             =>  'required',
       ];
       $text = [
           'tingkat_pkm.required'         => 'Tingkat Pkm harus diisi',
           'juara_ke.required'            => 'Penulis harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Penulis harus berupa angka',
           'is_bkd.required'              => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->tingkat_pkm == "internasional") {
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 2;
            }else{
                $ewmp = 1;
            }
        }else{
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 1;
            }else{
                $ewmp = 0.5;
            }
        }
        $point = $ewmp/$request->jumlah_pembimbing;
        $update = R012MembimbingPkm::where('id',$request->r012membimbingpkm_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'tingkat_pkm'       =>  $request->tingkat_pkm,
            'juara_ke'          =>  $request->juara_ke,
            'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 12 Membimbing PKM berhasil diubah',
               'url'   =>  url('/dosen/r_012_membimbing_pkm/'),
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
           return redirect()->route('dosen.r_012_membimbing_pkm')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 12 Membimbing PKM remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R012MembimbingPkm $r012membimbingpkm){
        $r012membimbingpkm->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R012MembimbingPkm $r012membimbingpkm){
        $r012membimbingpkm->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
