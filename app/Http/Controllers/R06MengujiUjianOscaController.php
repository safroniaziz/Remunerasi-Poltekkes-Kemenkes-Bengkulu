<?php

namespace App\Http\Controllers;

use App\Models\R06MengujiUjianOsca;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R06MengujiUjianOscaController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
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
        $rules = [
            'nip'                   =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $periode = Periode::select('id')->where('is_active','1')->first();


        $simpan = R06MengujiUjianOsca::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->nip,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
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
        return $r06mengujiujianosca;
    }

    public function update(Request $request, R06MengujiUjianOsca $r06mengujiujianosca){
        $rules = [
            'nip'                   =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();

        $update = R06MengujiUjianOsca::where('id',$request->r06mengujiujianosca_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->nip,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
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
