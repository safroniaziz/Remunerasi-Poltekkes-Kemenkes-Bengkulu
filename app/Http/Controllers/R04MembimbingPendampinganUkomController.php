<?php

namespace App\Http\Controllers;

use App\Models\R04MembimbingPendampinganUkom;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R04MembimbingPendampinganUkomController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r04_membimbing_pendampingan_ukoms')->first();
    }
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r04-membimbing-pendampingan-ukom')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r04membimbingpendampinganukoms = R04MembimbingPendampinganUkom::orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/rubriks/r_04_membimbing_pendampingan_ukoms.index',[
            'pegawais'                          =>  $pegawais,
            'periode'                           =>  $periode,
            'r04membimbingpendampinganukoms'    =>  $r04membimbingpendampinganukoms,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r04-membimbing-pendampingan-ukom')) {
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

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $simpan = R04MembimbingPendampinganUkom::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 04 Membimbing Pendampingan Ukom baru berhasil ditambahkan',
                'url'   =>  url('/r_04_membimbing_pendampingan_ukom/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 04 Membimbing Pendampingan Ukom gagal disimpan']);
        }
    }
    public function edit(R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        if (!Gate::allows('edit-r04-membimbing-pendampingan-ukom')) {
            abort(403);
        }
        return $r04membimbingpendampinganukom;
    }

    public function update(Request $request, R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        if (!Gate::allows('update-r04-membimbing-pendampingan-ukom')) {
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

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $update = R04MembimbingPendampinganUkom::where('id',$request->r04membimbingpendampinganukom_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, R 04 Membimbing Pendampingan Ukom berhasil diubah',
                'url'   =>  url('/r_04_membimbing_pendampingan_ukom/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 04 Membimbing Pendampingan Ukom anda gagal diubah']);
        }
    }
    public function delete(R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        if (!Gate::allows('delete-r04-membimbing-pendampingan-ukom')) {
            abort(403);
        }
        $delete = $r04membimbingpendampinganukom->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, r04MembimbingPendampinganUkom remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_04_membimbing_pendampingan_ukom')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, r04MembimbingPendampinganUkom remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function bkdSetNonActive(R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        $update = $r04membimbingpendampinganukom->update([
            'is_bkd' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_04_membimbing_pendampingan_ukom')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function bkdSetActive(R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        $update = $r04membimbingpendampinganukom->update([
            'is_bkd' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_04_membimbing_pendampingan_ukom')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
