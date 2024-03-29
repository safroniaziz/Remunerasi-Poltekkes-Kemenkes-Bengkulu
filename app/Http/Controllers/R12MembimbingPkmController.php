<?php

namespace App\Http\Controllers;

use App\Models\R012MembimbingPkm;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R12MembimbingPkmController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r012-membimbing-pkm')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r012membimbingpkms = R012MembimbingPkm::where('nip',$request->session()->get('nip_dosen'))
                                                ->where('periode_id',$this->periode->id)
                                               ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_012_membimbing_pkms.index',[
           'pegawais'                 =>  $pegawais,
           'periode'                  =>  $this->periode,
           'r012membimbingpkms'       =>  $r012membimbingpkms,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r012-membimbing-pkm')) {
        abort(403);
    }
       $rules = [
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|numeric',
           'is_bkd'             =>  'required',
       ];
       $text = [
           'tingkat_pkm.required'         => 'tingkat_pkm harus diisi',
           'juara_ke.required'            => 'Penulis harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Penulis harus berupa angka',
           'is_bkd.required'              => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }


        if ($request->tingkat_pkm == "internasional") {
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 2;
            }else{
                $ewmp = 1;
            }
        }else{
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 1;
            }else{
                $ewmp = 0.5;
            }
        }
        $point = $ewmp/$request->jumlah_pembimbing;
       $simpan = R012MembimbingPkm::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'tingkat_pkm'       =>  $request->tingkat_pkm,
        'juara_ke'          =>  $request->juara_ke,
        'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
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
           ->log(auth()->user()->nama_user. ' has created a new R12 Membimbing PKM On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 12 Membimbing PKM baru berhasil ditambahkan',
                'url'   =>  url('/r_012_membimbing_pkm/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 12 Membimbing PKM gagal disimpan']);
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
   public function edit(R012MembimbingPkm $r012membimbingpkm){
    if (!Gate::allows('edit-r012-membimbing-pkm')) {
        abort(403);
    }
       return $r012membimbingpkm;
   }

   public function update(Request $request, R012MembimbingPkm $r012membimbingpkm){
    if (!Gate::allows('update-r012-membimbing-pkm')) {
        abort(403);
    }
       $rules = [
           'tingkat_pkm'        =>  'required',
           'juara_ke'           =>  'required',
           'jumlah_pembimbing'  =>  'required|numeric',
           'is_bkd'             =>  'required',
       ];
       $text = [
           'tingkat_pkm.required'         => 'Tingkat Pkm harus diisi',
           'juara_ke.required'            => 'Penulis harus diisi',
           'jumlah_pembimbing.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_pembimbing.numeric'    => 'Jumlah Penulis harus berupa angka',
           'is_bkd.required'              => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }


        if ($request->tingkat_pkm == "internasional") {
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 2;
            }else{
                $ewmp = 1;
            }
        }else{
            if ($request->juara_ke == "1" || $request->juara_ke == "2" || $request->juara_ke == "3") {
                $ewmp = 1;
            }else{
                $ewmp = 0.5;
            }
        }
        $point = $ewmp/$request->jumlah_pembimbing;
        $data =  R012MembimbingPkm::where('id',$request->r012membimbingpkm_id_edit)->first();
        $oldData = $data->toArray();
        $update = $data->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'tingkat_pkm'       =>  $request->tingkat_pkm,
            'juara_ke'          =>  $request->juara_ke,
            'jumlah_pembimbing' =>  $request->jumlah_pembimbing,
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
            ->log(auth()->user()->nama_user. ' has updated the R12 Membimbing PKM data On ' .$dosen);

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 12 Membimbing PKM berhasil diubah',
                    'url'   =>  url('/r_012_membimbing_pkm/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 12 Membimbing PKM anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

   }
   public function delete(Request $request, R012MembimbingPkm $r012membimbingpkm){
    if (!Gate::allows('delete-r012-membimbing-pkm')) {
        abort(403);
    }

       $data =  $r012membimbingpkm->first();
       $oldData = $data->toArray();
       $delete = $r012membimbingpkm->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R12 Membimbing PKM data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 12 Membimbing PKM remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_012_membimbing_pkm')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 12 Membimbing PKM remunerasi gagal dihapus',
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

    public function verifikasi(Request $request, R012MembimbingPkm $r012membimbingpkm){

        $verifikasi=  $r012membimbingpkm->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r012membimbingpkm->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R12 Membimbing PKM data ' .$dosen);

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

    public function tolak(Request $request, R012MembimbingPkm $r012membimbingpkm){

        $verifikasi= $r012membimbingpkm->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r012membimbingpkm->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R12 Membimbing PKM data ' .$dosen);

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
