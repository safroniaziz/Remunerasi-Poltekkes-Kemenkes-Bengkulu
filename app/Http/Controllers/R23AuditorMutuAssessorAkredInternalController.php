<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class R23AuditorMutuAssessorAkredInternalController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r023auditormutuassessorakredinternals = R023AuditorMutuAssessorAkredInternal::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_022_reviewer_eclere_penelitian_mhs.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $periode,
           'r023auditormutuassessorakredinternals' =>  $r023auditormutuassessorakredinternals,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'nip'                   =>  'required|numeric',
           'judul_protokol_penelitian'          =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul_protokol_penelitian.required'     => 'Jumlah mhs harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R023AuditorMutuAssessorAkredInternal::create([
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
   public function edit(R23AuditorMutuAssessorAkredInternal $r22revieweclerepenelitimhs){
       return $r22revieweclerepenelitimhs;
   }

   public function update(Request $request, R23AuditorMutuAssessorAkredInternal $r22revieweclerepenelitimhs){
       $rules = [
           'nip'                   =>  'required|numeric',
           'judul_protokol_penelitian'          =>  'required',
       ];
       $text = [
           'nip.required'          => 'NIP harus dipilih',
           'nip.numeric'           => 'NIP harus berupa angka',
           'judul_protokol_penelitian.required' => 'Jumlah mhs harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R023AuditorMutuAssessorAkredInternal::where('id',$request->r22revieweclerepenelitimhs_id_edit)->update([
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
   public function delete(R23AuditorMutuAssessorAkredInternal $r22revieweclerepenelitimhs){
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
   public function bkdSetNonActive(R23AuditorMutuAssessorAkredInternal $r023auditormutuassessorakredinternal){
       $update = $r023auditormutuassessorakredinternal->update([
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

   public function bkdSetActive(R23AuditorMutuAssessorAkredInternal $r023auditormutuassessorakredinternal){
       $update = $r023auditormutuassessorakredinternal->update([
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
