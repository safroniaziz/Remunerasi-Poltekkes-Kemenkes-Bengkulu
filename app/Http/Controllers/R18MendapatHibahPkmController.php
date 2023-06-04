<?php

namespace App\Http\Controllers;

use App\Models\R018MendapatHibahPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R18MendapatHibahPkmController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r018_mendapat_hibah_pkms')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r018-mendapat-hibah-pkm')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r018mendapathibahpkms = R018MendapatHibahPkm::where('nip',$request->session()->get('nip_dosen'))
                                                     ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_018_mendapat_hibah_pkms.index',[
           'pegawais'             =>  $pegawais,
           'periode'              =>  $periode,
           'r018mendapathibahpkms' =>  $r018mendapathibahpkms,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r018-mendapat-hibah-pkm')) {
        abort(403);
    }
       $rules = [
           'judul_hibah_pkm'      =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_hibah_pkm.required'  => 'Judul Hibah Pkm harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R018MendapatHibahPkm::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM baru berhasil ditambahkan',
               'url'   =>  url('/r_018_mendapat_hibah_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 18 Mendapat Hibah PKM gagal disimpan']);
       }
   }
   public function edit(R018MendapatHibahPkm $r018mendapathibahpkm){
    if (!Gate::allows('edit-r018-mendapat-hibah-pkm')) {
        abort(403);
    }
       return $r018mendapathibahpkm;
   }

   public function update(Request $request, R018MendapatHibahPkm $r018mendapathibahpkm){
    if (!Gate::allows('update-r018-mendapat-hibah-pkm')) {
        abort(403);
    }
       $rules = [
           'judul_hibah_pkm'      =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_hibah_pkm.required'  => 'Judul hibah pkm harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $update = R018MendapatHibahPkm::where('id',$request->r018mendapathibahpkm_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM berhasil diubah',
               'url'   =>  url('/r_018_mendapat_hibah_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 18 Mendapat Hibah PKM anda gagal diubah']);
       }
   }
   public function delete(R018MendapatHibahPkm $r018mendapathibahpkm){
    if (!Gate::allows('delete-r018-mendapat-hibah-pkm')) {
        abort(403);
    }
    $delete = $r018mendapathibahpkm->delete();
    if ($delete) {
        $notification = array(
            'message' => 'Yeay, Rubrik 18 Mendapat Hibah PKM berhasil dihapus',
            'alert-type' => 'success'
        );
        return redirect()->route('r_018_mendapat_hibah_pkm')->with($notification);
    }else {
        $notification = array(
            'message' => 'Ooopps, Rubrik 18 Mendapat Hibah PKM gagal dihapus',
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
