<?php

namespace App\Http\Controllers;

use App\Models\R08MengujiSeminarProposalKtiLtaSkripsi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class R08MengujiSeminarProposalKtiLtaSkripsiController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
         $pegawais = Pegawai::all();
         $r08mengujiseminarproposalktiltaskripsis = R08MengujiSeminarProposalKtiLtaSkripsi::orderBy('created_at','desc')->get();
         $periode = Periode::select('nama_periode')->where('is_active','1')->first();

         return view('backend/rubriks/r_08_menguji_seminar_proposal_kti_lta_skripsis.index',[
            'pegawais'                                   =>  $pegawais,
            'periode'                                    =>  $periode,
            'r08mengujiseminarproposalktiltaskripsis'    =>  $r08mengujiseminarproposalktiltaskripsis,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'nip'                   =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jenis'                 =>  'required',

        ];
        $text = [
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jenis.required'            => 'Jenis Seminar harus dipilih',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();

        $simpan = R08MengujiSeminarProposalKtiLtaSkripsi::create([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->nip,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, R 08 Menguji Seminar Proposal Kti Lta Skripsi baru berhasil ditambahkan',
                'url'   =>  url('/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 08 Menguji Seminar Proposal Kti Lta Skripsi gagal disimpan']);
        }
    }
    public function edit(R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        return $r08mengujiseminarproposal;
    }

    public function update(Request $request, R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $rules = [
            'nip'                   =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jenis'                 =>  'required',
        ];
        $text = [
            'nip.required'              => 'NIP harus dipilih',
            'nip.numeric'               => 'NIP harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jenis.required'            => 'Jenis Seminar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $periode = Periode::select('id')->where('is_active','1')->first();

        $update = R08MengujiSeminarProposalKtiLtaSkripsi::where('id',$request->r08mengujiseminarproposal_id_edit)->update([
            'periode_id'        =>  $periode->id,
            'nip'               =>  $request->nip,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  0,
            'is_verified'       =>  0,
            'point'             =>  null,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, R 08 Menguji Seminar Proposal Kti Lta Skripsi berhasil diubah',
                'url'   =>  url('/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, R 08 Menguji Seminar Proposal Kti Lta Skripsi anda gagal diubah']);
        }
    }
    public function delete(R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $delete = $r08mengujiseminarproposal->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, R08 Menguji Seminar Proposal Kti Lta Skripsi remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_08_menguji_seminar_proposal_kti_lta_skripsi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, R08 Menguji Seminar Proposal Kti Lta Skripsi remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function bkdSetNonActive(R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposalktiltaskripsi){
        $update = $r08mengujiseminarproposalktiltaskripsi->update([
            'is_bkd' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_08_menguji_seminar_proposal_kti_lta_skripsi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function bkdSetActive(R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposalktiltaskripsi){
        $update = $r08mengujiseminarproposalktiltaskripsi->update([
            'is_bkd' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data bkd berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('r_08_menguji_seminar_proposal_kti_lta_skripsi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data bkd gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
