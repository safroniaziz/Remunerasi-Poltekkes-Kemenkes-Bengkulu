<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R016NaskahBukuBahasaTerbitEdarInter;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class R16DosenNaskahBukuBahasaTerbitEdarInterController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r016_naskah_buku_bahasa_terbit_edar_inters')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r016naskahbukubahasaterbitedarinters = R016NaskahBukuBahasaTerbitEdarInter::where('nip',$_SESSION['data']['kode'])
                                                                                   ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_016_naskah_buku_bahasa_terbit_edar_inters.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $periode,
           'r016naskahbukubahasaterbitedarinters' =>  $r016naskahbukubahasaterbitedarinters,
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
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R016NaskahBukuBahasaTerbitEdarInter::create([
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
               'text'  =>  'Yeay, Rubrik 16 naskah buku bahasa terbit edar inter baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_016_naskah_buku_bahasa_terbit_edar_inter/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 16 naskah buku bahasa terbit edar inter gagal disimpan']);
       }
   }
   public function edit($r016naskahbukuterbitedarinter){
    return R016NaskahBukuBahasaTerbitEdarInter::where('id',$r016naskahbukuterbitedarinter)->first();
   }

   public function update(Request $request, R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
       $rules = [
           'judul_buku'           =>  'required',
           'isbn'                 =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_buku.required'       => 'Judul buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $update = R016NaskahBukuBahasaTerbitEdarInter::where('id',$request->r016naskahbukuterbitedarinter_id_edit)->update([
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
               'text'  =>  'Yeay, Rubrik naskah buku bahasa terbit edar inter berhasil diubah',
               'url'   =>  url('/dosen/r_016_naskah_buku_bahasa_terbit_edar_inter/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik naskah buku bahasa terbit edar inter anda gagal diubah']);
       }
   }
   public function delete($r016naskahbukuterbitedarinter){
    $delete = R016NaskahBukuBahasaTerbitEdarInter::where('id',$r016naskahbukuterbitedarinter)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik naskah buku bahasa terbit edar inter berhasil dihapus',
            'url'   =>  route('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik naskah buku bahasa terbit edar inter remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
        $r016naskahbukuterbitedarinter->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
        $r016naskahbukuterbitedarinter->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
