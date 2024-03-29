<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R020AssessorBkdLkd;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R20DosenAssessorBkdLkdController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r020_assessor_bkd_lkds')->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r020assessorbkdlkds = R020AssessorBkdLkd::where('nip',$_SESSION['data']['kode'])
                                                ->where('periode_id',$this->periode->id)
                                                 ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_020_assessor_bkd_lkds.index',[
           'pegawais'               =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r020assessorbkdlkds'    =>  $r020assessorbkdlkds,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jumlah_dosen'          =>  'required|regex:/^[0-9]+$/|min:0',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_dosen.required'     => 'Jumlah Dosen harus diisi',
           'jumlah_dosen.numeric'      => 'Jumlah Dosen harus berupa angka',
           'jumlah_dosen.min'          => 'Jumlah Dosen tidak boleh kurang dari 0',
           'jumlah_dosen.regex'        => 'Format Dosen tidak valid',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = ($request->jumlah_dosen / 8) * $this->nilai_ewmp->ewmp;

       $simpan = R020AssessorBkdLkd::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'jumlah_dosen'      =>  $request->jumlah_dosen,
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
            ->log($_SESSION['data']['nama'] . ' has created a new R20 Assessor BKD LKD.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 20 Assessor BKD LKD baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_020_assessor_bkd_lkd/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 20 Assessor BKD LKD gagal disimpan']);
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
   public function edit($r020assessorbkdlkd){
    return R020AssessorBkdLkd::where('id',$r020assessorbkdlkd)->first();
   }

   public function update(Request $request, R020AssessorBkdLkd $r020assessorbkdlkd){
       $rules = [
           'jumlah_dosen'          =>  'required|regex:/^[0-9]+$/|min:0',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_dosen.required' => 'Jumlah Dosen harus diisi',
           'jumlah_dosen.numeric'  => 'Jumlah Dosen harus berupa angka',
           'jumlah_dosen.min'      => 'Jumlah Dosen tidak boleh kurang dari 0',
           'jumlah_dosen.regex'    => 'Format Dosen tidak valid',
           'is_bkd.required'       => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }


       $point = ($request->jumlah_dosen / 8) * $this->nilai_ewmp->ewmp;

       $data =  R020AssessorBkdLkd::where('id',$request->r020assessorbkdlkd_id_edit)->first();
       $oldData = $data->toArray();
       $update = $data->update([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'jumlah_dosen'      =>  $request->jumlah_dosen,
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
           ->log($_SESSION['data']['nama'] . ' has updated the R20 Assessor BKD LKD data.');

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Assessor BKD LKD diubah',
                'url'   =>  url('/dosen/r_020_assessor_bkd_lkd/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik Assessor BKD LKD gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete($r020assessorbkdlkd){

       $data =  R020AssessorBkdLkd::where('id',$r020assessorbkdlkd)->first();
       $oldData = $data->toArray();
       $delete = R020AssessorBkdLkd::where('id',$r020assessorbkdlkd)->delete();

       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy($dosen)
           ->performedOn($data)
           ->event('dosen_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log($_SESSION['data']['nama'] . ' has deleted the R20 Assessor BKD LKD data.');

           if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Assessor BKD LKD dihapus',
                'url'   =>  route('dosen.r_020_assessor_bkd_lkd'),
            ]);
           }else {
               $notification = array(
                   'message' => 'Ooopps, Rubrik Assessor BKD LKD remunerasi gagal dihapus',
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

    public function verifikasi(R020AssessorBkdLkd $r020assessorbkdlkd){
        $r020assessorbkdlkd->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R020AssessorBkdLkd $r020assessorbkdlkd){
        $r020assessorbkdlkd->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
