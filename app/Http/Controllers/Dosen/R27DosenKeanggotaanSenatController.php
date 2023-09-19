<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R027KeanggotaanSenat;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R27DosenKeanggotaanSenatController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r027keanggotaansenats = R027KeanggotaanSenat::where('nip',$_SESSION['data']['kode'])
                                                     ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_027_keanggotaan_senats.index',[
           'pegawais'                  =>  $pegawais,
           'periode'                   =>  $periode,
           'r027keanggotaansenats'     =>  $r027keanggotaansenats,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jabatan'                 =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jabatan.required'          => 'Jabatan harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.75;
        }else{
            $ewmp = 0.50;
        }
        $point = $ewmp;
       $simpan = R027KeanggotaanSenat::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 27 Keanggotaan Senat baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_027_keanggotaan_senat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 27 Keanggotaan Senat gagal disimpan']);
       }
   }
   public function edit($r27keanggotaansenat){
    return R027KeanggotaanSenat::where('id',$r27keanggotaansenat)->first();
   }

   public function update(Request $request, R027KeanggotaanSenat $r27keanggotaansenat){
       $rules = [
           'jabatan'                 =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jabatan.required'        => 'Jabatan harus diisi',
           'is_bkd.required'         => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.75;
        }else{
            $ewmp = 0.50;
        }
        $point = $ewmp;
       $update = R027KeanggotaanSenat::where('id',$request->r27keanggotaansenat_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Keanggotaan Senat diubah',
               'url'   =>  url('/dosen/r_027_keanggotaan_senat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Keanggotaan Senat gagal diubah']);
       }
   }
   public function delete($r27keanggotaansenat){
    $delete = R027KeanggotaanSenat::where('id',$r27keanggotaansenat)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Keanggotaan Senat dihapus',
            'url'   =>  route('dosen.r_027_keanggotaan_senat'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Keanggotaan Senat remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R027KeanggotaanSenat $r27keanggotaansenat){
        $r27keanggotaansenat->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R027KeanggotaanSenat $r27keanggotaansenat){
        $r27keanggotaansenat->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
