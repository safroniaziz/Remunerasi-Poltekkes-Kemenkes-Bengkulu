<?php

namespace App\Http\Controllers;

use App\Models\R028MelaksanakanPengembanganDiri;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R28MelaksanakanPengembanganDiriController extends Controller
{
    private $periode;
    public function index(){
        if (!Gate::allows('read-r028-melaksanakan-pengembangan-diri')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r028melaksanakanpengembangandiris = R028MelaksanakanPengembanganDiri::where('nip',$request->session()->get('nip_dosen'))
                                                                            ->where('periode_id',$this->periode->id)
                                                                            ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_028_melaksanakan_pengembangan_diris.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $this->periode->id,
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
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri baru berhasil ditambahkan',
               'url'   =>  url('/r_028_melaksanakan_pengembangan_diri/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 28 Melaksanakan Pengembangan Diri gagal disimpan']);
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
       $update = R028MelaksanakanPengembanganDiri::where('id',$request->r28laksanakanpengembangandiri_id_edit)->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'jenis_kegiatan'             =>  $request->jenis_kegiatan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 28 Melaksanakan Pengembangan Diri diubah',
               'url'   =>  url('/r_028_melaksanakan_pengembangan_diri/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 28 Melaksanakan Pengembangan Diri gagal diubah']);
       }
   }
   public function delete(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
    if (!Gate::allows('delete-r028-melaksanakan-pengembangan-diri')) {
        abort(403);
    }
       $delete = $r28laksanakanpengembangandiri->delete();
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
   }

    public function verifikasi(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
        $r28laksanakanpengembangandiri->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R028MelaksanakanPengembanganDiri $r28laksanakanpengembangandiri){
        $r28laksanakanpengembangandiri->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
