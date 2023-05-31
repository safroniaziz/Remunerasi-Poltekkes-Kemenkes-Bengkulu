<?php

namespace App\Http\Controllers;

use App\Models\R019LatihNyuluhNatarCeramahWarga;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R19LatihNyuluhNatarCeramahWargaController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r019latihnyuluhnatarceramahwargas = R019LatihNyuluhNatarCeramahWarga::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_019_latih_nyuluh_natar_ceramah_wargas.index',[
           'pegawais'                               =>  $pegawais,
           'periode'                                =>  $periode,
           'r019latihnyuluhnatarceramahwargas'       =>  $r019latihnyuluhnatarceramahwargas,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'               =>  'required|numeric',
           'judul_kegiatan'    =>  'required',
           'jenis'             =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_kegiatan.required'   => 'Judul_kegiatan harus diisi',
           'jenis.required'            => 'Jenis harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R019LatihNyuluhNatarCeramahWarga::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat baru berhasil ditambahkan',
               'url'   =>  url('/r_019_latih_nyuluh_natar_ceramah_warga/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat gagal disimpan']);
       }
   }
   public function edit(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
       return $r019latihnyuluhnatarceramahwarga;
   }

   public function update(Request $request, R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
       $rules = [
           'nip'             =>  'required|numeric',
           'judul_kegiatan'  =>  'required',
           'jenis'    =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jenis.required'            => 'Jenis harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R019LatihNyuluhNatarCeramahWarga::where('id',$request->r019latihnyuluhnatarceramahwarga_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat berhasil diubah',
               'url'   =>  url('/r_019_latih_nyuluh_natar_ceramah_warga/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat anda gagal diubah']);
       }
   }
   public function delete(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
       $delete = $r019latihnyuluhnatarceramahwarga->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_019_latih_nyuluh_natar_ceramah_warga')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
       $update = $r019latihnyuluhnatarceramahwarga->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_019_latih_nyuluh_natar_ceramah_warga')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
       $update = $r019latihnyuluhnatarceramahwarga->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_019_latih_nyuluh_natar_ceramah_warga')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}