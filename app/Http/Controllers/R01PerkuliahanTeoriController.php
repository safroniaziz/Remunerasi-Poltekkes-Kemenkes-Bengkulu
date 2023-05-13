<?php

namespace App\Http\Controllers;

use App\Models\R01PerkuliahanTeori;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R01PerkuliahanTeoriController extends Controller
{
    public function index(Request $request){
        $r01perkuliahanteoris = R01PerkuliahanTeori::orderBy('created_at','desc')->get();
        return view('backend/rubriks/r_01_perkuliahan_teoris.index',[
            'r01perkuliahanteoris'         =>  $r01perkuliahanteoris,
        ]);
    }

    // public function create(){
    //     $dosens = Pegawai::all();
    //     $periodes = Periode::all();
    //     return view('backend/rubriks/r_01_perkuliahan_teoris.create',compact('dosens','periodes'));
    // }

    public function store(Request $request){
        $rules = [
            'rubrik_id'             =>  'required',
            'periode_id'            =>  'required',
            'nip'                   =>  'required|numeric',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
            'is_verified'           =>  'required',
            'point'                 =>  'required',
        ];
        $text = [
            'rubrik_id.required'        => 'Rubrik harus dipilih',
            'periode_id.required'       => 'Periode harus dipilih',
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'id_bkd.required'           => 'BKD harus dipilih',
            'id_verified.required'      => 'Verifikasi harus dipilih',
            'point.required'            => 'Point harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = R01PerkuliahanTeori::create([
            'rubrik_id'         =>  $request->rubrik_id,
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
                'text'  =>  'Yeay, R 01 Perkuliahan Teori baru berhasil ditambahkan',
                'url'   =>  url('/r_01_perkuliahan_teori/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 01 Perkuliahan Teori gagal disimpan']);
        }
    }
    public function edit(R01PerkuliahanTeori $r01perkuliahanteori){
        $dosens = Pegawai::all();
        $periodes = Periode::all();
        return view('backend.s.edit',compact('dosens','periodes'),[
            'pegawai'   =>  $r01perkuliahanteori,
        ]);
    }

    public function update(Request $request, R01PerkuliahanTeori $r01perkuliahanteori){
        $rules = [
            'rubrik_id'             =>  'required',
            'periode_id'            =>  'required',
            'nip'                   =>  'required|numeric',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
            'is_verified'           =>  'required',
            'point'                 =>  'required',
        ];
        $text = [
            'rubrik_id.required'        => 'Rubrik harus dipilih',
            'periode_id.required'       => 'Periode harus dipilih',
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'id_bkd.required'           => 'BKD harus dipilih',
            'id_verified.required'      => 'Verifikasi harus dipilih',
            'point.required'            => 'Point harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = R01PerkuliahanTeori::where('id',$request->nip_edit)->update([
            'rubrik_id'         =>  $request->rubrik_id,
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
                'text'  =>  'Yeay, R 01 Perkuliahan Teori berhasil diubah',
                'url'   =>  url('/r_01_perkuliahan_teori/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 01 Perkuliahan Teori anda gagal diubah']);
        }
    }
    public function delete(R01PerkuliahanTeori $r01perkuliahanteori){
        $delete = $r01perkuliahanteori->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, R 01 Perkuliahan Teori remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('pegawai')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, R 01 Perkuliahan Teori remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
