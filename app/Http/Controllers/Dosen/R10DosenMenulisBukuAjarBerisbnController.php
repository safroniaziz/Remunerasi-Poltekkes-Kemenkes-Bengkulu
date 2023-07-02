<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R010MenulisBukuAjarBerisbn;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R10DosenMenulisBukuAjarBerisbnController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r010_menulis_buku_ajar_berisbns')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r010menulisbukuajarberisbns = R010MenulisBukuAjarBerisbn::where('nip',$request->session()->get('nip_dosen'))
                                                                 ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_010_menulis_buku_ajar_berisbns.index',[
           'pegawais'                          =>  $pegawais,
           'periode'                           =>  $periode,
           'r010menulisbukuajarberisbns'       =>  $r010menulisbukuajarberisbns,
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
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }

       $simpan = R010MenulisBukuAjarBerisbn::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
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
               'text'  =>  'Yeay, Rubrik 10 Menulis Buku Ajar Berisbn baru berhasil ditambahkan',
               'url'   =>  url('/r_010_menulis_buku_ajar_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 10 Menulis Buku Ajar Berisbn gagal disimpan']);
       }
   }
   public function edit(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
       return $r010menulisbukuajarberisbn;
   }

   public function update(Request $request, R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
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
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }
       $update = R010MenulisBukuAjarBerisbn::where('id',$request->r010menulisbukuajarberisbn_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
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
               'text'  =>  'Yeay, Rubrik 10 Menulis Buku Ajar Berisbn berhasil diubah',
               'url'   =>  url('/r_010_menulis_buku_ajar_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 10 Menulis Buku Ajar Berisbn anda gagal diubah']);
       }
   }
   public function delete(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
       $delete = $r010menulisbukuajarberisbn->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 10 Menulis Buku Ajar Berisbn remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_010_menulis_buku_ajar_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 10 Menulis Buku Ajar Berisbn remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
        $r010menulisbukuajarberisbn->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
        $r010menulisbukuajarberisbn->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
