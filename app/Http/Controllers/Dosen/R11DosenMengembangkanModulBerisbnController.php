<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R011MengembangkanModulBerisbn;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R11DosenMengembangkanModulBerisbnController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r011_mengembangkan_modul_berisbns')->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r011mengembangkanmodulberisbns = R011MengembangkanModulBerisbn::where('nip',$_SESSION['data']['kode'])
                                                                        ->where('periode_id',$this->periode->id)
                                                                       ->orderBy('created_at','desc')->get();
        return view('backend/dosen/rubriks/r_011_mengembangkan_modul_berisbns.index',[
           'pegawais'                             =>  $pegawais,
           'r011mengembangkanmodulberisbns'       =>  $r011mengembangkanmodulberisbns,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'is_bkd'          =>  'required',

       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }

       $simpan = R011MengembangkanModulBerisbn::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 11 mengembangkan modul berisbn baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_011_mengembangkan_modul_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn gagal disimpan']);
       }
   }
   public function edit($r011mengembangkanmodulberisbn){
    return R011MengembangkanModulBerisbn::where('id',$r011mengembangkanmodulberisbn)->first();
   }

   public function update(Request $request, R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
       $rules = [
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }

       $update = R011MengembangkanModulBerisbn::where('id',$request->r011mengembangkanmodulberisbn_id_edit)->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik mengembangkan modul berisbn berhasil diubah',
               'url'   =>  url('/dosen/r_011_mengembangkan_modul_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik mengembangkan modul berisbn anda gagal diubah']);
       }
   }
   public function delete($r011mengembangkanmodulberisbn){
    $delete = R011MengembangkanModulBerisbn::where('id',$r011mengembangkanmodulberisbn)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik mengembangkan modul berisbn berhasil diubah',
            'url'   =>  route('dosen.r_011_mengembangkan_modul_berisbn'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik mengembangkan modul berisbn remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
        $r011mengembangkanmodulberisbn->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
        $r011mengembangkanmodulberisbn->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
