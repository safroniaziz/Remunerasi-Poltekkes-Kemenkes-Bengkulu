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
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r023_auditor_mutu_assessor_akred_internals')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r023auditormutuassessorakredinternals = R023AuditorMutuAssessorAkredInternal::where('nip',$_SESSION['data']['kode'])
                                                                                     ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_023_auditor_mutu_assessor_akred_internals.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
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
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R023AuditorMutuAssessorAkredInternal::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal baru berhasil ditambahkan',
               'url'   =>  url('/r_023_auditor_mutu_assessor_akred_internal/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal gagal disimpan']);
       }
   }
   public function edit(R023AuditorMutuAssessorAkredInternal $r23auditmutuasesorakredinternal){
       return $r23auditmutuasesorakredinternal;
   }

   public function update(Request $request, R023AuditorMutuAssessorAkredInternal $r23auditmutuasesorakredinternal){
       $rules = [
           'judul_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'is_bkd.required'         => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $update = R023AuditorMutuAssessorAkredInternal::where('id',$request->r23auditmutuasesorakredinternal_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal diubah',
               'url'   =>  url('/r_023_auditor_mutu_assessor_akred_internal/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal gagal diubah']);
       }
   }
   public function delete(R023AuditorMutuAssessorAkredInternal $r23auditmutuasesorakredinternal){
       $delete = $r23auditmutuasesorakredinternal->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_023_auditor_mutu_assessor_akred_internal')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 23 Auditor Mutu Assessor Akreditasi Internal remunerasi gagal dihapus',
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