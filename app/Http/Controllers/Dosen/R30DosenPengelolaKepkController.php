<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R030PengelolaKepk;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R30DosenPengelolaKepkController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r030pengelolakepks = R030PengelolaKepk::where('nip',$_SESSION['data']['kode'])
                                                ->where('periode_id',$this->periode->id)
                                               ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_030_pengelola_kepks.index',[
           'pegawais'               =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r030pengelolakepks'     =>  $r030pengelolakepks,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jabatan'     =>  'required',
           'is_bkd'      =>  'required',
       ];
       $text = [
           'jabatan.required'  => 'Jabatan harus diisi',
           'is_bkd.required'   => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "ketua") {
            $ewmp = 1.50;
        }elseif ($request->jabatan == "wakil" || $request->jabatan == "sekretaris") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.75;
        }
        $point = $ewmp;
       $simpan = R030PengelolaKepk::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'jabatan'           =>  $request->jabatan,
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
           ->log($_SESSION['data']['nama'] . ' has created a new R30 Pengelola KEPK.');

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 30 Pengelola KEPK baru berhasil ditambahkan',
                'url'   =>  url('/dosen/r_030_pengelola_kepk/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 30 Pengelola KEPK gagal disimpan']);
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
   public function edit($r030pengelolakepk){
    return R030PengelolaKepk::where('id',$r030pengelolakepk)->first();
   }

   public function update(Request $request, R030PengelolaKepk $r030pengelolakepk){
       $rules = [
           'jabatan'                 =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jabatan.required'        => 'Jabatan harus diisi',
           'is_bkd.required'         => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "ketua") {
            $ewmp = 1.50;
        }elseif ($request->jabatan == "wakil" || $request->jabatan == "sekretaris") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.20;
        }
        $point = $ewmp;

        $data =  R030PengelolaKepk::where('id',$request->r030pengelolakepk_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
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
           ->log($_SESSION['data']['nama'] . ' has updated the R30 Pengelola KEPK data.');

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Pengelola KEPK diubah',
                'url'   =>  url('/dosen/r_030_pengelola_kepk/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik Pengelola KEPK gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete($r030pengelolakepk){

       $data =  R030PengelolaKepk::where('id',$r030pengelolakepk)->first();
       $oldData = $data->toArray();
       $delete = R030PengelolaKepk::where('id',$r030pengelolakepk)->delete();


       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy($dosen)
           ->performedOn($data)
           ->event('dosen_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log($_SESSION['data']['nama'] . ' has deleted the R30 Pengelola KEPK data.');

           if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Pengelola KEPK dihapus',
                'url'   =>  route('dosen.r_030_pengelola_kepk'),
            ]);
           }else {
               $notification = array(
                   'message' => 'Ooopps, Rubrik Pengelola KEPK remunerasi gagal dihapus',
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

   public function verifikasi(R030PengelolaKepk $r030pengelolakepk){
        $r030pengelolakepk->update([
            'is_verified'   =>  1,
        ]);
        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R030PengelolaKepk $r030pengelolakepk){
        $r030pengelolakepk->update([
            'is_verified'   =>  0,
        ]);
        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
