<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R018MendapatHibahPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R18DosenMendapatHibahPkmController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r018_mendapat_hibah_pkms')->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r018mendapathibahpkms = R018MendapatHibahPkm::where('nip',$_SESSION['data']['kode'])
                                                    ->where('periode_id',$this->periode->id)
                                                     ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_018_mendapat_hibah_pkms.index',[
           'pegawais'             =>  $pegawais,
           'r018mendapathibahpkms' =>  $r018mendapathibahpkms,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_hibah_pkm'      =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_hibah_pkm.required'  => 'Judul Hibah Pkm harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R018MendapatHibahPkm::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_018_mendapat_hibah_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 18 Mendapat Hibah PKM gagal disimpan']);
       }
   }
   public function edit($r018mendapathibahpkm){
    return R018MendapatHibahPkm::where('id',$r018mendapathibahpkm)->first();
   }

   public function update(Request $request, R018MendapatHibahPkm $r018mendapathibahpkm){
       $rules = [
           'judul_hibah_pkm'      =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_hibah_pkm.required'  => 'Judul hibah pkm harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       

       $point = $this->nilai_ewmp->ewmp;

       $update = R018MendapatHibahPkm::where('id',$request->r018mendapathibahpkm_id_edit)->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM berhasil diubah',
               'url'   =>  url('/dosen/r_018_mendapat_hibah_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Mendapat Hibah PKM anda gagal diubah']);
       }
   }
   public function delete($r018mendapathibahpkm){
    $delete = R018MendapatHibahPkm::where('id',$r018mendapathibahpkm)->delete();
    if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Mendapat Hibah PKM berhasil dihapus',
            'url'   =>  route('dosen.r_018_mendapat_hibah_pkm'),
        ]);
    }else {
        $notification = array(
            'message' => 'Ooopps, Rubrik Mendapat Hibah PKM gagal dihapus',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}

    public function verifikasi(R018MendapatHibahPkm $r018mendapathibahpkm){
        $r018mendapathibahpkm->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R018MendapatHibahPkm $r018mendapathibahpkm){
        $r018mendapathibahpkm->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
