<?php

namespace App\Http\Controllers;

use App\Models\R04MembimbingPendampinganUkom;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R04MembimbingPendampinganUkomController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::select('nip','nama')->whereNotIn('nip',function($query) use ($pegawai) {
            $query->select('nip')->from('r03_membimbing_pencapaian_kompetensis')->where('nip',$pegawai->nip);
         })->get();
         $r04membimbingpendampinganukoms = R04MembimbingPendampinganUkom::orderBy('created_at','desc')->get();
         $periodes = Periode::where('is_active','1')->get();

         return view('backend/rubriks/r_04_membimbing_pendampingan_ukoms.index',[
            'pegawais'                              =>  $pegawais,
            'periodes'                              =>  $periodes,
            'r04membimbingpendampinganukoms'    =>  $r04membimbingpendampinganukoms,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'periode_id'            =>  'required',
            'nip'                   =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'periode_id.required'       => 'Periode harus dipilih',
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = R04MembimbingPendampinganUkom::create([
            'periode_id'        =>  $request->periode_id,
            'nip'               =>  $request->nip,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
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
        return $r04membimbingpendampinganukom;
    }

    public function update(Request $request, R04MembimbingPendampinganUkom $r04membimbingpendampinganukom){
        $rules = [
            'periode_id'            =>  'required',
            'nip'                   =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
        ];
        $text = [
            'periode_id.required'       => 'Periode harus dipilih',
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $update = R04MembimbingPendampinganUkom::where('id',$request->r04membimbingpendampinganukom_id_edit)->update([
            'periode_id'        =>  $request->periode_id,
            'nip'               =>  $request->nip,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
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
