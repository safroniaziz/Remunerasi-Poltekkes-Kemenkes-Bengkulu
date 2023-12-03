<?php

namespace App\Http\Controllers;

use App\Models\R08MengujiSeminarProposalKtiLtaSkripsi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class R08MengujiSeminarProposalKtiLtaSkripsiController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r08-menguji-seminar-proposal-kti-lta-skripsi')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r08mengujiseminarproposalktiltaskripsis = R08MengujiSeminarProposalKtiLtaSkripsi::where('nip',$request->session()->get('nip_dosen'))
                                                                                        ->where('periode_id',$this->periode->id)
                                                                                          ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_08_menguji_seminar_proposal_kti_lta_skripsis.index',[
            'pegawais'                                   =>  $pegawais,
            'periode'                                    =>  $this->periode,
            'r08mengujiseminarproposalktiltaskripsis'    =>  $r08mengujiseminarproposalktiltaskripsis,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r08-menguji-seminar-proposal-kti-lta-skripsi')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jenis'                 =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
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
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,
        ]);
        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($simpan)
            ->event('verifikator_created')
            ->withProperties([
                'created_fields' => $simpan, // Contoh informasi tambahan
            ])
            ->log(auth()->user()->nama_user. ' has created a new R8 Meng Seminar Proposal KTI LTA Skripsi On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, R 08 Menguji Seminar Proposal Kti Lta Skripsi baru berhasil ditambahkan',
                    'url'   =>  url('/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 08 Menguji Seminar Proposal Kti Lta Skripsi gagal disimpan']);
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
    public function edit(R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        if (!Gate::allows('edit-r08-menguji-seminar-proposal-kti-lta-skripsi')) {
            abort(403);
        }
        return $r08mengujiseminarproposal;
    }

    public function update(Request $request, R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        if (!Gate::allows('update-r08-menguji-seminar-proposal-kti-lta-skripsi')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jenis'                 =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
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
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'jenis'             =>  $request->jenis,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,
        ]);
        $newData = $data->toArray();

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();
        if (!empty($dosen)) {
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_updated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user. ' has updated the R8 Meng Seminar Proposal KTI LTA Skripsi data On ' .$dosen);

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, R 08 Menguji Seminar Proposal Kti Lta Skripsi berhasil diubah',
                    'url'   =>  url('/r_08_menguji_seminar_proposal_kti_lta_skripsi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 08 Menguji Seminar Proposal Kti Lta Skripsi anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function delete(Request $request,R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        if (!Gate::allows('delete-r08-menguji-seminar-proposal-kti-lta-skripsi')) {
            abort(403);
        }

        $data =  $r08mengujiseminarproposal->first();
        $oldData = $data->toArray();
        $delete = $r08mengujiseminarproposal->delete();

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has deleted the R8 Meng Seminar Proposal KTI LTA Skripsi data ' .$dosen);

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
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(Request $request,R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $verifikasi= $r08mengujiseminarproposal->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r08mengujiseminarproposal->first();
        $oldData = $data->toArray();

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_verified')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has Verified the R8 Meng Seminar Proposal KTI LTA Skripsi data ' .$dosen);

            if ($verifikasi) {
                  $notification = array(
                        'message' => 'Berhasil, status verifikasi berhasil diubah',
                        'alert-type' => 'success'
                    );
                    return redirect()->back()->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, r01perkuliahanteori remunerasi gagal diverifikasi',
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

    public function tolak(Request $request,R08MengujiSeminarProposalKtiLtaSkripsi $r08mengujiseminarproposal){
        $verifikasi=$r08mengujiseminarproposal->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r08mengujiseminarproposal->first();
        $oldData = $data->toArray();
        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();


        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_unverified')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R8 Meng Seminar Proposal KTI LTA Skripsi data ' .$dosen);

            if ($verifikasi) {
                $notification = array(
                        'message' => 'Berhasil, status verifikasi berhasil diubah',
                        'alert-type' => 'success'
                    );
                    return redirect()->back()->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, r01perkuliahanteori remunerasi gagal diverifikasi',
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
 }
