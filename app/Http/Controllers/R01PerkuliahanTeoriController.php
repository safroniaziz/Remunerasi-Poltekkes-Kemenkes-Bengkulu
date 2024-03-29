<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\User;
use App\Models\NilaiEwmp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\R01PerkuliahanTeori;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;


class R01PerkuliahanTeoriController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r01_perkuliahan_teoris')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r01-perkuliahan-teori')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $dataProdis = Prodi::all();
         $r01perkuliahanteoris = R01PerkuliahanTeori::where('nip',$request->session()->get('nip_dosen'))
                                                    ->where('periode_id',$this->periode->id)
                                                    ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_01_perkuliahan_teoris.index',[
            'pegawais'                =>  $pegawais,
            'periode'                 =>  $this->periode,
            'r01perkuliahanteoris'    =>  $r01perkuliahanteoris,
            'dataProdis'    =>  $dataProdis,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r01-perkuliahan-teori')) {
            abort(403);
        }
        $rules = [
            'kode_kelas'            =>  'required',
            'nama_matkul'           =>  'required',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'is_bkd'                =>  'required',
            'id_prodi'                =>  'required',
        ];
        $text = [
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'nama_matkul.required'      => 'Nama Matkul harus diisi',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $simpan = R01PerkuliahanTeori::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'kode_kelas'       =>  $request->kode_kelas,
            'nama_matkul'        =>  $request->nama_matkul,
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'id_prodi'            =>  $request->id_prodi,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,
            'sumber_data'       =>  'manual',
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
            ->log(auth()->user()->nama_user. ' has created a new R01 Perkuliahan Teori On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, R 01 Perkuliahan Teori baru berhasil ditambahkan',
                    'url'   =>  url('/r_01_perkuliahan_teori/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 01 Perkuliahan Teori gagal disimpan']);
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
    public function edit(R01PerkuliahanTeori $r01perkuliahanteori){
        if (!Gate::allows('edit-r01-perkuliahan-teori')) {
            abort(403);
        }
        return $r01perkuliahanteori;
    }

    public function update(Request $request, R01PerkuliahanTeori $r01perkuliahanteori){
        if (!Gate::allows('update-r01-perkuliahan-teori')) {
            abort(403);
        }
        $rules = [
            'kode_kelas'            =>  'required',
            'nama_matkul'           =>  'required',
            'jumlah_sks'            =>  'required|numeric',
            'jumlah_tatap_muka'     =>  'required|numeric',
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
            'id_prodi'                =>  'required',
        ];
        $text = [
            'nama_matkul.required'      => 'Nama Matkul harus diisi',
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;


        $data =  R01PerkuliahanTeori::where('id',$request->r01perkuliahanteori_id_edit)->first();
        $oldData = $data->toArray();
        $update = $data->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'nama_matkul'        =>  $request->nama_matkul,
            'kode_kelas'        =>  $request->kode_kelas,
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'is_bkd'            =>  $request->is_bkd,
            'id_prodi'            =>  $request->id_prodi,
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
            ->log(auth()->user()->nama_user. ' has updated the R01 Perkuliahan Teori data On ' .$dosen);

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, R 01 Perkuliahan Teori berhasil diubah',
                    'url'   =>  url('/r_01_perkuliahan_teori/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 01 Perkuliahan Teori anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function delete(Request $request, R01PerkuliahanTeori $r01perkuliahanteori){
        if (!Gate::allows('delete-r01-perkuliahan-teori')) {
            abort(403);
        }

        $data =  $r01perkuliahanteori->first();
        $oldData = $data->toArray();
        $delete = $r01perkuliahanteori->delete();

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has deleted the R01 Perkuliahan Teori data ' .$dosen);

            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, r01perkuliahanteori remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('r_01_perkuliahan_teori')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, r01perkuliahanteori remunerasi gagal dihapus',
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

    public function verifikasi(Request $request, R01PerkuliahanTeori $r01perkuliahanteori){
        
        $verifikasi= $r01perkuliahanteori->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r01perkuliahanteori->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R01 Perkuliahan Teori data ' .$dosen);

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

    public function tolak(Request $request, R01PerkuliahanTeori $r01perkuliahanteori){
        $verifikasi= $r01perkuliahanteori->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r01perkuliahanteori->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R01 Perkuliahan Teori data ' .$dosen);

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