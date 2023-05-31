<?php

namespace App\Http\Controllers;

use App\Models\R03MembimbingPencapaianKompetensi;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R03MembimbingPencapaianKompetensiController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r03_membimbing_pencapaian_kompetensis')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r03-membimbing-capaian-kompetensi')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r03membimbingpencapaiankompetensis = R03MembimbingPencapaianKompetensi::orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/rubriks/r_03_membimbing_pencapaian_kompetensis.index',[
            'pegawais'                              =>  $pegawais,
            'periode'                               =>  $periode,
            'r03membimbingpencapaiankompetensis'    =>  $r03membimbingpencapaiankompetensis,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r03-membimbing-capaian-kompetensi')) {
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

        $simpan = R03MembimbingPencapaianKompetensi::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
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
        if (!Gate::allows('edit-r03-membimbing-capaian-kompetensi')) {
            abort(403);
        }
        return $r03bimbingcapaiankompetensi;
    }

    public function update(Request $request, R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
        if (!Gate::allows('update-r03-membimbing-capaian-kompetensi')) {
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

        $update = R03MembimbingPencapaianKompetensi::where('id',$request->r03membimbingpencapaiankompetensi_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  0,
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
        if (!Gate::allows('delete-r03-membimbing-capaian-kompetensi')) {
            abort(403);
        }
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
    public function bkdSetNonActive(R03MembimbingPencapaianKompetensi $r03membimbingpencapaiankompetensi){
        $update = $r03membimbingpencapaiankompetensi->update([
            'is_bkd' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_03_membimbing_pencapaian_kompetensi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function bkdSetActive(R03MembimbingPencapaianKompetensi $r03membimbingpencapaiankompetensi){
        $update = $r03membimbingpencapaiankompetensi->update([
            'is_bkd' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_03_membimbing_pencapaian_kompetensi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
