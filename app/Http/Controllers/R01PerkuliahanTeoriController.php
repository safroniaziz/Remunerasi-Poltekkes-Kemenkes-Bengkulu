<?php

namespace App\Http\Controllers;

use App\Models\R01PerkuliahanTeori;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R01PerkuliahanTeoriController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r01_perkuliahan_teoris')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r01-perkuliahan-teori')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r01perkuliahanteoris = R01PerkuliahanTeori::orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/rubriks/r_01_perkuliahan_teoris.index',[
            'pegawais'                =>  $pegawais,
            'periode'                 =>  $periode,
            'r01perkuliahanteoris'    =>  $r01perkuliahanteoris,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r01-perkuliahan-teori')) {
            abort(403);
        }
        $rules = [
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'nip.required'              => 'NIP harus dipilih',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $simpan = R01PerkuliahanTeori::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
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
        if (!Gate::allows('edit-r01-perkuliahan-teori')) {
            abort(403);
        }
        return $r01perkuliahanteori;
    }

    public function update(Request $request, R01PerkuliahanTeori $r01perkuliahanteori){
        if (!Gate::allows('update-r01-perkuliahan-teori')) {
            abort(403);
        }
        $rules = [
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'nip.required'              => 'NIP harus dipilih',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $update = R01PerkuliahanTeori::where('id',$request->r01perkuliahanteori_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
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
        if (!Gate::allows('delete-r01-perkuliahan-teori')) {
            abort(403);
        }
        $delete = $r01perkuliahanteori->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, r01perkuliahanteori remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_01_perkuliahan_teori')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, r01perkuliahanteori remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function bkdSetNonActive(R01PerkuliahanTeori $r01perkuliahanteori){
        $update = $r01perkuliahanteori->update([
            'is_bkd' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_01_perkuliahan_teori')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function bkdSetActive(R01PerkuliahanTeori $r01perkuliahanteori){
        $update = $r01perkuliahanteori->update([
            'is_bkd' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_01_perkuliahan_teori')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R01PerkuliahanTeori $r01perkuliahanteori){
        $r01perkuliahanteori->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R01PerkuliahanTeori $r01perkuliahanteori){
        $r01perkuliahanteori->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
