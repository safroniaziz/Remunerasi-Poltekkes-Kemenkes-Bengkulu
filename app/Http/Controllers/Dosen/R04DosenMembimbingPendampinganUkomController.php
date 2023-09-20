<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R04MembimbingPendampinganUkom;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R04DosenMembimbingPendampinganUkomController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r04_membimbing_pendampingan_ukoms')->first();
    }
    public function index(Request $request, Pegawai $pegawai){
         $pegawais = Pegawai::all();
         $r04membimbingpendampinganukoms = R04MembimbingPendampinganUkom::where('nip',$_SESSION['data']['kode'])
                                                                        ->orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/dosen/rubriks/r_04_membimbing_pendampingan_ukoms.index',[
            'pegawais'                          =>  $pegawais,
            'periode'                           =>  $periode,
            'r04membimbingpendampinganukoms'    =>  $r04membimbingpendampinganukoms,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'is_bkd.required'           => 'Status rubrik harus dipilih',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $simpan = R04MembimbingPendampinganUkom::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 04 Membimbing Pendampingan Ukom baru berhasil ditambahkan',
                'url'   =>  url('/dosen/r_04_membimbing_pendampingan_ukom/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 04 Membimbing Pendampingan Ukom gagal disimpan']);
        }
    }
    public function edit($r04membimbingpendampinganukom){
        return R04MembimbingPendampinganUkom::where('id',$r04membimbingpendampinganukom)->first();
    }

    public function update(Request $request, R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $update = R04MembimbingPendampinganUkom::where('id',$request->r04membimbingpendampinganukom_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Membimbing Pendampingan Ukom berhasil diubah',
                'url'   =>  url('/dosen/r_04_membimbing_pendampingan_ukom/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik Membimbing Pendampingan Ukom anda gagal diubah']);
        }
    }
    public function delete($r04membimbingpendampinganukom){
        $delete = R04MembimbingPendampinganUkom::where('id',$r04membimbingpendampinganukom)->delete();
        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Membimbing Pendampingan Ukom berhasil dihapus',
                'url'   =>  route('dosen.r_04_membimbing_pendampingan_ukom'),
            ]);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik Membimbing Pendampingan Ukom remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        $r04membimbingpendampinganukom->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        $r04membimbingpendampinganukom->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
