<?php

namespace App\Http\Controllers;

use App\Models\R07MembimbingSkripsiLtaLaProfesi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class R07MembimbingSkripsiLtaLaProfesiController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r07-membimbing-skripsi-lta-la-profesi')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r07membimbingskripsiltalaprofesis = R07MembimbingSkripsiLtaLaProfesi::where('nip',$request->session()->get('nip_dosen'))
                                                                            ->where('periode_id',$this->periode->id)
                                                                            ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_07_membimbing_skripsi_lta_la_profesis.index',[
            'pegawais'                             =>  $pegawais,
            'periode'                              =>  $this->periode,
            'r07membimbingskripsiltalaprofesis'    =>  $r07membimbingskripsiltalaprofesis,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r07-membimbing-skripsi-lta-la-profesi')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'pembimbing_ke'         =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'pembimbing_ke.required'    => 'Pembimbing harus dipilih',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->pembimbing_ke == "pembimbing_utama") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $simpan = R07MembimbingSkripsiLtaLaProfesi::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'pembimbing_ke'     =>  $request->pembimbing_ke,
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
            ->log(auth()->user()->nama_user. ' has created a new R7 Mem Skripsi LTA Profesi On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, R 07 Membimbing Skirpsi LTA LA Profesi baru berhasil ditambahkan',
                    'url'   =>  url('/r_07_membimbing_skripsi_lta_la_profesi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 07 Membimbing Skirpsi LTA LA Profesi gagal disimpan']);
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
    public function edit(R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        if (!Gate::allows('edit-r07-membimbing-skripsi-lta-la-profesi')) {
            abort(403);
        }
        return $r07membimbingskripsiltalaprofesi;
    }

    public function update(Request $request, R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        if (!Gate::allows('update-r07-membimbing-skripsi-lta-la-profesi')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'pembimbing_ke'         =>  'required',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'pembimbing_ke.required'    => 'Pembimbing harus dipilih',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->pembimbing_ke == "pembimbing_utama") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.20;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
        $data =  R07MembimbingSkripsiLtaLaProfesi::where('id',$request->r07membimbingskripsiltalaprofesi_id_edit)->first();
        $oldData = $data->toArray();
        $update = $data->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'pembimbing_ke'     =>  $request->pembimbing_ke,
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
            ->log(auth()->user()->nama_user. ' has updated the R7 Mem Skripsi LTA Profesi data On ' .$dosen);

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, R 07 Membimbing Skirpsi LTA LA Profesi berhasil diubah',
                    'url'   =>  url('/r_07_membimbing_skripsi_lta_la_profesi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 07 Membimbing Skirpsi LTA LA Profesi anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function delete(Request $request, R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        if (!Gate::allows('delete-r07-membimbing-skripsi-lta-la-profesi')) {
            abort(403);
        }

        $data =  $r07membimbingskripsiltalaprofesi->first();
        $oldData = $data->toArray();
        $delete = $r07membimbingskripsiltalaprofesi->delete();

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has deleted the R7 Mem Skripsi LTA Profesi data ' .$dosen);

            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, R07MembimbingSkripsiLtaLaProfesi remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('r_07_membimbing_skripsi_lta_la_profesi')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, R07MembimbingSkripsiLtaLaProfesi remunerasi gagal dihapus',
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

    public function verifikasi(Request $request, R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        $verifikasi= $r07membimbingskripsiltalaprofesi->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r07membimbingskripsiltalaprofesi->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R7 Mem Skripsi LTA Profesi data ' .$dosen);

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
    public function tolak(Request $request, R07MembimbingSkripsiLtaLaProfesi $r07membimbingskripsiltalaprofesi){
        $verifikasi=$r07membimbingskripsiltalaprofesi->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r07membimbingskripsiltalaprofesi->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R7 Mem Skripsi LTA Profesi data ' .$dosen);

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
