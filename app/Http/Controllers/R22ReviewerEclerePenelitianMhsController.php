<?php

namespace App\Http\Controllers;

use App\Models\R022ReviewerEclerePenelitianMhs;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R22ReviewerEclerePenelitianMhsController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r022-reviewer-eclere-penelitian-mhs')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r022reviewereclerepenelitianmhs = R022ReviewerEclerePenelitianMhs::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_022_reviewer_eclere_penelitian_mhs.index',[
           'pegawais'                           =>  $pegawais,
           'periode'                            =>  $periode,
           'r022reviewereclerepenelitianmhs'    =>  $r022reviewereclerepenelitianmhs,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
       $rules = [
           'nip'                        =>  'required|numeric',
           'judul_protokol_penelitian'  =>  'required',
       ];
       $text = [
           'nip.required'                       => 'NIP harus dipilih',
           'nip.numeric'                        => 'NIP harus berupa angka',
           'judul_protokol_penelitian.required' => 'Judul Protokol Penelitian harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R022ReviewerEclerePenelitianMhs::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->nip,
           'judul_protokol_penelitian'      =>  $request->judul_protokol_penelitian,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 22 Reviewer Eclere Penelitian mhs baru berhasil ditambahkan',
               'url'   =>  url('/r_022_reviewer_eclere_penelitian_mhs/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 22 Reviewer Eclere Penelitian mhs gagal disimpan']);
       }
   }
   public function edit(R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
    if (!Gate::allows('edit-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
       return $r22revieweclerepenelitimhs;
   }

   public function update(Request $request, R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
    if (!Gate::allows('update-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
       $rules = [
           'nip'                        =>  'required|numeric',
           'judul_protokol_penelitian'  =>  'required',
       ];
       $text = [
           'nip.required'                       => 'NIP harus dipilih',
           'nip.numeric'                        => 'NIP harus berupa angka',
           'judul_protokol_penelitian.required' => 'Judul Protokol Penelitian harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R022ReviewerEclerePenelitianMhs::where('id',$request->r22revieweclerepenelitimhs_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->nip,
           'judul_protokol_penelitian'  =>  $request->judul_protokol_penelitian,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 22 Reviewer Eclere Penelitian mhs diubah',
               'url'   =>  url('/r_022_reviewer_eclere_penelitian_mhs/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 22 Reviewer Eclere Penelitian mhs gagal diubah']);
       }
   }
   public function delete(R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
    if (!Gate::allows('delete-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
       $delete = $r22revieweclerepenelitimhs->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 22 Reviewer Eclere Penelitian mhs remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_022_reviewer_eclere_penelitian_mhs')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 22 Reviewer Eclere Penelitian mhs remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R022ReviewerEclerePenelitianMhs $r022reviewereclerepenelitianmhs){
       $update = $r022reviewereclerepenelitianmhs->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_022_reviewer_eclere_penelitian_mhs')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R022ReviewerEclerePenelitianMhs $r022reviewereclerepenelitianmhs){
       $update = $r022reviewereclerepenelitianmhs->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_022_reviewer_eclere_penelitian_mhs')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
