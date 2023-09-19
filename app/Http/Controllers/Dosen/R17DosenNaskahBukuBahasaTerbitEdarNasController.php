<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R017NaskahBukuBahasaTerbitEdarNas;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R17DosenNaskahBukuBahasaTerbitEdarNasController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r017_naskah_buku_bahasa_terbit_edar_nas')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r017naskahbukubahasaterbitedarnas = R017NaskahBukuBahasaTerbitEdarNas::where('nip',$_SESSION['data']['kode'])
                                                                              ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_017_naskah_buku_bahasa_terbit_edar_nas.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $periode,
           'r017naskahbukubahasaterbitedarnas'    =>  $r017naskahbukubahasaterbitedarnas,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_buku'      =>  'required',
           'isbn'            =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_buku.required'       => 'Judul_buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R017NaskahBukuBahasaTerbitEdarNas::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 17 naskah buku bahasa terbit edar nas gagal disimpan']);
       }
   }
   public function edit($r017naskahbukuterbitedarnas){
    return R017NaskahBukuBahasaTerbitEdarNas::where('id',$r017naskahbukuterbitedarnas)->first();
   }

   public function update(Request $request, R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
       $rules = [
           'judul_buku'           =>  'required',
           'isbn'                 =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_buku.required'       => 'Judul buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $update = R017NaskahBukuBahasaTerbitEdarNas::where('id',$request->r017naskahbukuterbitedarnas_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik naskah buku bahasa terbit edar nas berhasil diubah',
               'url'   =>  url('/dosen/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik naskah buku bahasa terbit edar nas anda gagal diubah']);
       }
   }
   public function delete($r017naskahbukuterbitedarnas){
    $delete = R017NaskahBukuBahasaTerbitEdarNas::where('id',$r017naskahbukuterbitedarnas)->delete();
    if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik naskah buku bahasa terbit edar nas berhasil dihapus',
            'url'   =>  route('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas'),
        ]);
    }else {
        $notification = array(
            'message' => 'Ooopps, Rubrik naskah buku bahasa terbit edar nas remunerasi gagal dihapus',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}

    public function verifikasi(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
        $r017naskahbukuterbitedarnas->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
        $r017naskahbukuterbitedarnas->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
