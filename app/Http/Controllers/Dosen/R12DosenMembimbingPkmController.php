<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R012MembimbingPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R12DosenMembimbingPkmController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r012membimbingpkms = R012MembimbingPkm::where('nip',$_SESSION['data']['kode'])
                                                ->where('periode_id',$this->periode->id)
                                               ->orderBy('created_at','desc')->get();
        return view('backend/dosen/rubriks/r_012_membimbing_pkms.index',[
           'pegawais'                 =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r012membimbingpkms'       =>  $r012membimbingpkms,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|regex:/^[0-9]+$/|min:0',
           'is_bkd'             =>  'required',
       ];
       $text = [
           'tingkat_pkm.required'         => 'tingkat_pkm harus diisi',
           'juara_ke.required'            => 'Tingkat Juara harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Pembimbing harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Pembimbing harus berupa angka',
           'jumlah_pembimbing.min'        => 'Jumlah Pembimbing tidak boleh kurang dari 0',
           'jumlah_pembimbing.regex'      => 'Format Pembimbing tidak valid',
           'is_bkd.required'              => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->tingkat_pkm == "internasional") {
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 2;
            }else{
                $ewmp = 1;
            }
        }else{
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 1;
            }else{
                $ewmp = 0.5;
            }
        }
        $point = $ewmp/$request->jumlah_pembimbing;
       $simpan = R012MembimbingPkm::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'tingkat_pkm'       =>  $request->tingkat_pkm,
        'juara_ke'          =>  $request->juara_ke,
        'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 12 Membimbing PKM baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_012_membimbing_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 12 Membimbing PKM gagal disimpan']);
       }
   }
   public function edit($r012membimbingpkm){
    return R012MembimbingPkm::where('id',$r012membimbingpkm)->first();
   }

   public function update(Request $request, R012MembimbingPkm $r012membimbingpkm){
       $rules = [
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|regex:/^[0-9]+$/|min:0',
           'is_bkd'             =>  'required',
       ];
       $text = [
           'tingkat_pkm.required'         => 'Tingkat PKM harus diisi',
           'juara_ke.required'            => 'Tingkat Juara harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Pembimbing harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Pembimbing harus berupa angka',
           'jumlah_pembimbing.min'        => 'Jumlah Pembimbing tidak boleh kurang dari 0',
           'jumlah_pembimbing.regex'      => 'Format Pembimbing tidak valid',
           'is_bkd.required'              => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->tingkat_pkm == "internasional") {
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 2;
            }else{
                $ewmp = 1;
            }
        }else{
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 1;
            }else{
                $ewmp = 0.5;
            }
        }
        $point = $ewmp/$request->jumlah_pembimbing;
        $update = R012MembimbingPkm::where('id',$request->r012membimbingpkm_id_edit)->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'tingkat_pkm'       =>  $request->tingkat_pkm,
            'juara_ke'          =>  $request->juara_ke,
            'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 12 Membimbing PKM berhasil diubah',
               'url'   =>  url('/dosen/r_012_membimbing_pkm/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Membimbing PKM anda gagal diubah']);
       }
   }
   public function delete($r012membimbingpkm){
    $delete = R012MembimbingPkm::where('id',$r012membimbingpkm)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Membimbing PKM berhasil dihapus',
            'url'   =>  route('dosen.r_012_membimbing_pkm'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Membimbing PKM remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R012MembimbingPkm $r012membimbingpkm){
        $r012membimbingpkm->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R012MembimbingPkm $r012membimbingpkm){
        $r012membimbingpkm->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
