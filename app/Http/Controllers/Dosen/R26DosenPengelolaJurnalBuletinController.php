<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R026PengelolaJurnalBuletin;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R26DosenPengelolaJurnalBuletinController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r026pengelolajurnalbuletins = R026PengelolaJurnalBuletin::where('nip',$_SESSION['data']['kode'])
                                                                 ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_026_pengelola_jurnal_buletins.index',[
           'pegawais'                        =>  $pegawais,
           'periode'                         =>  $periode,
           'r026pengelolajurnalbuletins'     =>  $r026pengelolajurnalbuletins,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'edisi_terbit'            =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jabatan.required'          => 'Jabatan harus diisi',
           'edisi_terbit.required'     => 'Edisi Terbit harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $simpan = R026PengelolaJurnalBuletin::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'jabatan'           =>  $request->jabatan,
           'edisi_terbit'      =>  $request->edisi_terbit,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 26 Pengelola Jurnal Buletin baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_026_pengelola_jurnal_buletin/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 26 Pengelola Jurnal Buletin gagal disimpan']);
       }
   }
   public function edit($r26pengelolajurnalbuletin){
    return R026PengelolaJurnalBuletin::where('id',$r26pengelolajurnalbuletin)->first();
   }

   public function update(Request $request, R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'edisi_terbit'            =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'jabatan.required'        => 'Jabatan harus diisi',
           'edisi_terbit.required'   => 'Edisi Terbit harus diisi',
           'is_bkd.required'         => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $update = R026PengelolaJurnalBuletin::where('id',$request->r26pengelolajurnalbuletin_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'jabatan'                    =>  $request->jabatan,
           'edisi_terbit'               =>  $request->edisi_terbit,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Pengelola Jurnal Buletin diubah',
               'url'   =>  url('/dosen/r_026_pengelola_jurnal_buletin/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Pengelola Jurnal Buletin gagal diubah']);
       }
   }

   public function delete($r26pengelolajurnalbuletin){
    $delete = R026PengelolaJurnalBuletin::where('id',$r26pengelolajurnalbuletin)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Pengelola Jurnal Buletin dihapus',
            'url'   =>  route('dosen.r_026_pengelola_jurnal_buletin'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Pengelola Jurnal Buletin remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
        $r26pengelolajurnalbuletin->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
        $r26pengelolajurnalbuletin->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
