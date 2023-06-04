<?php

namespace App\Http\Controllers;

use App\Models\R02PerkuliahanPraktikum;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;


class R02PerkuliahanPraktikumController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r02_perkuliahan_praktikums')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r02-perkuliahan-praktikum')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r02perkuliahanpraktikums = r02perkuliahanpraktikum::where('nip',$request->session()->get('nip_dosen'))
                                                            ->orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/rubriks/r_02_perkuliahan_praktikums.index',[
            'pegawais'                    =>  $pegawais,
            'periode'                     =>  $periode,
            'r02perkuliahanpraktikums'    =>  $r02perkuliahanpraktikums,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r02-perkuliahan-praktikum')) {
            abort(403);
        }
        $rules = [
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
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

        $simpan = R02PerkuliahanPraktikum::create([
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
                'text'  =>  'Yeay, R 02 Perkuliahan Praktikum baru berhasil ditambahkan',
                'url'   =>  url('/r_02_perkuliahan_praktikum/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 02 Perkuliahan Praktikum gagal disimpan']);
        }
    }
    public function edit(R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        if (!Gate::allows('edit-r02-perkuliahan-praktikum')) {
            abort(403);
        }
        return $r02perkuliahanpraktikum;
    }

    public function update(Request $request, R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        if (!Gate::allows('update-r02-perkuliahan-praktikum')) {
            abort(403);
        }
        $rules = [
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
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

        $update = R02PerkuliahanPraktikum::where('id',$request->r02perkuliahanpraktikum_id_edit)->update([
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
                'text'  =>  'Yeay, R 02 Perkuliahan Praktikum berhasil diubah',
                'url'   =>  url('/r_02_perkuliahan_praktikum/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 02 Perkuliahan Praktikum anda gagal diubah']);
        }
    }
    public function delete(R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        if (!Gate::allows('delete-r02-perkuliahan-praktikum')) {
            abort(403);
        }
        $delete = $r02perkuliahanpraktikum->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, r02perkuliahanPraktikum remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_02_perkuliahan_praktikum')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, r02perkuliahanPraktikum remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        $r02perkuliahanpraktikum->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        $r02perkuliahanpraktikum->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
