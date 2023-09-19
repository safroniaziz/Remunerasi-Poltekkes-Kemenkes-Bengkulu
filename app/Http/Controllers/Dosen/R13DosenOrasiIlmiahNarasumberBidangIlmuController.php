<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R013OrasiIlmiahNarasumberBidangIlmu;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R13DosenOrasiIlmiahNarasumberBidangIlmuController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r013orasiilmiahnarasumberbidangilmus = R013OrasiIlmiahNarasumberBidangIlmu::where('nip',$_SESSION['data']['kode'])
                                                                                   ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_013_orasi_ilmiah_narasumber_bidang_ilmus.index',[
           'pegawais'                               =>  $pegawais,
           'periode'                                =>  $periode,
           'r013orasiilmiahnarasumberbidangilmus'   =>  $r013orasiilmiahnarasumberbidangilmus,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_kegiatan'    =>  'required',
           'tingkatan_ke'      =>  'required',
           'is_bkd'            =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul_kegiatan harus diisi',
           'tingkatan_ke.required'     => 'Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

        if ($request->tingkatan_ke=='internasional') {
            $point = 3;
        }elseif ($request->tingkatan_ke=='nasional') {
            $point = 2;
        }else{
            $point = 1;
        }

       $simpan = R013OrasiIlmiahNarasumberBidangIlmu::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'tingkatan_ke'      =>  $request->tingkatan_ke,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_013_orasi_ilmiah_narasumber_bidang_ilmu/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu gagal disimpan']);
       }
   }
   public function edit($r013orasiilmiahnarasumber){
    return R013OrasiIlmiahNarasumberBidangIlmu::where('id',$r013orasiilmiahnarasumber)->first();
   }

   public function update(Request $request, R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
       $rules = [
           'judul_kegiatan'  =>  'required',
           'tingkatan_ke'    =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'tingkatan_ke.required'     => 'Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

        if ($request->tingkatan_ke=='internasional') {
            $point = 3;
        }elseif ($request->tingkatan_ke=='nasional') {
            $point = 2;
        }else{
            $point = 1;
        }

       $update = R013OrasiIlmiahNarasumberBidangIlmu::where('id',$request->r013Orasiilmiahnarasumber_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'tingkatan_ke'      =>  $request->tingkatan_ke,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Orasi Ilmiah Narasumber Bidang Ilmu berhasil diubah',
               'url'   =>  url('/dosen/r_013_orasi_ilmiah_narasumber_bidang_ilmu/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Orasi Ilmiah Narasumber Bidang Ilmu anda gagal diubah']);
       }
   }
   public function delete($r013orasiilmiahnarasumber){
    $delete = R013OrasiIlmiahNarasumberBidangIlmu::where('id',$r013orasiilmiahnarasumber)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Orasi Ilmiah Narasumber Bidang Ilmu berhasil dihapus',
            'url'   =>  route('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Orasi Ilmiah Narasumber Bidang Ilmu remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
        $r013orasiilmiahnarasumber->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
        $r013orasiilmiahnarasumber->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
