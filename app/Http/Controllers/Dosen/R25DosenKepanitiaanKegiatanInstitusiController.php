<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R025KepanitiaanKegiatanInstitusi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R25DosenKepanitiaanKegiatanInstitusiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r025kepanitiaankegiataninstitusis = R025KepanitiaanKegiatanInstitusi::where('nip',$_SESSION['data']['kode'])
                                                                             ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_025_kepanitiaan_kegiatan_institusis.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
           'r025kepanitiaankegiataninstitusis'     =>  $r025kepanitiaankegiataninstitusis,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jabatan.required'          => 'Jabatan harus diisi',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua" || $request->jabatan == "wakil") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $simpan = R025KepanitiaanKegiatanInstitusi::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 25 Kepanitiaan Kegiatan Institusi baru berhasil ditambahkan',
               'url'   =>  url('/r_025_kepanitiaan_kegiatan_institusi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 25 Kepanitiaan Kegiatan Institusi gagal disimpan']);
       }
   }
   public function edit(R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
       return $r25panitiakegiataninstitusi;
   }

   public function update(Request $request, R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'jabatan.required'        => 'Jabatan harus diisi',
           'is_bkd.required'         => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua" || $request->jabatan == "wakil") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $update = R025KepanitiaanKegiatanInstitusi::where('id',$request->r25panitiakegiataninstitusi_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 25 Kepanitiaan Kegiatan Institusi diubah',
               'url'   =>  url('/r_025_kepanitiaan_kegiatan_institusi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 25 Kepanitiaan Kegiatan Institusi gagal diubah']);
       }
   }
   public function delete(R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
       $delete = $r25panitiakegiataninstitusi->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 25 Kepanitiaan Kegiatan Institusi remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_025_kepanitiaan_kegiatan_institusi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 25 Kepanitiaan Kegiatan Institusi remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function verifikasi(R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
        $r25panitiakegiataninstitusi->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R025KepanitiaanKegiatanInstitusi $r25panitiakegiataninstitusi){
        $r25panitiakegiataninstitusi->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
