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
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r025kepanitiaankegiataninstitusis = R025KepanitiaanKegiatanInstitusi::where('nip',$_SESSION['data']['kode'])
                                                                            ->where('periode_id',$this->periode->id)
                                                                             ->orderBy('created_at','desc')->get();
        

        return view('backend/dosen/rubriks/r_025_kepanitiaan_kegiatan_institusis.index',[
           'pegawais'                              =>  $pegawais,
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
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       
        if ($request->jabatan == "ketua" || $request->jabatan == "wakil") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $simpan = R025KepanitiaanKegiatanInstitusi::create([
           'periode_id'        =>  $this->periode->id,
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
               'url'   =>  url('/dosen/r_025_kepanitiaan_kegiatan_institusi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 25 Kepanitiaan Kegiatan Institusi gagal disimpan']);
       }
   }
   public function edit($r25panitiakegiataninstitusi){
    return R025KepanitiaanKegiatanInstitusi::where('id',$r25panitiakegiataninstitusi)->first();
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
           'is_bkd.required'         => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       
        if ($request->jabatan == "ketua" || $request->jabatan == "wakil") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;
       $update = R025KepanitiaanKegiatanInstitusi::where('id',$request->r25panitiakegiataninstitusi_id_edit)->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Kepanitiaan Kegiatan Institusi diubah',
               'url'   =>  url('/dosen/r_025_kepanitiaan_kegiatan_institusi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Kepanitiaan Kegiatan Institusi gagal diubah']);
       }
   }
   public function delete($r25panitiakegiataninstitusi){
    $delete = R025KepanitiaanKegiatanInstitusi::where('id',$r25panitiakegiataninstitusi)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Kepanitiaan Kegiatan Institusi dihapus',
            'url'   =>  route('dosen.r_025_kepanitiaan_kegiatan_institusi'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Kepanitiaan Kegiatan Institusi remunerasi gagal dihapus',
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
