<?php

namespace App\Http\Controllers;

use App\Models\R06MengujiUjianOsca;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R06MengujiUjianOscaController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r06_menguji_ujian_oscas')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r06-menguji-ujian-osca')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r06mengujiujianoscas = R06MengujiUjianOsca::orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/rubriks/r_06_menguji_ujian_oscas.index',[
            'pegawais'                =>  $pegawais,
            'periode'                 =>  $periode,
            'r06mengujiujianoscas'    =>  $r06mengujiujianoscas,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r06-menguji-ujian-osca')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = ($request->jumlah_mahasiswa/12)* $this->nilai_ewmp->ewmp;

        $simpan = R06MengujiUjianOsca::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 06 Menguji Ujian Osca baru berhasil ditambahkan',
                'url'   =>  url('/r_06_menguji_ujian_osca/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 06 Menguji Ujian Osca gagal disimpan']);
        }
    }
    public function edit(R06MengujiUjianOsca $r06mengujiujianosca){
        if (!Gate::allows('edit-r06-menguji-ujian-osca')) {
            abort(403);
        }
        return $r06mengujiujianosca;
    }

    public function update(Request $request, R06MengujiUjianOsca $r06mengujiujianosca){
        if (!Gate::allows('update-r06-menguji-ujian-osca')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = ($request->jumlah_mahasiswa/12)* $this->nilai_ewmp->ewmp;

        $update = R06MengujiUjianOsca::where('id',$request->r06mengujiujianosca_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, R 06 Menguji Ujian Osca berhasil diubah',
                'url'   =>  url('/r_06_menguji_ujian_osca/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 06 Menguji Ujian Osca anda gagal diubah']);
        }
    }
    public function delete(R06MengujiUjianOsca $r06mengujiujianosca){
        if (!Gate::allows('delete-r06-menguji-ujian-osca')) {
            abort(403);
        }
        $delete = $r06mengujiujianosca->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, R06MengujiUjianOsca remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_06_menguji_ujian_osca')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, R06MengujiUjianOsca remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function bkdSetNonActive(R06MengujiUjianOsca $R06MengujiUjianOsca){
        $update = $R06MengujiUjianOsca->update([
            'is_bkd' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_06_menguji_ujian_osca')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function bkdSetActive(R06MengujiUjianOsca $R06MengujiUjianOsca){
        $update = $R06MengujiUjianOsca->update([
            'is_bkd' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_06_menguji_ujian_osca')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
