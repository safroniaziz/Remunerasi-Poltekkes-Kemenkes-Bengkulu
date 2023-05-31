<?php

namespace App\Http\Controllers;

use App\Models\R028MelaksanakanPengembanganDiri;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R28MelaksanakanPengembanganDiriController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r028melaksanakanpengembangandiris = R028MelaksanakanPengembanganDiri::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_028_melaksanakan_pengembangan_diris.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
           'r028melaksanakanpengembangandiris'     =>  $r028melaksanakanpengembangandiris,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'                     =>  'required|numeric',
           'jenis_kegiatan'          =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'jenis_kegiatan.required'   => 'Jenis Kegiatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R028MelaksanakanPengembanganDiri::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->nip,
           'jenis_kegiatan'    =>  $request->jenis_kegiatan,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri baru berhasil ditambahkan',
               'url'   =>  url('/r_028_melaksanakan_pengembangan_diri/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 28 Melaksanakan Pengembangan Diri gagal disimpan']);
       }
   }
   public function edit(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
       return $r28laksanakanpengembangandiri;
   }

   public function update(Request $request, R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
       $rules = [
           'nip'                     =>  'required|numeric',
           'jenis_kegiatan'          =>  'required',
       ];
       $text = [
           'nip.required'            => 'NIP harus dipilih',
           'nip.numeric'             => 'NIP harus berupa angka',
           'jenis_kegiatan.required' => 'Jenis Kegiatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R028MelaksanakanPengembanganDiri::where('id',$request->r28laksanakanpengembangandiri_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->nip,
           'jenis_kegiatan'             =>  $request->jenis_kegiatan,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri diubah',
               'url'   =>  url('/r_028_melaksanakan_pengembangan_diri/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 28 Melaksanakan Pengembangan Diri gagal diubah']);
       }
   }
   public function delete(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
       $delete = $r28laksanakanpengembangandiri->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_028_melaksanakan_pengembangan_diri')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 28 Melaksanakan Pengembangan Diri remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R028MelaksanakanPengembanganDiri $r028melaksanakanpengembangandiri){
       $update = $r028melaksanakanpengembangandiri->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_028_melaksanakan_pengembangan_diri')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R028MelaksanakanPengembanganDiri $r028melaksanakanpengembangandiri){
       $update = $r028melaksanakanpengembangandiri->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_028_melaksanakan_pengembangan_diri')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}