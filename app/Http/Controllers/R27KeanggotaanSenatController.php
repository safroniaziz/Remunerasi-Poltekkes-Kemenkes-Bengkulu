<?php

namespace App\Http\Controllers;

use App\Models\R027KeanggotaanSenat;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R27KeanggotaanSenatController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r027keanggotaansenats = R027KeanggotaanSenat::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_027_keanggotaan_senats.index',[
           'pegawais'                  =>  $pegawais,
           'periode'                   =>  $periode,
           'r027keanggotaansenats'     =>  $r027keanggotaansenats,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'                     =>  'required|numeric',
           'jabatan'                 =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'jabatan.required'          => 'Jabatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R027KeanggotaanSenat::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->nip,
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 27 Keanggotaan Senat baru berhasil ditambahkan',
               'url'   =>  url('/r_027_keanggotaan_senat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 27 Keanggotaan Senat gagal disimpan']);
       }
   }
   public function edit(R027KeanggotaanSenat $r27keanggotaansenat){
       return $r27keanggotaansenat;
   }

   public function update(Request $request, R027KeanggotaanSenat $r27keanggotaansenat){
       $rules = [
           'nip'                     =>  'required|numeric',
           'jabatan'                 =>  'required',
       ];
       $text = [
           'nip.required'            => 'NIP harus dipilih',
           'nip.numeric'             => 'NIP harus berupa angka',
           'jabatan.required'        => 'Jabatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R027KeanggotaanSenat::where('id',$request->r27keanggotaansenat_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->nip,
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 27 Keanggotaan Senat diubah',
               'url'   =>  url('/r_027_keanggotaan_senat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 27 Keanggotaan Senat gagal diubah']);
       }
   }
   public function delete(R027KeanggotaanSenat $r27keanggotaansenat){
       $delete = $r27keanggotaansenat->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 27 Keanggotaan Senat remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_027_keanggotaan_senat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 27 Keanggotaan Senat remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R027KeanggotaanSenat $r027keanggotaansenat){
       $update = $r027keanggotaansenat->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_027_keanggotaan_senat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R027KeanggotaanSenat $r027keanggotaansenat){
       $update = $r027keanggotaansenat->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_027_keanggotaan_senat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
