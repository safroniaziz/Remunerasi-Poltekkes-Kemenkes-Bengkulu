<?php

namespace App\Http\Controllers;

use App\Models\R028MelaksanakanPengembanganDiri;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R28MelaksanakanPengembanganDiriController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r028-melaksanakan-pengembangan-diri')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r028melaksanakanpengembangandiris = R028MelaksanakanPengembanganDiri::where('nip',$request->session()->get('nip_dosen'))
                                                                            ->where('periode_id',$this->periode->id)
                                                                            ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_028_melaksanakan_pengembangan_diris.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $this->periode,
           'r028melaksanakanpengembangandiris'     =>  $r028melaksanakanpengembangandiris,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r028-melaksanakan-pengembangan-diri')) {
        abort(403);
    }
       $rules = [
           'jenis_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jenis_kegiatan.required'   => 'Jenis Kegiatan harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jenis_kegiatan == "pelatihan") {
            $ewmp = 1.00;
        }elseif ($request->jenis_kegiatan == "workshop") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.15;
        }
        $point = $ewmp;
       $simpan = R028MelaksanakanPengembanganDiri::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jenis_kegiatan'    =>  $request->jenis_kegiatan,
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
           ->log(auth()->user()->nama_user. ' has created a new R28 Melaksanakan Pengembangan Diri On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri baru berhasil ditambahkan',
                'url'   =>  url('/r_028_melaksanakan_pengembangan_diri/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 28 Melaksanakan Pengembangan Diri gagal disimpan']);
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
   public function edit(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
    if (!Gate::allows('edit-r028-melaksanakan-pengembangan-diri')) {
        abort(403);
    }
       return $r28laksanakanpengembangandiri;
   }

   public function update(Request $request, R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
    if (!Gate::allows('update-r028-melaksanakan-pengembangan-diri')) {
        abort(403);
    }
       $rules = [
           'jenis_kegiatan'          =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'jenis_kegiatan.required' => 'Jenis Kegiatan harus diisi',
           'is_bkd.required'         => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jenis_kegiatan == "pelatihan") {
            $ewmp = 1.00;
        }elseif ($request->jenis_kegiatan == "workshop") {
            $ewmp = 0.25;
        }else{
            $ewmp = 0.15;
        }
        $point = $ewmp;
        $data =  R028MelaksanakanPengembanganDiri::where('id',$request->r28laksanakanpengembangandiri_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'jenis_kegiatan'             =>  $request->jenis_kegiatan,
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
           ->log(auth()->user()->nama_user. ' has updated the R28 Melaksanakan Pengembangan Diri data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri diubah',
                'url'   =>  url('/r_028_melaksanakan_pengembangan_diri/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 28 Melaksanakan Pengembangan Diri gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request,R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
    if (!Gate::allows('delete-r028-melaksanakan-pengembangan-diri')) {
        abort(403);
    }

       $data =  $r28laksanakanpengembangandiri->first();
       $oldData = $data->toArray();
       $delete = $r28laksanakanpengembangandiri->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R28 Melaksanakan Pengembangan Diri data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_028_melaksanakan_pengembangan_diri')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 28 Melaksanakan Pengembangan Diri remunerasi gagal dihapus',
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
    public function verifikasi(Request $request,R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){

        $verifikasi= $r28laksanakanpengembangandiri->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r28laksanakanpengembangandiri->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R28 Melaksanakan Pengembangan Diri data ' .$dosen);

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

    public function tolak(Request $request,R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){

        $verifikasi=   $r28laksanakanpengembangandiri->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r28laksanakanpengembangandiri->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R28 Melaksanakan Pengembangan Diri data ' .$dosen);

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
