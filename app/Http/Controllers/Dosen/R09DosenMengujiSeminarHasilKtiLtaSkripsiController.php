<?php

namespace App\Http\Controllers;

use App\Models\R09MengujiSeminarHasilKtiLtaSkripsi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R09DosenMengujiSeminarHasilKtiLtaSkripsiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r09mengujiseminarhasilktiltaskripsis = R09MengujiSeminarHasilKtiLtaSkripsi::where('nip',$request->session()->get('nip_dosen'))
                                                                                   ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_09_menguji_seminar_hasil_kti_lta_skripsis.index',[
           'pegawais'                                   =>  $pegawais,
           'periode'                                    =>  $periode,
           'r09mengujiseminarhasilktiltaskripsis'       =>  $r09mengujiseminarhasilktiltaskripsis,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jumlah_mahasiswa'      =>  'required|numeric',
           'jenis'                 =>  'required',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
           'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
           'jenis.required'            => 'Jenis Seminar harus dipilih',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];
       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.10;
        }else{
            $ewmp = 0.13;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
       $simpan = R09MengujiSeminarHasilKtiLtaSkripsi::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
           'jenis'             =>  $request->jenis,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
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
    return $r09mengujiseminarhasil;
   }

   public function update(Request $request, R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
       $rules = [
           'jumlah_mahasiswa'      =>  'required|numeric',
           'jenis'                 =>  'required',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
           'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
           'jenis.required'            => 'Jenis Seminar harus dipilih',
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];
       if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.10;
        }else{
            $ewmp = 0.13;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R09MengujiSeminarHasilKtiLtaSkripsi::where('id',$request->r09mengujiseminarhasil_id_edit)->update([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
           'jenis'             =>  $request->jenis,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
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

    public function verifikasi(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
        $r09mengujiseminarhasil->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
        $r09mengujiseminarhasil->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
