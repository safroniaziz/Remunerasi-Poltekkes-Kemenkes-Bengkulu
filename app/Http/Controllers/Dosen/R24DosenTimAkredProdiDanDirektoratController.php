<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R024TimAkredProdiDanDirektorat;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R24DosenTimAkredProdiDanDirektoratController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r024_tim_akred_prodi_dan_direktorats')->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r024timakredprodirektorats = R024TimAkredProdiDanDirektorat::where('nip',$_SESSION['data']['kode'])
                                                                    ->where('periode_id',$this->periode->id)
                                                                    ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_024_tim_akred_prodi_dan_direktorats.index',[
           'pegawais'                       =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r024timakredprodirektorats'     =>  $r024timakredprodirektorats,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'    => 'Judul Kegiatan harus diisi',
           'is_bkd.required'            => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R024TimAkredProdiDanDirektorat::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
           'keterangan'        =>  $request->keterangan,

       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 24 Tim Akreditasi Prodi dan Direktorat baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_024_tim_akred_prodi_dan_direktorat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 24 Tim Akreditasi Prodi dan Direktorat gagal disimpan']);
       }
   }
   public function edit($r24timakredprodirektorat){
        return R024TimAkredProdiDanDirektorat::where('id',$r24timakredprodirektorat)->first();
   }

   public function update(Request $request, R024TimAkredProdiDanDirektorat $r24timakredprodirektorat){
       $rules = [
           'judul_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'is_bkd.required'         => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;

       $update = R024TimAkredProdiDanDirektorat::where('id',$request->r24timakredprodirektorat_id_edit)->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
           'keterangan'                 =>  $request->keterangan,

       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Tim Akreditasi Prodi dan Direktorat diubah',
               'url'   =>  url('/dosen/r_024_tim_akred_prodi_dan_direktorat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Tim Akreditasi Prodi dan Direktorat gagal diubah']);
       }
   }
   public function delete($r24timakredprodirektorat){
    $delete = R024TimAkredProdiDanDirektorat::where('id',$r24timakredprodirektorat)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Tim Akreditasi Prodi dan Direktorat dihapus',
            'url'   =>  route('dosen.r_024_tim_akred_prodi_dan_direktorat'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Tim Akreditasi Prodi dan Direktorat remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R024TimAkredProdiDanDirektorat $r24timakredprodirektorat){
        $r24timakredprodirektorat->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R024TimAkredProdiDanDirektorat $r24timakredprodirektorat){
        $r24timakredprodirektorat->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
