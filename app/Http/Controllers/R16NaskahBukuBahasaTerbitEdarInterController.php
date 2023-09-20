<?php

namespace App\Http\Controllers;

use App\Models\R016NaskahBukuBahasaTerbitEdarInter;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class R16NaskahBukuBahasaTerbitEdarInterController extends Controller
{
    private $nilai_ewmp;
    private $periode;

    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r016_naskah_buku_bahasa_terbit_edar_inters')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r016-naskah-buku-bahasa-terbit-edar-inter')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r016naskahbukubahasaterbitedarinters = R016NaskahBukuBahasaTerbitEdarInter::where('nip',$request->session()->get('nip_dosen'))
                                                                                    ->where('periode_id',$this->periode->id)
                                                                                    ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_016_naskah_buku_bahasa_terbit_edar_inters.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $this->periode,
           'r016naskahbukubahasaterbitedarinters' =>  $r016naskahbukubahasaterbitedarinters,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r016-naskah-buku-bahasa-terbit-edar-inter')) {
        abort(403);
    }
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



       $point = $this->nilai_ewmp->ewmp;

       $simpan = R016NaskahBukuBahasaTerbitEdarInter::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 16 naskah buku bahasa terbit edar inter baru berhasil ditambahkan',
               'url'   =>  url('/r_016_naskah_buku_bahasa_terbit_edar_inter/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 16 naskah buku bahasa terbit edar inter gagal disimpan']);
       }
   }
   public function edit(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
    if (!Gate::allows('edit-r016-naskah-buku-bahasa-terbit-edar-inter')) {
        abort(403);
    }
       return $r016naskahbukuterbitedarinter;
   }

   public function update(Request $request, R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
    if (!Gate::allows('update-r016-naskah-buku-bahasa-terbit-edar-inter')) {
        abort(403);
    }
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



       $point = $this->nilai_ewmp->ewmp;

       $update = R016NaskahBukuBahasaTerbitEdarInter::where('id',$request->r016naskahbukuterbitedarinter_id_edit)->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 16 naskah buku bahasa terbit edar inter berhasil diubah',
               'url'   =>  url('/r_016_naskah_buku_bahasa_terbit_edar_inter/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 16 naskah buku bahasa terbit edar inter anda gagal diubah']);
       }
   }
   public function delete(R016NaskahBukuBahasaTerbitEdarInter $r016naskahbukuterbitedarinter){
    if (!Gate::allows('delete-r016-naskah-buku-bahasa-terbit-edar-inter')) {
        abort(403);
    }
       $delete = $r016naskahbukuterbitedarinter->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 16 naskah buku bahasa terbit edar inter remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_016_naskah_buku_bahasa_terbit_edar_inter')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 16 naskah buku bahasa terbit edar inter remunerasi gagal dihapus',
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
