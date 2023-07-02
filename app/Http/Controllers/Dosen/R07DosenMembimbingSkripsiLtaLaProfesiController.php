<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R07MembimbingSkripsiLtaLaProfesi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R07DosenMembimbingSkripsiLtaLaProfesiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
         $pegawais = Pegawai::all();
         $r07membimbingskripsiltalaprofesis = R07MembimbingSkripsiLtaLaProfesi::where('nip',$_SESSION['data']['kode'])
                                                                            ->orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/dosen/rubriks/r_07_membimbing_skripsi_lta_la_profesis.index',[
            'pegawais'                             =>  $pegawais,
            'periode'                              =>  $periode,
            'r07membimbingskripsiltalaprofesis'    =>  $r07membimbingskripsiltalaprofesis,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'pembimbing_ke'         =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'pembimbing_ke.required'    => 'Pembimbing harus dipilih',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->pembimbing_ke == "pembimbing_utama") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $simpan = R07MembimbingSkripsiLtaLaProfesi::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'pembimbing_ke'     =>  $request->pembimbing_ke,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 07 Membimbing Skirpsi LTA LA Profesi baru berhasil ditambahkan',
                'url'   =>  url('/r_07_membimbing_skripsi_lta_la_profesi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 07 Membimbing Skirpsi LTA LA Profesi gagal disimpan']);
        }
    }
    public function edit(R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        return $r07membimbingskripsiltalaprofesi;
    }

    public function update(Request $request, R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'pembimbing_ke'         =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'pembimbing_ke.required'    => 'Pembimbing harus dipilih',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->pembimbing_ke == "pembimbing_utama") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $update = R07MembimbingSkripsiLtaLaProfesi::where('id',$request->r07membimbingskripsiltalaprofesi_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'pembimbing_ke'     =>  $request->pembimbing_ke,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, R 07 Membimbing Skirpsi LTA LA Profesi berhasil diubah',
                'url'   =>  url('/r_07_membimbing_skripsi_lta_la_profesi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 07 Membimbing Skirpsi LTA LA Profesi anda gagal diubah']);
        }
    }
    public function delete(R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        $delete = $r07membimbingskripsiltalaprofesi->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, R07MembimbingSkripsiLtaLaProfesi remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_07_membimbing_skripsi_lta_la_profesi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, R07MembimbingSkripsiLtaLaProfesi remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        $r07membimbingskripsiltalaprofesi->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        $r07membimbingskripsiltalaprofesi->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}