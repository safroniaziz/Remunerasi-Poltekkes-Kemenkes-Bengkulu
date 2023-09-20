<?php

namespace App\Http\Controllers;

use App\Models\R023AuditorMutuAssessorAkredInternal;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R23AuditorMutuAssessorAkredInternalController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r023_auditor_mutu_assessor_akred_internals')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r023-auditor-mutu-assessor-akred-internal')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r023auditormutuassessorakredinternals = R023AuditorMutuAssessorAkredInternal::where('nip',$request->session()->get('nip_dosen'))
                                                                                    ->where('periode_id',$this->periode->id)
                                                                                    ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_023_auditor_mutu_assessor_akred_internals.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $this->periode->id,
           'r023auditormutuassessorakredinternals' =>  $r023auditormutuassessorakredinternals,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r023-auditor-mutu-assessor-akred-internal')) {
        abort(403);
    }
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
           'nip'               =>  $request->session()->get('nip_dosen'),
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
    if (!Gate::allows('edit-r023-auditor-mutu-assessor-akred-internal')) {
        abort(403);
    }
       return $r23auditmutuasesorakredinternal;
   }

   public function update(Request $request, R023AuditorMutuAssessorAkredInternal $r23auditmutuasesorakredinternal){
    if (!Gate::allows('update-r023-auditor-mutu-assessor-akred-internal')) {
        abort(403);
    }
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
           'nip'                        =>  $request->session()->get('nip_dosen'),
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
    if (!Gate::allows('delete-r023-auditor-mutu-assessor-akred-internal')) {
        abort(403);
    }
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
