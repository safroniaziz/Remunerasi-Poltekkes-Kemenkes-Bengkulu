<?php

namespace App\Http\Controllers;

use App\Models\R027KeanggotaanSenat;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R27KeanggotaanSenatController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r027-keanggotaan-senat')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r027keanggotaansenats = R027KeanggotaanSenat::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_027_keanggotaan_senats.index',[
           'pegawais'                  =>  $pegawais,
           'periode'                   =>  $periode,
           'r027keanggotaansenats'     =>  $r027keanggotaansenats,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r027-keanggotaan-senat')) {
        abort(403);
    }
       $rules = [
           'jabatan'                 =>  'required',
       ];
       $text = [
           'jabatan.required'          => 'Jabatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.75;
        }else{
            $ewmp = 0.50;
        }
        $point = $ewmp;
       $simpan = R027KeanggotaanSenat::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jabatan'           =>  $request->jabatan,
           'is_bkd'            =>  0,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 27 Keanggotaan Senat baru berhasil ditambahkan',
               'url'   =>  url('/r_027_keanggotaan_senat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 27 Keanggotaan Senat gagal disimpan']);
       }
   }
   public function edit(R027KeanggotaanSenat $r27keanggotaansenat){
    if (!Gate::allows('edit-r027-keanggotaan-senat')) {
        abort(403);
    }
       return $r27keanggotaansenat;
   }

   public function update(Request $request, R027KeanggotaanSenat $r27keanggotaansenat){
    if (!Gate::allows('update-r027-keanggotaan-senat')) {
        abort(403);
    }
       $rules = [
           'jabatan'                 =>  'required',
       ];
       $text = [
           'jabatan.required'        => 'Jabatan harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();
        if($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }elseif ($request->jabatan == "sekretaris") {
            $ewmp = 0.75;
        }else{
            $ewmp = 0.50;
        }
        $point = $ewmp;
       $update = R027KeanggotaanSenat::where('id',$request->r27keanggotaansenat_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'jabatan'                    =>  $request->jabatan,
           'is_bkd'                     =>  0,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 27 Keanggotaan Senat diubah',
               'url'   =>  url('/r_027_keanggotaan_senat/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 27 Keanggotaan Senat gagal diubah']);
       }
   }
   public function delete(R027KeanggotaanSenat $r27keanggotaansenat){
    if (!Gate::allows('delete-r027-keanggotaan-senat')) {
        abort(403);
    }
       $delete = $r27keanggotaansenat->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 27 Keanggotaan Senat remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_027_keanggotaan_senat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 27 Keanggotaan Senat remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R027KeanggotaanSenat $r027keanggotaansenat){
       $update = $r027keanggotaansenat->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_027_keanggotaan_senat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R027KeanggotaanSenat $r027keanggotaansenat){
       $update = $r027keanggotaansenat->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_027_keanggotaan_senat')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
