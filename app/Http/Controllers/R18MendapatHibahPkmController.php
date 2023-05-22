<?php

namespace App\Http\Controllers;

use App\Models\R018MendapatHibahPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R18MendapatHibahPkmController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r018mendapathibahpkms = R018MendapatHibahPkm::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_018_mendapat_hibah_pkms.index',[
           'pegawais'             =>  $pegawais,
           'periode'              =>  $periode,
           'r018mendapathibahpkms' =>  $r018mendapathibahpkms,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'                  =>  'required|numeric',
           'judul_hibah_pkm'      =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_hibah_pkm.required'  => 'Judul Hibah Pkm harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R018MendapatHibahPkm::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM baru berhasil ditambahkan',
               'url'   =>  url('/r_018_mendapat_hibah_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 18 Mendapat Hibah PKM gagal disimpan']);
       }
   }
   public function edit(R018MendapatHibahPkm $r018mendapathibahpkm){
       return $r018mendapathibahpkm;
   }

   public function update(Request $request, R018MendapatHibahPkm $r018mendapathibahpkm){
       $rules = [
           'nip'                  =>  'required|numeric',
           'judul_hibah_pkm'      =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_hibah_pkm.required'  => 'Judul hibah pkm harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R018MendapatHibahPkm::where('id',$request->r018mendapathibahpkm_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM berhasil diubah',
               'url'   =>  url('/r_018_mendapat_hibah_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 18 Mendapat Hibah PKM anda gagal diubah']);
       }
   }
   public function delete(R018MendapatHibahPkm $r018mendapathibahpkm){
    $delete = $r018mendapathibahpkm->delete();
    if ($delete) {
        $notification = array(
            'message' => 'Yeay, Rubrik 18 Mendapat Hibah PKM berhasil dihapus',
            'alert-type' => 'success'
        );
        return redirect()->route('r_018_mendapat_hibah_pkm')->with($notification);
    }else {
        $notification = array(
            'message' => 'Ooopps, Rubrik 18 Mendapat Hibah PKM gagal dihapus',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}
   public function bkdSetNonActive(R018MendapatHibahPkm $r018mendapathibahpkm){
       $update = $r018mendapathibahpkm->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'mesage' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'succes'
           );
           return redirect()->route('r_018_mendapat_hibah_pkm')->with($notification);
       }else {
           $notification = array(
               'mesage' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R018MendapatHibahPkm $r018mendapathibahpkm){
       $update = $r018mendapathibahpkm->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'mesage' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'succes'
           );
           return redirect()->route('r_018_mendapat_hibah_pkm')->with($notification);
       }else {
           $notification = array(
               'mesage' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
