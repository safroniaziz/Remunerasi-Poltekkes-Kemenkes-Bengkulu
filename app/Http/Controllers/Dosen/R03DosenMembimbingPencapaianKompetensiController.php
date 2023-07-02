<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R03MembimbingPencapaianKompetensi;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R03DosenMembimbingPencapaianKompetensiController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r03_membimbing_pencapaian_kompetensis')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
         $pegawais = Pegawai::all();
         $r03membimbingpencapaiankompetensis = R03MembimbingPencapaianKompetensi::where('nip',$_SESSION['data']['kode'])
                                                                                ->orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/dosen/rubriks/r_03_membimbing_pencapaian_kompetensis.index',[
            'pegawais'                              =>  $pegawais,
            'periode'                               =>  $periode,
            'r03membimbingpencapaiankompetensis'    =>  $r03membimbingpencapaiankompetensis,
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

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $simpan = R03MembimbingPencapaianKompetensi::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 03 Membimbing Pencapaian Kompetensi baru berhasil ditambahkan',
                'url'   =>  url('/r_03_membimbing_pencapaian_kompetensi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 03 Membimbing Pencapaian Kompetensi gagal disimpan']);
        }
    }
    public function edit(R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
        return $r03bimbingcapaiankompetensi;
    }

    public function update(Request $request, R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
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

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $update = R03MembimbingPencapaianKompetensi::where('id',$request->r03membimbingpencapaiankompetensi_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, R 03 Membimbing Pencapaian Kompetensi berhasil diubah',
                'url'   =>  url('/r_03_membimbing_pencapaian_kompetensi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 03 Membimbing Pencapaian Kompetensi anda gagal diubah']);
        }
    }
    public function delete(R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
        $delete = $r03bimbingcapaiankompetensi->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, r03membimbingpencapaiankompetensi remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_03_membimbing_pencapaian_kompetensi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, r03membimbingpencapaiankompetensi remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
        $r03bimbingcapaiankompetensi->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
        $r03bimbingcapaiankompetensi->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
