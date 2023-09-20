<?php

namespace App\Http\Controllers;

use App\Models\R011MengembangkanModulBerisbn;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R11MengembangkanModulBerisbnController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r011_mengembangkan_modul_berisbns')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r011-mengembangkan-modul-berisbn')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r011mengembangkanmodulberisbns = R011MengembangkanModulBerisbn::where('nip',$request->session()->get('nip_dosen'))
                                                                       ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_011_mengembangkan_modul_berisbns.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $periode,
           'r011mengembangkanmodulberisbns'       =>  $r011mengembangkanmodulberisbns,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
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

       $periode = Periode::select('id')->where('is_active','1')->first();

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }

       $simpan = R011MengembangkanModulBerisbn::create([
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
               'text'  =>  'Yeay, Rubrik 11 mengembangkan modul berisbn baru berhasil ditambahkan',
               'url'   =>  url('/r_011_mengembangkan_modul_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn gagal disimpan']);
       }
   }
   public function edit(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
    if (!Gate::allows('edit-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
       return $r011mengembangkanmodulberisbn;
   }

   public function update(Request $request, R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
    if (!Gate::allows('update-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
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

       $periode = Periode::select('id')->where('is_active','1')->first();

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }

       $update = R011MengembangkanModulBerisbn::where('id',$request->r011mengembangkanmodulberisbn_id_edit)->update([
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
               'text'  =>  'Yeay, Rubrik 11 mengembangkan modul berisbn berhasil diubah',
               'url'   =>  url('/r_011_mengembangkan_modul_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn anda gagal diubah']);
       }
   }
   public function delete(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
    if (!Gate::allows('delete-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
       $delete = $r011mengembangkanmodulberisbn->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 11 mengembangkan modul berisbn remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_011_mengembangkan_modul_berisbn')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 11 mengembangkan modul berisbn remunerasi gagal dihapus',
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
