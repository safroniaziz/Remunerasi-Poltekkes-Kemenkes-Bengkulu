<?php

namespace App\Http\Controllers;

use App\Models\R013OrasiIlmiahNarasumberBidangIlmu;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R13OrasiIlmiahNarasumberBidangIlmuController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r013orasiilmiahnarasumberbidangilmus = R013OrasiIlmiahNarasumberBidangIlmu::where('nip',$request->session()->get('nip_dosen'))
                                                                                   ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_013_orasi_ilmiah_narasumber_bidang_ilmus.index',[
           'pegawais'                               =>  $pegawais,
           'periode'                                =>  $periode,
           'r013orasiilmiahnarasumberbidangilmus'   =>  $r013orasiilmiahnarasumberbidangilmus,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'    =>  'required',
           'tingkatan_ke'      =>  'required',
           'is_bkd'            =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul_kegiatan harus diisi',
           'tingkatan_ke.required'     => 'Penulis harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
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
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'tingkatan_ke'      =>  $request->tingkatan_ke,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu baru berhasil ditambahkan',
               'url'   =>  url('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu gagal disimpan']);
       }
   }
   public function edit(R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
    if (!Gate::allows('edit-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }
       return $r013orasiilmiahnarasumber;
   }

   public function update(Request $request, R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
    if (!Gate::allows('update-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'  =>  'required',
           'tingkatan_ke'    =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'tingkatan_ke.required'     => 'Penulis harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
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
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'tingkatan_ke'      =>  $request->tingkatan_ke,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu berhasil diubah',
               'url'   =>  url('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu anda gagal diubah']);
       }
   }
   public function delete(R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
    if (!Gate::allows('delete-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }
       $delete = $r013orasiilmiahnarasumber->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_013_orasi_ilmiah_narasumber_bidang_ilmu')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu remunerasi gagal dihapus',
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
