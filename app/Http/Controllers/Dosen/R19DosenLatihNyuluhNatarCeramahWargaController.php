<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R019LatihNyuluhNatarCeramahWarga;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R19DosenLatihNyuluhNatarCeramahWargaController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r019latihnyuluhnatarceramahwargas = R019LatihNyuluhNatarCeramahWarga::where('nip',$_SESSION['data']['kode'])
                                                                             ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_019_latih_nyuluh_natar_ceramah_wargas.index',[
           'pegawais'                               =>  $pegawais,
           'periode'                                =>  $periode,
           'r019latihnyuluhnatarceramahwargas'       =>  $r019latihnyuluhnatarceramahwargas,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_kegiatan'    =>  'required',
           'jenis'             =>  'required',
           'is_bkd'            =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul_kegiatan harus diisi',
           'jenis.required'            => 'Jenis harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis == "insidentil") {
            $ewmp = 0.50;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $simpan = R019LatihNyuluhNatarCeramahWarga::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_019_latih_nyuluh_natar_ceramah_warga/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat gagal disimpan']);
       }
   }
   public function edit($r019latihnyuluhnatarceramahwarga){
    return R019LatihNyuluhNatarCeramahWarga::where('id',$r019latihnyuluhnatarceramahwarga)->first();
   }

   public function update(Request $request, R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
       $rules = [
           'judul_kegiatan'  =>  'required',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jenis.required'            => 'Jenis harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();
       if ($request->jenis == "insidentil") {
            $ewmp = 0.50;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $update = R019LatihNyuluhNatarCeramahWarga::where('id',$request->r019latihnyuluhnatarceramahwarga_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat berhasil diubah',
               'url'   =>  url('/dosen/r_019_latih_nyuluh_natar_ceramah_warga/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat anda gagal diubah']);
       }
   }
   public function delete($r019latihnyuluhnatarceramahwarga){
    $delete = R019LatihNyuluhNatarCeramahWarga::where('id',$r019latihnyuluhnatarceramahwarga)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat berhasil diubah',
            'url'   =>  route('dosen.r_019_latih_nyuluh_natar_ceramah_warga'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
        $r019latihnyuluhnatarceramahwarga->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
        $r019latihnyuluhnatarceramahwarga->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
