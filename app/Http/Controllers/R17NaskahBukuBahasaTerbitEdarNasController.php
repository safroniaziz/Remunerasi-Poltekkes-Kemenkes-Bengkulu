<?php

namespace App\Http\Controllers;

use App\Models\R017NaskahBukuBahasaTerbitEdarNas;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R17NaskahBukuBahasaTerbitEdarNasController extends Controller
{
    private $nilai_ewmp;
    private $periode;

    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r017_naskah_buku_bahasa_terbit_edar_nas')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r017-naskah-buku-bahasa-terbit-edar-nas')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r017naskahbukubahasaterbitedarnas = R017NaskahBukuBahasaTerbitEdarNas::where('nip',$request->session()->get('nip_dosen'))
                                                                                ->where('periode_id',$this->periode->id)
                                                                                ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_017_naskah_buku_bahasa_terbit_edar_nas.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $this->periode,
           'r017naskahbukubahasaterbitedarnas'    =>  $r017naskahbukubahasaterbitedarnas,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       $rules = [
           'judul_buku'      =>  'required',
           'isbn'            =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_buku.required'       => 'Judul_buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R017NaskahBukuBahasaTerbitEdarNas::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
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
           ->log(auth()->user()->nama_user. ' has created a new R17 Naskah Buku Bahasa Terbit Edar Nasional On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas baru berhasil ditambahkan',
                'url'   =>  url('/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 17 naskah buku bahasa terbit edar nas gagal disimpan']);
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
   public function edit(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
    if (!Gate::allows('edit-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       return $r017naskahbukuterbitedarnas;
   }

   public function update(Request $request, R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
    if (!Gate::allows('update-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }
       $rules = [
           'judul_buku'           =>  'required',
           'isbn'                 =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_buku.required'       => 'Judul buku harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;
       $data =  R017NaskahBukuBahasaTerbitEdarNas::where('id',$request->r017naskahbukuterbitedarnas_id_edit)->first();
       $oldData = $data->toArray();
       $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
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
           ->log(auth()->user()->nama_user. ' has updated the R17 Naskah Buku Bahasa Terbit Edar Nasional data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas berhasil diubah',
                'url'   =>  url('/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 17 naskah buku bahasa terbit edar nas anda gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request,R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
    if (!Gate::allows('delete-r017-naskah-buku-bahasa-terbit-edar-nas')) {
        abort(403);
    }

    $data =  $r017naskahbukuterbitedarnas->first();
    $oldData = $data->toArray();
    $delete = $r017naskahbukuterbitedarnas->delete();

    $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

    if (!empty($dosen)) {
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($data)
        ->event('verifikator_deleted')
        ->withProperties([
            'old_data' => $oldData, // Data lama
        ])
        ->log(auth()->user()->nama_user. ' has deleted the R17 Naskah Buku Bahasa Terbit Edar Nasional data ' .$dosen);

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_017_naskah_buku_bahasa_terbit_edar_nas')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 17 naskah buku bahasa terbit edar nas remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){

        $verifikasi=  $r017naskahbukuterbitedarnas->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r017naskahbukuterbitedarnas->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R17 Naskah Buku Bahasa Terbit Edar Nasional data ' .$dosen);

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

    public function tolak(Request $request,R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){

        $verifikasi=  $r017naskahbukuterbitedarnas->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r017naskahbukuterbitedarnas->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R17 Naskah Buku Bahasa Terbit Edar Nasional data ' .$dosen);

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
