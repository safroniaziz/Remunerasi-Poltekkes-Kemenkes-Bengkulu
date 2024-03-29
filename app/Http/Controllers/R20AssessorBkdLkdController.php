<?php

namespace App\Http\Controllers;

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

class R20AssessorBkdLkdController extends Controller
{
    private $nilai_ewmp;
    private $periode;

    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r020_assessor_bkd_lkds')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r020-assessor-bkd-lkd')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r020assessorbkdlkds = R020AssessorBkdLkd::where('nip',$request->session()->get('nip_dosen'))
                                                ->where('periode_id',$this->periode->id)
                                                ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_020_assessor_bkd_lkds.index',[
           'pegawais'               =>  $pegawais,
           'periode'                =>  $this->periode,
           'r020assessorbkdlkds'    =>  $r020assessorbkdlkds,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r020-assessor-bkd-lkd')) {
        abort(403);
    }
       $rules = [
           'jumlah_dosen'          =>  'required|numeric',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_dosen.required'     => 'Jumlah Dosen harus diisi',
           'jumlah_dosen.numeric'      => 'Jumlah Dosen harus berupa angka',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = ($request->jumlah_dosen / 8) * $this->nilai_ewmp->ewmp;

       $simpan = R020AssessorBkdLkd::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jumlah_dosen'      =>  $request->jumlah_dosen,
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
           ->log(auth()->user()->nama_user. ' has created a new R20 Assessor BKD LKD On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 20 Assessor BKD LKD baru berhasil ditambahkan',
                'url'   =>  url('/r_020_assessor_bkd_lkd/'),
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
   public function edit(R020AssessorBkdLkd $r020assessorbkdlkd){
    if (!Gate::allows('edit-r020-assessor-bkd-lkd')) {
        abort(403);
    }
       return $r020assessorbkdlkd;
   }

   public function update(Request $request, R020AssessorBkdLkd $r020assessorbkdlkd){
    if (!Gate::allows('update-r020-assessor-bkd-lkd')) {
        abort(403);
    }
       $rules = [
           'jumlah_dosen'          =>  'required|numeric',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_dosen.required' => 'Jumlah Dosen harus diisi',
           'jumlah_dosen.numeric'  => 'Jumlah Dosen harus berupa angka',
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
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jumlah_dosen'      =>  $request->jumlah_dosen,
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
           ->log(auth()->user()->nama_user. ' has updated the R20 Assessor BKD LKD data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 20 Assessor BKD LKD diubah',
                'url'   =>  url('/r_020_assessor_bkd_lkd/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 20 Assessor BKD LKD gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request,R020AssessorBkdLkd $r020assessorbkdlkd){
    if (!Gate::allows('delete-r020-assessor-bkd-lkd')) {
        abort(403);
    }
       $data =  $r020assessorbkdlkd->first();
       $oldData = $data->toArray();
       $delete = $r020assessorbkdlkd->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R20 Assessor BKD LKD data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 20 Assessor BKD LKD remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_020_assessor_bkd_lkd')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 20 Assessor BKD LKD remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R020AssessorBkdLkd $r020assessorbkdlkd){

        $verifikasi= $r020assessorbkdlkd->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r020assessorbkdlkd->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R20 Assessor BKD LKD data ' .$dosen);

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

    public function tolak(Request $request,R020AssessorBkdLkd $r020assessorbkdlkd){

        $verifikasi= $r020assessorbkdlkd->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r020assessorbkdlkd->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R20 Assessor BKD LKD data ' .$dosen);

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
