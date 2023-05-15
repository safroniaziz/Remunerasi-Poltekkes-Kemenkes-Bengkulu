<?php

namespace App\Http\Controllers;

use App\Models\R05MembimbingPraktikPkkPblKlinik;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R05MembimbingPraktikPkkPblKlinikController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::select('nip','nama')->whereNotIn('nip',function($query) use ($pegawai) {
            $query->select('nip')->from('r01_perkuliahan_teoris')->where('nip',$pegawai->nip);
         })->get();
         $r05membimbingpraktikpkkpblkliniks = R05MembimbingPraktikPkkPblKlinik::orderBy('created_at','desc')->get();
         $periodes = Periode::where('is_active','1')->get();

         return view('backend/rubriks/r_05_membimbing_praktik_pkk_pbl_kliniks.index',[
            'pegawais'               =>  $pegawais,
            'periodes'               =>  $periodes,
            'r05membimbingpraktikpkkpblkliniks'    =>  $r05membimbingpraktikpkkpblkliniks,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'periode_id'            =>  'required',
            'nip'                   =>  'required|numeric',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'periode_id.required'       => 'Periode harus dipilih',
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = R05MembimbingPraktikPkkPblKlinik::create([
            'periode_id'        =>  $request->periode_id,
            'nip'               =>  $request->nip,
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 05 Membimbing Praktik PKK PBL Klinik baru berhasil ditambahkan',
                'url'   =>  url('/r_05_membimbing_praktik_pkk_pbl_klinik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 05 Membimbing Praktik PKK PBL Klinik gagal disimpan']);
        }
    }
    public function edit(R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        return $r05membimbingpraktikpkkpblklinik;
    }

    public function update(Request $request, R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $rules = [
            'periode_id'            =>  'required',
            'nip'                   =>  'required|numeric',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'periode_id.required'       => 'Periode harus dipilih',
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = R05MembimbingPraktikPkkPblKlinik::where('id',$request->r05membimbingpraktikpkkpblklinik_id_edit)->update([
            'periode_id'        =>  $request->periode_id,
            'nip'               =>  $request->nip,
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, R 05 Membimbing Praktik PKK PBL Klinik berhasil diubah',
                'url'   =>  url('/r_05_membimbing_praktik_pkk_pbl_klinik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 05 Membimbing Praktik PKK PBL Klinik anda gagal diubah']);
        }
    }
    public function delete(R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $delete = $r05membimbingpraktikpkkpblklinik->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Membimbing Praktik PKK PBL Klinik remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_05_membimbing_praktik_pkk_pbl_klinik')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Membimbing Praktik PKK PBL Klinik remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function bkdSetNonActive(R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $update = $r05membimbingpraktikpkkpblklinik->update([
            'is_bkd' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_05_membimbing_praktik_pkk_pbl_klinik')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function bkdSetActive(R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $update = $r05membimbingpraktikpkkpblklinik->update([
            'is_bkd' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_05_membimbing_praktik_pkk_pbl_klinik')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
