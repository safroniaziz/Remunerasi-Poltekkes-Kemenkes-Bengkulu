<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
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

class R17DosenNaskahBukuBahasaTerbitEdarNasController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r017_naskah_buku_bahasa_terbit_edar_nas')->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r017naskahbukubahasaterbitedarnas = R017NaskahBukuBahasaTerbitEdarNas::where('nip',$_SESSION['data']['kode'])
                                                                            ->where('periode_id',$this->periode->id)
                                                                              ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_017_naskah_buku_bahasa_terbit_edar_nas.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r017naskahbukubahasaterbitedarnas'    =>  $r017naskahbukubahasaterbitedarnas,
       ]);
   }

   public function store(Request $request){
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
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
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
           ->log($_SESSION['data']['nama'] . ' has created a new R17 Naskah Buku Bahasa Terbit Edar Nasional.');

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 17 naskah buku bahasa terbit edar nas baru berhasil ditambahkan',
                'url'   =>  url('/dosen/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
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
   public function edit($r017naskahbukuterbitedarnas){
    return R017NaskahBukuBahasaTerbitEdarNas::where('id',$r017naskahbukuterbitedarnas)->first();
   }

   public function update(Request $request, R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
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
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_buku'        =>  $request->judul_buku,
        'isbn'              =>  $request->isbn,
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
            ->log($_SESSION['data']['nama'] . ' has updated the R17 Naskah Buku Bahasa Terbit Edar Nasional.');

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik naskah buku bahasa terbit edar nas berhasil diubah',
                    'url'   =>  url('/dosen/r_017_naskah_buku_bahasa_terbit_edar_nas/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik naskah buku bahasa terbit edar nas anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

   }
   public function delete($r017naskahbukuterbitedarnas){

    $data =  R017NaskahBukuBahasaTerbitEdarNas::where('id',$r017naskahbukuterbitedarnas)->first();
    $oldData = $data->toArray();
    $delete = R017NaskahBukuBahasaTerbitEdarNas::where('id',$r017naskahbukuterbitedarnas)->delete();

    $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

    if (!empty($dosen)) {
        activity()
        ->causedBy($dosen)
        ->performedOn($data)
        ->event('dosen_deleted')
        ->withProperties([
            'old_data' => $oldData, // Data lama
        ])
        ->log($_SESSION['data']['nama'] . ' has deleted the R17 Naskah Buku Bahasa Terbit Edar Nasional.');

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik naskah buku bahasa terbit edar nas berhasil dihapus',
                'url'   =>  route('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas'),
            ]);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik naskah buku bahasa terbit edar nas remunerasi gagal dihapus',
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

    public function verifikasi(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
        $r017naskahbukuterbitedarnas->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R017NaskahBukuBahasaTerbitEdarNas $r017naskahbukuterbitedarnas){
        $r017naskahbukuterbitedarnas->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
