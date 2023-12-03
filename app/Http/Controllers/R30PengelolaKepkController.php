<?php

namespace App\Http\Controllers;

use App\Models\R030PengelolaKepk;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R30PengelolaKepkController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r030-pengelola-kepk')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r030pengelolakepks = R030PengelolaKepk::where('nip',$request->session()->get('nip_dosen'))
                                                ->where('periode_id',$this->periode->id)
                                                ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_030_pengelola_kepks.index',[
           'pegawais'               =>  $pegawais,
           'periode'                =>  $this->periode,
           'r030pengelolakepks'     =>  $r030pengelolakepks,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r030-pengelola-kepk')) {
        abort(403);
    }
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
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jabatan'           =>  $request->jabatan,
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
            ->log(auth()->user()->nama_user. ' has created a new R30 Pengelola KEPK On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 30 Pengelola KEPK baru berhasil ditambahkan',
                    'url'   =>  url('/r_030_pengelola_kepk/'),
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
   public function edit(R030PengelolaKepk $r030pengelolakepk){
    if (!Gate::allows('edit-r030-pengelola-kepk')) {
        abort(403);
    }
       return $r030pengelolakepk;
   }

   public function update(Request $request, R030PengelolaKepk $r030pengelolakepk){
    if (!Gate::allows('update-r030-pengelola-kepk')) {
        abort(403);
    }
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
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
           'keterangan'                 =>  $request->keterangan,
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
           ->log(auth()->user()->nama_user. ' has updated the R30 Pengelola KEPK data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 30 Pengelola KEPK diubah',
                'url'   =>  url('/r_030_pengelola_kepk/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 30 Pengelola KEPK gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request,R030PengelolaKepk $r030pengelolakepk){
    if (!Gate::allows('delete-r030-pengelola-kepk')) {
        abort(403);
    }

       $data =  $r030pengelolakepk->first();
       $oldData = $data->toArray();
       $delete = $r030pengelolakepk->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R30 Pengelola KEPK data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 30 Pengelola KEPK remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_030_pengelola_kepk')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 30 Pengelola KEPK remunerasi gagal dihapus',
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

   public function verifikasi(Request $request,R030PengelolaKepk $r030pengelolakepk){

        $verifikasi= $r030pengelolakepk->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r030pengelolakepk->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R30 Pengelola KEPK data ' .$dosen);

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
    public function tolak(Request $request,R030PengelolaKepk $r030pengelolakepk){

        $verifikasi=  $r030pengelolakepk->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r030pengelolakepk->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R30 Pengelola KEPK data ' .$dosen);

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
