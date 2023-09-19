<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R08MengujiSeminarProposalKtiLtaSkripsi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R08DosenMengujiSeminarProposalKtiLtaSkripsiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
         $pegawais = Pegawai::all();
         $r08mengujiseminarproposalktiltaskripsis = R08MengujiSeminarProposalKtiLtaSkripsi::where('nip',$_SESSION['data']['kode'])
                                                                                          ->orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/dosen/rubriks/r_08_menguji_seminar_proposal_kti_lta_skripsis.index',[
            'pegawais'                                   =>  $pegawais,
            'periode'                                    =>  $periode,
            'r08mengujiseminarproposalktiltaskripsis'    =>  $r08mengujiseminarproposalktiltaskripsis,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jenis'                 =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jenis.required'            => 'Jenis Seminar harus dipilih',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.05;
        }else{
            $ewmp = 0.06;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $simpan = R08MengujiSeminarProposalKtiLtaSkripsi::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Menguji Seminar Proposal Kti Lta Skripsi baru berhasil ditambahkan',
                'url'   =>  url('/dosen/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik Menguji Seminar Proposal Kti Lta Skripsi gagal disimpan']);
        }
    }
    public function edit($r08mengujiseminarproposal){
        return R08MengujiSeminarProposalKtiLtaSkripsi::where('id',$r08mengujiseminarproposal)->first();
    }

    public function update(Request $request, R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jenis'                 =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jenis.required'            => 'Jenis Seminar harus dipilih',
            'is_bkd.required'           => 'Rubrik BKD harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.05;
        }else{
            $ewmp = 0.06;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $update = R08MengujiSeminarProposalKtiLtaSkripsi::where('id',$request->r08mengujiseminarproposal_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Menguji Seminar Proposal Kti Lta Skripsi berhasil diubah',
                'url'   =>  url('/dosen/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik Menguji Seminar Proposal Kti Lta Skripsi anda gagal diubah']);
        }
    }
    public function delete($r08mengujiseminarproposal){
        $delete = R08MengujiSeminarProposalKtiLtaSkripsi::where('id',$r08mengujiseminarproposal)->delete();
        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Menguji Seminar Proposal Kti Lta Skripsi berhasil dihapus',
                'url'   =>  route('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi'),
            ]);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik Menguji Seminar Proposal Kti Lta Skripsi remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $r08mengujiseminarproposal->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $r08mengujiseminarproposal->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
