<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R028MelaksanakanPengembanganDiri;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R28DosenMelaksanakanPengembanganDiriController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r028melaksanakanpengembangandiris = R028MelaksanakanPengembanganDiri::where('nip',$_SESSION['data']['kode'])
                                                                             ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_028_melaksanakan_pengembangan_diris.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
           'r028melaksanakanpengembangandiris'     =>  $r028melaksanakanpengembangandiris,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jenis_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jenis_kegiatan.required'   => 'Jenis Kegiatan harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis_kegiatan == "pelatihan") {
            $ewmp = 1.00;
        }elseif ($request->jenis_kegiatan == "workshop") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.15;
        }
        $point = $ewmp;
       $simpan = R028MelaksanakanPengembanganDiri::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'jenis_kegiatan'    =>  $request->jenis_kegiatan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_028_melaksanakan_pengembangan_diri/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 28 Melaksanakan Pengembangan Diri gagal disimpan']);
       }
   }
   public function edit($r28laksanakanpengembangandiri){
    return R028MelaksanakanPengembanganDiri::where('id',$r28laksanakanpengembangandiri)->first();
   }

   public function update(Request $request, R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
       $rules = [
           'jenis_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jenis_kegiatan.required' => 'Jenis Kegiatan harus diisi',
           'is_bkd.required'         => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis_kegiatan == "pelatihan") {
            $ewmp = 1.00;
        }elseif ($request->jenis_kegiatan == "workshop") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.15;
        }
        $point = $ewmp;
       $update = R028MelaksanakanPengembanganDiri::where('id',$request->r28laksanakanpengembangandiri_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'jenis_kegiatan'             =>  $request->jenis_kegiatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Melaksanakan Pengembangan Diri diubah',
               'url'   =>  url('/dosen/r_028_melaksanakan_pengembangan_diri/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Melaksanakan Pengembangan Diri gagal diubah']);
       }
   }
   public function delete($r28laksanakanpengembangandiri){
    $delete = R028MelaksanakanPengembanganDiri::where('id',$r28laksanakanpengembangandiri)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Melaksanakan Pengembangan Diri dihapus',
            'url'   =>  route('dosen.r_028_melaksanakan_pengembangan_diri'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Melaksanakan Pengembangan Diri remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
        $r28laksanakanpengembangandiri->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
        $r28laksanakanpengembangandiri->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
