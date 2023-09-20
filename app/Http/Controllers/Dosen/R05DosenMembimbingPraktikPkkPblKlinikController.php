<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R05MembimbingPraktikPkkPblKlinik;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class R05DosenMembimbingPraktikPkkPblKlinikController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r05_membimbing_praktik_pkk_pbl_kliniks')->first();
    }

    public function index(){
         $pegawais = Pegawai::all();
         $r05membimbingpraktikpkkpblkliniks = R05MembimbingPraktikPkkPblKlinik::where('nip',$_SESSION['data']['kode'])
                                                                                ->where('periode_id',$this->periode->id)
                                                                              ->orderBy('created_at','desc')->get();

         return view('backend/dosen/rubriks/r_05_membimbing_praktik_pkk_pbl_kliniks.index',[
            'pegawais'                             =>  $pegawais,
            'r05membimbingpraktikpkkpblkliniks'    =>  $r05membimbingpraktikpkkpblkliniks,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'jumlah_sks'            =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_tatap_muka'     =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_sks.min'            => 'Jumlah SKS tidak boleh kurang dari 0',
            'jumlah_sks.regex'          => 'Format SKS tidak valid',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'jumlah_tatap_muka.min'     => 'Jumlah Tatap Muka tidak boleh kurang dari 0',
            'jumlah_tatap_muka.regex'   => 'Format Tatap Muka tidak valid',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/6)*($request->jumlah_mahasiswa/12))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $simpan = R05MembimbingPraktikPkkPblKlinik::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 05 Membimbing Praktik PKK PBL Klinik baru berhasil ditambahkan',
                'url'   =>  url('/dosen/r_05_membimbing_praktik_pkk_pbl_klinik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 05 Membimbing Praktik PKK PBL Klinik gagal disimpan']);
        }
    }
    public function edit($r05membimbingpraktikpkkpblklinik){
        return R05MembimbingPraktikPkkPblKlinik::where('id',$r05membimbingpraktikpkkpblklinik)->first();
    }

    public function update(Request $request, R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $rules = [
            'jumlah_sks'            =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_tatap_muka'     =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_sks.min'            => 'Jumlah SKS tidak boleh kurang dari 0',
            'jumlah_sks.regex'          => 'Format SKS tidak valid',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'jumlah_tatap_muka.min'     => 'Jumlah Tatap Muka tidak boleh kurang dari 0',
            'jumlah_tatap_muka.regex'   => 'Format Tatap Muka tidak valid',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/6)*($request->jumlah_mahasiswa/12))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $update = R05MembimbingPraktikPkkPblKlinik::where('id',$request->r05membimbingpraktikpkkpblklinik_id_edit)->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Membimbing Praktik PKK PBL Klinik berhasil diubah',
                'url'   =>  url('/dosen/r_05_membimbing_praktik_pkk_pbl_klinik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 05 Membimbing Praktik PKK PBL Klinik anda gagal diubah']);
        }
    }
    public function delete($r05membimbingpraktikpkkpblklinik){
        $delete = R05MembimbingPraktikPkkPblKlinik::where('id',$r05membimbingpraktikpkkpblklinik)->delete();
        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Membimbing Praktik PKK PBL Klinik berhasil dihapus',
                'url'   =>  route('dosen.r_05_membimbing_praktik_pkk_pbl_klinik'),
            ]);
        }else {
            $notification = array(
                'message' => 'Ooopps, Membimbing Praktik PKK PBL Klinik remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $r05membimbingpraktikpkkpblklinik->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $r05membimbingpraktikpkkpblklinik->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
