<?php

namespace App\Http\Controllers;

use App\Models\R018MendapatHibahPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R18MendapatHibahPkmController extends Controller
{
    private $nilai_ewmp;
    private $periode;

    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r018_mendapat_hibah_pkms')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r018-mendapat-hibah-pkm')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r018mendapathibahpkms = R018MendapatHibahPkm::where('nip',$request->session()->get('nip_dosen'))
                                                    ->where('periode_id',$this->periode->id)
                                                    ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_018_mendapat_hibah_pkms.index',[
           'pegawais'             =>  $pegawais,
           'periode'              =>  $this->periode,
           'r018mendapathibahpkms' =>  $r018mendapathibahpkms,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r018-mendapat-hibah-pkm')) {
        abort(403);
    }
       $rules = [
           'judul_hibah_pkm'      =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_hibah_pkm.required'  => 'Judul Hibah Pkm harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R018MendapatHibahPkm::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
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
           ->log(auth()->user()->nama_user. ' has created a new R18 Mendapat Hibah PKM On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM baru berhasil ditambahkan',
                'url'   =>  url('/r_018_mendapat_hibah_pkm/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 18 Mendapat Hibah PKM gagal disimpan']);
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
   public function edit(R018MendapatHibahPkm $r018mendapathibahpkm){
    if (!Gate::allows('edit-r018-mendapat-hibah-pkm')) {
        abort(403);
    }
       return $r018mendapathibahpkm;
   }

   public function update(Request $request, R018MendapatHibahPkm $r018mendapathibahpkm){
    if (!Gate::allows('update-r018-mendapat-hibah-pkm')) {
        abort(403);
    }
       $rules = [
           'judul_hibah_pkm'      =>  'required',
           'is_bkd'               =>  'required',
       ];
       $text = [
           'judul_hibah_pkm.required'  => 'Judul hibah pkm harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;
       $data =   R018MendapatHibahPkm::where('id',$request->r018mendapathibahpkm_id_edit)->first();
       $oldData = $data->toArray();
       $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_hibah_pkm'   =>  $request->judul_hibah_pkm,
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
           ->log(auth()->user()->nama_user. ' has updated the R18 Mendapat Hibah PKM data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 18 Mendapat Hibah PKM berhasil diubah',
                'url'   =>  url('/r_018_mendapat_hibah_pkm/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 18 Mendapat Hibah PKM anda gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request, R018MendapatHibahPkm $r018mendapathibahpkm){
    if (!Gate::allows('delete-r018-mendapat-hibah-pkm')) {
        abort(403);
    }

    $data =  $r018mendapathibahpkm->first();
    $oldData = $data->toArray();
    $delete = $r018mendapathibahpkm->delete();

    $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

    if (!empty($dosen)) {
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($data)
        ->event('verifikator_deleted')
        ->withProperties([
            'old_data' => $oldData, // Data lama
        ])
        ->log(auth()->user()->nama_user. ' has deleted the R18 Mendapat Hibah PKM data ' .$dosen);

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 18 Mendapat Hibah PKM berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_018_mendapat_hibah_pkm')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 18 Mendapat Hibah PKM gagal dihapus',
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

    public function verifikasi(Request $request,R018MendapatHibahPkm $r018mendapathibahpkm){

        $verifikasi=  $r018mendapathibahpkm->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r018mendapathibahpkm->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R18 Mendapat Hibah PKM data ' .$dosen);

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

    public function tolak(Request $request,R018MendapatHibahPkm $r018mendapathibahpkm){

        $verifikasi= $r018mendapathibahpkm->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r018mendapathibahpkm->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R18 Mendapat Hibah PKM data ' .$dosen);

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
