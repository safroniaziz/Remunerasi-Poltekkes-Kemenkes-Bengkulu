<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R014KaryaInovasi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R14DosenKaryaInovasiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r014karyainovasis = R014KaryaInovasi::where('nip',$_SESSION['data']['kode'])
                                             ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_014_karya_inovasis.index',[
           'pegawais'                =>  $pegawais,
           'periode'                 =>  $periode,
           'r014karyainovasis'       =>  $r014karyainovasis,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|regex:/^[0-9]+$/|min:0',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jumlah_penulis.min'        => 'Jumlah Penulis tidak boleh kurang dari 0',
           'jumlah_penulis.regex'      => 'Format Penulis tidak valid',
           'jenis.required'            => 'Jumlah Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis == "menghasilkan_pendapatan_blu") {
            $ewmp = 5.00;
        }elseif ($request->jenis == "paten_yang_belum_dikonversi") {
            $ewmp = 4.00;
        }elseif ($request->jenis == "paten_sederhana") {
            $ewmp = 4.00;
        }else{
            $ewmp = 1.00;
        }
        if ($request->penulis_ke == "penulis_ke") {
            $point = (60/100)*$ewmp;
        }else {
            $point = ((40/100)*$ewmp)/$request->jumlah_penulis;
        }
       $simpan = R014KaryaInovasi::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 14 Karya Inovasi baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_014_karya_inovasi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 14 Karya Inovasi gagal disimpan']);
       }
   }
   public function edit($r014karyainovasi){
    return R014KaryaInovasi::where('id',$r014karyainovasi)->first();
   }

   public function update(Request $request, R014KaryaInovasi $r014karyainovasi){
       $rules = [
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|regex:/^[0-9]+$/|min:0',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jumlah_penulis.min'        => 'Jumlah Penulis tidak boleh kurang dari 0',
           'jumlah_penulis.regex'      => 'Format Penulis tidak valid',
           'jenis.required'            => 'Jumlah Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis == "menghasilkan_pendapatan_blu") {
            $ewmp = 5.00;
        }elseif ($request->jenis == "paten_yang_belum_dikonversi") {
            $ewmp = 4.00;
        }elseif ($request->jenis == "paten_sederhana") {
            $ewmp = 4.00;
        }else{
            $ewmp = 1.00;
        }
        if ($request->penulis_ke == "penulis_utama") {
            $point = (60/100)*$ewmp;
        }else {
            $point = ((40/100)*$ewmp)/$request->jumlah_penulis;
        }
       $update = R014KaryaInovasi::where('id',$request->r014karyainovasi_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Karya Inovasi berhasil diubah',
               'url'   =>  url('/dosen/r_014_karya_inovasi/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Karya Inovasi anda gagal diubah']);
       }
   }
   public function delete($r014karyainovasi){
    $delete = R014KaryaInovasi::where('id',$r014karyainovasi)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Karya Inovasi berhasil dihapus',
            'url'   =>  route('dosen.r_014_karya_inovasi'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Karya Inovasi remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R014KaryaInovasi $r014karyainovasi){
        $r014karyainovasi->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R014KaryaInovasi $r014karyainovasi){
        $r014karyainovasi->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
