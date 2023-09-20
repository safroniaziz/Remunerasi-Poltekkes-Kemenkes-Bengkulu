<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\R07MembimbingSkripsiLtaLaProfesi;

class R07DosenMembimbingSkripsiLtaLaProfesiController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    
    public function index(){
         $pegawais = Pegawai::all();
         $r07membimbingskripsiltalaprofesis = R07MembimbingSkripsiLtaLaProfesi::where('nip',$_SESSION['data']['kode'])
                                                                            ->where('periode_id',$this->periode->id)
                                                                            ->orderBy('created_at','desc')->get();
         return view('backend/dosen/rubriks/r_07_membimbing_skripsi_lta_la_profesis.index',[
            'pegawais'                             =>  $pegawais,
            'r07membimbingskripsiltalaprofesis'    =>  $r07membimbingskripsiltalaprofesis,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'pembimbing_ke'         =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'pembimbing_ke.required'    => 'Pembimbing harus dipilih',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->pembimbing_ke == "pembimbing_utama") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $simpan = R07MembimbingSkripsiLtaLaProfesi::create([
            'periode_id'        =>  $this->periode->id,
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
                'url'   =>  url('/dosen/r_07_membimbing_skripsi_lta_la_profesi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 07 Membimbing Skirpsi LTA LA Profesi gagal disimpan']);
        }
    }
    public function edit($r07membimbingskripsiltalaprofesi){
        return R07MembimbingSkripsiLtaLaProfesi::where('id',$r07membimbingskripsiltalaprofesi)->first();
    }

    public function update(Request $request, R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'pembimbing_ke'         =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'pembimbing_ke.required'    => 'Pembimbing harus dipilih',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->pembimbing_ke == "pembimbing_utama") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $update = R07MembimbingSkripsiLtaLaProfesi::where('id',$request->r07membimbingskripsiltalaprofesi_id_edit)->update([
            'periode_id'        =>  $this->periode->id,
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
                'url'   =>  url('/dosen/r_07_membimbing_skripsi_lta_la_profesi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 07 Membimbing Skirpsi LTA LA Profesi anda gagal diubah']);
        }
    }
    public function delete($r07membimbingskripsiltalaprofesi){
        $delete = R07MembimbingSkripsiLtaLaProfesi::where('id',$r07membimbingskripsiltalaprofesi)->delete();
        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, R 07 Membimbing Skirpsi LTA LA Profesi berhasil dihapus',
                'url'   =>  route('dosen.r_07_membimbing_skripsi_lta_la_profesi'),
            ]);
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
