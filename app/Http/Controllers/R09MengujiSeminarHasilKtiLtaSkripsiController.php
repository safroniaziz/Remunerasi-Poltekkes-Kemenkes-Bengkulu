<?php

namespace App\Http\Controllers;

use App\Models\R09MengujiSeminarHasilKtiLtaSkripsi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R09MengujiSeminarHasilKtiLtaSkripsiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r09-menguji-seminar-hasil-kti-lta-skripsi')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r09mengujiseminarhasilktiltaskripsis = R09MengujiSeminarHasilKtiLtaSkripsi::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_09_menguji_seminar_hasil_kti_lta_skripsis.index',[
           'pegawais'                                   =>  $pegawais,
           'periode'                                    =>  $periode,
           'r09mengujiseminarhasilktiltaskripsis'       =>  $r09mengujiseminarhasilktiltaskripsis,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r09-menguji-seminar-hasil-kti-lta-skripsi')) {
        abort(403);
    }
       $rules = [
           'nip'                   =>  'required|numeric',
           'jumlah_mahasiswa'      =>  'required|numeric',
           'jenis'                 =>  'required',

       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
           'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
           'jenis.required'            => 'Jenis Seminar harus dipilih',

       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R09MengujiSeminarHasilKtiLtaSkripsi::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->nip,
           'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
           'jenis'             =>  $request->jenis,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, R 09 Menguji Seminar hasil Kti Lta Skripsi baru berhasil ditambahkan',
               'url'   =>  url('/r_09_menguji_seminar_hasil_kti_lta_skripsi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, R 09 Menguji Seminar hasil Kti Lta Skripsi gagal disimpan']);
       }
   }
   public function edit(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
    if (!Gate::allows('edit-r09-menguji-seminar-hasil-kti-lta-skripsi')) {
        abort(403);
    }
    return $r09mengujiseminarhasil;
   }

   public function update(Request $request, R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
    if (!Gate::allows('update-r09-menguji-seminar-hasil-kti-lta-skripsi')) {
        abort(403);
    }
       $rules = [
           'nip'                   =>  'required|numeric',
           'jumlah_mahasiswa'      =>  'required|numeric',
           'jenis'                 =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
           'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
           'jenis.required'            => 'Jenis Seminar harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R09MengujiSeminarHasilKtiLtaSkripsi::where('id',$request->r09mengujiseminarhasil_id_edit)->update([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->nip,
           'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
           'jenis'             =>  $request->jenis,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, R 09 Menguji Seminar hasil Kti Lta Skripsi berhasil diubah',
               'url'   =>  url('/r_09_menguji_seminar_hasil_kti_lta_skripsi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, R 09 Menguji Seminar hasil Kti Lta Skripsi anda gagal diubah']);
       }
   }
   public function delete(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
    if (!Gate::allows('delete-r09-menguji-seminar-hasil-kti-lta-skripsi')) {
        abort(403);
    }
    $delete = $r09mengujiseminarhasil->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, R09 Menguji Seminar hasil Kti Lta Skripsi remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_09_menguji_seminar_hasil_kti_lta_skripsi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, R09 Menguji Seminar hasil Kti Lta Skripsi remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasilktiltaskripsi){
       $update = $r09mengujiseminarhasilktiltaskripsi->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_09_menguji_seminar_hasil_kti_lta_skripsi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasilktiltaskripsi){
       $update = $r09mengujiseminarhasilktiltaskripsi->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_09_menguji_seminar_hasil_kti_lta_skripsi')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
