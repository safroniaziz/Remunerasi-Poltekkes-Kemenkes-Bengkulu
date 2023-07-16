<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R06MengujiUjianOsca;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R06DosenMengujiUjianOscaController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r06_menguji_ujian_oscas')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
         $pegawais = Pegawai::all();
         $r06mengujiujianoscas = R06MengujiUjianOsca::where('nip',$_SESSION['data']['kode'])
                                                    ->orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/dosen/rubriks/r_06_menguji_ujian_oscas.index',[
            'pegawais'                =>  $pegawais,
            'periode'                 =>  $periode,
            'r06mengujiujianoscas'    =>  $r06mengujiujianoscas,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = ($request->jumlah_mahasiswa/12)* $this->nilai_ewmp->ewmp;

        $simpan = R06MengujiUjianOsca::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 06 Menguji Ujian Osca baru berhasil ditambahkan',
                'url'   =>  url('/dosen/r_06_menguji_ujian_osca/'),
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
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = ($request->jumlah_mahasiswa/12)* $this->nilai_ewmp->ewmp;

        $update = R06MengujiUjianOsca::where('id',$request->r06mengujiujianosca_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, R 06 Menguji Ujian Osca berhasil diubah',
                'url'   =>  url('/dosen/r_06_menguji_ujian_osca/'),
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
            return redirect()->route('dosen.r_06_menguji_ujian_osca')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, R06MengujiUjianOsca remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R06MengujiUjianOsca $r06mengujiujianosca){
        $r06mengujiujianosca->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R06MengujiUjianOsca $r06mengujiujianosca){
        $r06mengujiujianosca->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
