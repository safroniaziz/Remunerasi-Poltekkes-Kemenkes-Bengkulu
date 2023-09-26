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
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r03_membimbing_pencapaian_kompetensis')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r03-membimbing-capaian-kompetensi')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r03membimbingpencapaiankompetensis = R03MembimbingPencapaianKompetensi::where('nip',$request->session()->get('nip_dosen'))
                                                                                ->where('periode_id',$this->periode->id)
                                                                                ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_03_membimbing_pencapaian_kompetensis.index',[
            'pegawais'                              =>  $pegawais,
            'periode'                               =>  $this->periode,
            'r03membimbingpencapaiankompetensis'    =>  $r03membimbingpencapaiankompetensis,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r03-membimbing-capaian-kompetensi')) {
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

        $simpan = R03MembimbingPencapaianKompetensi::create([
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

        $update = R03MembimbingPencapaianKompetensi::where('id',$request->r03membimbingpencapaiankompetensi_id_edit)->update([
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
