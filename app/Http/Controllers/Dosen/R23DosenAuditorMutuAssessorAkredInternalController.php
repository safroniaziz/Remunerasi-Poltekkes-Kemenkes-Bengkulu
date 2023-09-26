<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R023AuditorMutuAssessorAkredInternal;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R23DosenAuditorMutuAssessorAkredInternalController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r023_auditor_mutu_assessor_akred_internals')->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r023auditormutuassessorakredinternals = R023AuditorMutuAssessorAkredInternal::where('nip',$_SESSION['data']['kode'])
                                                                                    ->where('periode_id',$this->periode->id)
                                                                                     ->orderBy('created_at','desc')->get();


        return view('backend/dosen/rubriks/r_023_auditor_mutu_assessor_akred_internals.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r023auditormutuassessorakredinternals' =>  $r023auditormutuassessorakredinternals,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_kegiatan'   =>  'required',
           'is_bkd'           =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }


       $point = $this->nilai_ewmp->ewmp;

       $simpan = R023AuditorMutuAssessorAkredInternal::create([
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
               'text'  =>  'Yeay, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_023_auditor_mutu_assessor_akred_internal/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal gagal disimpan']);
       }
   }
   public function edit($r23auditmutuasesorakredinternal){
    return R023AuditorMutuAssessorAkredInternal::where('id',$r23auditmutuasesorakredinternal)->first();
   }

   public function update(Request $request, R023AuditorMutuAssessorAkredInternal $r23auditmutuasesorakredinternal){
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

       $update = R023AuditorMutuAssessorAkredInternal::where('id',$request->r23auditmutuasesorakredinternal_id_edit)->update([
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
               'text'  =>  'Yeay, Rubrik Auditor Mutu Assessor Akreditasi Internal diubah',
               'url'   =>  url('/dosen/r_023_auditor_mutu_assessor_akred_internal/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Auditor Mutu Assessor Akreditasi Internal gagal diubah']);
       }
   }
   public function delete($r23auditmutuasesorakredinternal){
    $delete = R023AuditorMutuAssessorAkredInternal::where('id',$r23auditmutuasesorakredinternal)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Auditor Mutu Assessor Akreditasi Internal dihapus',
            'url'   =>  route('dosen.r_023_auditor_mutu_assessor_akred_internal'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Auditor Mutu Assessor Akreditasi Internal remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R023AuditorMutuAssessorAkredInternal $r23auditmutuasesorakredinternal){
        $r23auditmutuasesorakredinternal->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R023AuditorMutuAssessorAkredInternal $r23auditmutuasesorakredinternal){
        $r23auditmutuasesorakredinternal->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
