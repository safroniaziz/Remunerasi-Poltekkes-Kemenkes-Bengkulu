<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\R01PerkuliahanTeori;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class R01PerkuliahanTeoriController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r01_perkuliahan_teoris')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r01-perkuliahan-teori')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $dataProdis = Prodi::all();
         $r01perkuliahanteoris = R01PerkuliahanTeori::where('nip',$request->session()->get('nip_dosen'))
                                                    ->where('periode_id',$this->periode->id)
                                                    ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_01_perkuliahan_teoris.index',[
            'pegawais'                =>  $pegawais,
            'periode'                 =>  $this->periode->id,
            'r01perkuliahanteoris'    =>  $r01perkuliahanteoris,
            'dataProdis'    =>  $dataProdis,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r01-perkuliahan-teori')) {
            abort(403);
        }
        $rules = [
            'kode_kelas'            =>  'required',
            'nama_matkul'           =>  'required',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'is_bkd'                =>  'required',
            'id_prodi'                =>  'required',
        ];
        $text = [
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'nama_matkul.required'      => 'Nama Matkul harus diisi',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $simpan = R01PerkuliahanTeori::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'kode_kelas'       =>  $request->kode_kelas,
            'nama_matkul'        =>  $request->nama_matkul,
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
            'kode_kelas'            =>  'required',
            'nama_matkul'           =>  'required',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
            'id_prodi'                =>  'required',
        ];
        $text = [
            'nama_matkul.required'      => 'Nama Matkul harus diisi',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $update = R01PerkuliahanTeori::where('id',$request->r01perkuliahanteori_id_edit)->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'nama_matkul'        =>  $request->nama_matkul,
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
