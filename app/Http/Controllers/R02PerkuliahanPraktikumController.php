<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\R02PerkuliahanPraktikum;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;



class R02PerkuliahanPraktikumController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r02_perkuliahan_praktikums')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r02-perkuliahan-praktikum')) {
            abort(403);
        }
         $dataProdis = Prodi::all();
         $pegawais = Pegawai::all();
         $r02perkuliahanpraktikums = r02perkuliahanpraktikum::where('nip',$request->session()->get('nip_dosen'))
                                                            ->where('periode_id',$this->periode->id)
                                                            ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_02_perkuliahan_praktikums.index',[
            'pegawais'                    =>  $pegawais,
            'periode'                     =>  $this->periode,
            'dataProdis'                 =>  $dataProdis,
            'r02perkuliahanpraktikums'    =>  $r02perkuliahanpraktikums,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r02-perkuliahan-praktikum')) {
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
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'nama_matkul.required'           => 'Nama Mata Kuliah harus dipilih',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $simpan = R02PerkuliahanPraktikum::create([
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

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($simpan)
            ->event('verifikator_created')
            ->withProperties([
                'created_fields' => $simpan, // Contoh informasi tambahan
            ])
            ->log(auth()->user()->nama_user. ' has created a new R02 Perkuliahan Praktikum On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, R 02 Perkuliahan Praktikum baru berhasil ditambahkan',
                    'url'   =>  url('/r_02_perkuliahan_praktikum/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 02 Perkuliahan Praktikum gagal disimpan']);
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
    public function edit(R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        if (!Gate::allows('edit-r02-perkuliahan-praktikum')) {
            abort(403);
        }
        return $r02perkuliahanpraktikum;
    }

    public function update(Request $request, R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        if (!Gate::allows('update-r02-perkuliahan-praktikum')) {
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
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'nama_matkul.required'           => 'Nama Mata Kuliah harus dipilih',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $data =  R02PerkuliahanPraktikum::where('id',$request->r02perkuliahanpraktikum_id_edit)->first();
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
            ->log(auth()->user()->nama_user. ' has updated the R2 Perkuliahan Praktikum data On ' .$dosen);

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, R 02 Perkuliahan Praktikum berhasil diubah',
                    'url'   =>  url('/r_02_perkuliahan_praktikum/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 02 Perkuliahan Praktikum anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function delete(Request $request, R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        if (!Gate::allows('delete-r02-perkuliahan-praktikum')) {
            abort(403);
        }

        $data =  $r02perkuliahanpraktikum->first();
        $oldData = $data->toArray();
        $delete = $r02perkuliahanpraktikum->delete();
        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has deleted the R02 Perkuliahan Praktikum data ' .$dosen);

            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, r02perkuliahanPraktikum remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('r_02_perkuliahan_praktikum')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, r02perkuliahanPraktikum remunerasi gagal dihapus',
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

    public function verifikasi(Request $request, R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        $verifikasi= $r02perkuliahanpraktikum->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r02perkuliahanpraktikum->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R02 Perkuliahan Praktikum data ' .$dosen);

            if ($verifikasi) {
                  $notification = array(
                        'message' => 'Berhasil, status verifikasi berhasil diubah',
                        'alert-type' => 'success'
                    );
                    return redirect()->back()->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, r02perkuliahanpraktikum remunerasi gagal diverifikasi',
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
    public function tolak(Request $request, R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        $verifikasi= $r02perkuliahanpraktikum->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r02perkuliahanpraktikum->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R02 Perkuliahan Praktikum data ' .$dosen);

            if ($verifikasi) {
                  $notification = array(
                        'message' => 'Berhasil, status verifikasi berhasil diubah',
                        'alert-type' => 'success'
                    );
                    return redirect()->back()->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, r02perkuliahanpraktikum remunerasi gagal diverifikasi',
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
