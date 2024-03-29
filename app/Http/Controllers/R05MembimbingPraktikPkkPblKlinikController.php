<?php

namespace App\Http\Controllers;

use App\Models\R05MembimbingPraktikPkkPblKlinik;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class R05MembimbingPraktikPkkPblKlinikController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r05_membimbing_praktik_pkk_pbl_kliniks')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r05-membimbing-praktik-pkk-pbl-klinik')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r05membimbingpraktikpkkpblkliniks = R05MembimbingPraktikPkkPblKlinik::where('nip',$request->session()->get('nip_dosen'))
                                                                             ->where('periode_id',$this->periode->id)
                                                                              ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_05_membimbing_praktik_pkk_pbl_kliniks.index',[
            'pegawais'                             =>  $pegawais,
            'periode'                              =>  $this->periode,
            'r05membimbingpraktikpkkpblkliniks'    =>  $r05membimbingpraktikpkkpblkliniks,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r05-membimbing-praktik-pkk-pbl-klinik')) {
            abort(403);
        }
        $rules = [
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/6)*($request->jumlah_mahasiswa/12))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $simpan = R05MembimbingPraktikPkkPblKlinik::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
            ->log(auth()->user()->nama_user. ' has created a new R5 Mem Praktik PBL PKK KLinik On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, R 05 Membimbing Praktik PKK PBL Klinik baru berhasil ditambahkan',
                    'url'   =>  url('/r_05_membimbing_praktik_pkk_pbl_klinik/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 05 Membimbing Praktik PKK PBL Klinik gagal disimpan']);
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
    public function edit(R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        if (!Gate::allows('edit-r05-membimbing-praktik-pkk-pbl-klinik')) {
            abort(403);
        }
        return $r05membimbingpraktikpkkpblklinik;
    }

    public function update(Request $request, R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        if (!Gate::allows('update-r05-membimbing-praktik-pkk-pbl-klinik')) {
            abort(403);
        }
        $rules = [
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/6)*($request->jumlah_mahasiswa/12))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $data =  R05MembimbingPraktikPkkPblKlinik::where('id',$request->r05membimbingpraktikpkkpblklinik_id_edit)->first();
        $oldData = $data->toArray();
        $update = $data->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
            ->log(auth()->user()->nama_user. ' has updated the R5 Mem Praktik PBL PKK KLinik data On ' .$dosen);

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, R 05 Membimbing Praktik PKK PBL Klinik berhasil diubah',
                    'url'   =>  url('/r_05_membimbing_praktik_pkk_pbl_klinik/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 05 Membimbing Praktik PKK PBL Klinik anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function delete(Request $request,R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        if (!Gate::allows('delete-r05-membimbing-praktik-pkk-pbl-klinik')) {
            abort(403);
        }

        $data =  $r05membimbingpraktikpkkpblklinik->first();
        $oldData = $data->toArray();
        $delete = $r05membimbingpraktikpkkpblklinik->delete();

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has deleted the R5 Mem Praktik PBL PKK KLinik data ' .$dosen);

            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, Membimbing Praktik PKK PBL Klinik remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('r_05_membimbing_praktik_pkk_pbl_klinik')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, Membimbing Praktik PKK PBL Klinik remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $verifikasi=$r05membimbingpraktikpkkpblklinik->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r05membimbingpraktikpkkpblklinik->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R5 Mem Praktik PBL PKK KLinik data ' .$dosen);

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
    public function tolak(Request $request,R05MembimbingPraktikPkkPblKlinik $r05membimbingpraktikpkkpblklinik){
        $verifikasi= $r05membimbingpraktikpkkpblklinik->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r05membimbingpraktikpkkpblklinik->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R5 Mem Praktik PBL PKK KLinik data ' .$dosen);

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
