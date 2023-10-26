<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R08MengujiSeminarProposalKtiLtaSkripsi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;

class R08DosenMengujiSeminarProposalKtiLtaSkripsiController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
         $pegawais = Pegawai::all();
         $r08mengujiseminarproposalktiltaskripsis = R08MengujiSeminarProposalKtiLtaSkripsi::where('nip',$_SESSION['data']['kode'])
                                                                                            ->where('periode_id',$this->periode->id)
                                                                                          ->orderBy('created_at','desc')->get();
         return view('backend/dosen/rubriks/r_08_menguji_seminar_proposal_kti_lta_skripsis.index',[
            'pegawais'                                   =>  $pegawais,
            'periode'                 =>  $this->periode,
            'r08mengujiseminarproposalktiltaskripsis'    =>  $r08mengujiseminarproposalktiltaskripsis,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'jenis'                 =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'jenis.required'            => 'Jenis Seminar harus dipilih',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.05;
        }else{
            $ewmp = 0.06;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $simpan = R08MengujiSeminarProposalKtiLtaSkripsi::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,

        ]);
        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($simpan)
            ->event('dosen_created')
            ->withProperties([
                'created_fields' => $simpan, // Contoh informasi tambahan
            ])
            ->log($_SESSION['data']['nama'] . ' has created a new R08 Menguji Seminar Proposal Kti Lta Skripsi.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Menguji Seminar Proposal Kti Lta Skripsi baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Menguji Seminar Proposal Kti Lta Skripsi gagal disimpan']);
            }
        }
        else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function edit($r08mengujiseminarproposal){
        return R08MengujiSeminarProposalKtiLtaSkripsi::where('id',$r08mengujiseminarproposal)->first();
    }

    public function update(Request $request, R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'jenis'                 =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'jenis.required'            => 'Jenis Seminar harus dipilih',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.05;
        }else{
            $ewmp = 0.06;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;

        $data =  R08MengujiSeminarProposalKtiLtaSkripsi::where('id',$request->r08mengujiseminarproposal_id_edit)->first();
        $oldData = $data->toArray();

        $update = $data->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,

        ]);
        $newData = $data->toArray();

        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();
        if (!empty($dosen)) {
        activity()
            ->causedBy($dosen)
            ->performedOn($data)
            ->event('dosen_updated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log($_SESSION['data']['nama'] . ' has updated the R08 Menguji Seminar Proposal Kti Lta Skripsi data.');

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Menguji Seminar Proposal Kti Lta Skripsi berhasil diubah',
                    'url'   =>  url('/dosen/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Menguji Seminar Proposal Kti Lta Skripsi anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function delete($r08mengujiseminarproposal){
        $data =  R01PerkuliahanTeori::where('id',$r01perkuliahanteori)->first();
        $oldData = $data->toArray();
        $delete = R08MengujiSeminarProposalKtiLtaSkripsi::where('id',$r08mengujiseminarproposal)->delete();
        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($data)
            ->event('dosen_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log($_SESSION['data']['nama'] . ' has deleted the R08 Menguji Seminar Proposal Kti Lta Skripsi data.');

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
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
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
