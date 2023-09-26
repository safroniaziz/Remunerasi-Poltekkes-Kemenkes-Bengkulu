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
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r04_membimbing_pendampingan_ukoms')->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r04-membimbing-pendampingan-ukom')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r04membimbingpendampinganukoms = R04MembimbingPendampinganUkom::where('nip',$request->session()->get('nip_dosen'))
                                                                        ->where('periode_id',$this->periode->id)
                                                                        ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_04_membimbing_pendampingan_ukoms.index',[
            'pegawais'                          =>  $pegawais,
            'periode'                           =>  $this->periode,
            'r04membimbingpendampinganukoms'    =>  $r04membimbingpendampinganukoms,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r04-membimbing-pendampingan-ukom')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $simpan = R04MembimbingPendampinganUkom::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,

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
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $update = R04MembimbingPendampinganUkom::where('id',$request->r04membimbingpendampinganukom_id_edit)->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,

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
