<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R027KeanggotaanSenat;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R27DosenKeanggotaanSenatController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r027keanggotaansenats = R027KeanggotaanSenat::where('nip',$_SESSION['data']['kode'])
                                                    ->where('periode_id',$this->periode->id)
                                                     ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_027_keanggotaan_senats.index',[
           'pegawais'                  =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r027keanggotaansenats'     =>  $r027keanggotaansenats,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jabatan'                 =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jabatan.required'          => 'Jabatan harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.75;
        }else{
            $ewmp = 0.50;
        }
        $point = $ewmp;
       $simpan = R027KeanggotaanSenat::create([
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
            ->log($_SESSION['data']['nama'] . ' has created a new R27 Keanggotaan Senat.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 27 Keanggotaan Senat baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_027_keanggotaan_senat/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 27 Keanggotaan Senat gagal disimpan']);
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
   public function edit($r27keanggotaansenat){
    return R027KeanggotaanSenat::where('id',$r27keanggotaansenat)->first();
   }

   public function update(Request $request, R027KeanggotaanSenat $r27keanggotaansenat){
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

        if($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.75;
        }else{
            $ewmp = 0.50;
        }
        $point = $ewmp;

        $data =  R027KeanggotaanSenat::where('id',$request->r27keanggotaansenat_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
           'keterangan'                 =>  $request->keterangan,

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
           ->log($_SESSION['data']['nama'] . ' has updated the R27 Keanggotaan Senat data.');

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Keanggotaan Senat diubah',
                'url'   =>  url('/dosen/r_027_keanggotaan_senat/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik Keanggotaan Senat gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete($r27keanggotaansenat){

       $data =  R027KeanggotaanSenat::where('id',$r27keanggotaansenat)->first();
       $oldData = $data->toArray();
       $delete = R027KeanggotaanSenat::where('id',$r27keanggotaansenat)->delete();

       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy($dosen)
           ->performedOn($data)
           ->event('dosen_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log($_SESSION['data']['nama'] . ' has deleted the R27 Keanggotaan Senat data.');

           if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Keanggotaan Senat dihapus',
                'url'   =>  route('dosen.r_027_keanggotaan_senat'),
            ]);
           }else {
               $notification = array(
                   'message' => 'Ooopps, Rubrik Keanggotaan Senat remunerasi gagal dihapus',
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

    public function verifikasi(R027KeanggotaanSenat $r27keanggotaansenat){
        $r27keanggotaansenat->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R027KeanggotaanSenat $r27keanggotaansenat){
        $r27keanggotaansenat->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
