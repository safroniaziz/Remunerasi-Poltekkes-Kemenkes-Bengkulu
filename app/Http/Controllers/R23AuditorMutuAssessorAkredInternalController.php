<?php

namespace App\Http\Controllers;

use App\Models\R023AuditorMutuAssessorAkredInternal;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R23AuditorMutuAssessorAkredInternalController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r023auditormutuassessorakredinternals = R023AuditorMutuAssessorAkredInternal::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_023_auditor_mutu_assessor_akred_internals.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
           'r023auditormutuassessorakredinternals' =>  $r023auditormutuassessorakredinternals,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'                   =>  'required|numeric',
           'judul_kegiatan'          =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_kegiatan.required'     => 'Judul Kegiatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R023AuditorMutuAssessorAkredInternal::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->nip,
           'judul_kegiatan'      =>  $request->judul_kegiatan,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  null,
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
           'nip'                     =>  'required|numeric',
           'judul_kegiatan'          =>  'required',
       ];
       $text = [
           'nip.required'            => 'NIP harus dipilih',
           'nip.numeric'             => 'NIP harus berupa angka',
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R023AuditorMutuAssessorAkredInternal::where('id',$request->r23auditmutuasesorakredinternal_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->nip,
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  null,
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
   public function bkdSetNonActive(R023AuditorMutuAssessorAkredInternal $r023auditormutuassessorakredinternal){
       $update = $r023auditormutuassessorakredinternal->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_023_auditor_mutu_assessor_akred_internal')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R023AuditorMutuAssessorAkredInternal $r023auditormutuassessorakredinternal){
       $update = $r023auditormutuassessorakredinternal->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_023_auditor_mutu_assessor_akred_internal')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}