<?php

namespace App\Http\Controllers;

use App\Models\R026PengelolaJurnalBuletin;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R26PengelolaJurnalBuletinController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r026-pengelola-jurnal-buletin')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r026pengelolajurnalbuletins = R026PengelolaJurnalBuletin::where('nip',$request->session()->get('nip_dosen'))
                                                                ->where('periode_id',$this->periode->id)
                                                                ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_026_pengelola_jurnal_buletins.index',[
           'pegawais'                        =>  $pegawais,
           'periode'                         =>  $this->periode->id,
           'r026pengelolajurnalbuletins'     =>  $r026pengelolajurnalbuletins,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'edisi_terbit'            =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jabatan.required'          => 'Jabatan harus diisi',
           'edisi_terbit.required'     => 'Edisi Terbit harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $simpan = R026PengelolaJurnalBuletin::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'    =>  $request->judul_kegiatan,
           'jabatan'           =>  $request->jabatan,
           'edisi_terbit'      =>  $request->edisi_terbit,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 26 Pengelola Jurnal Buletin baru berhasil ditambahkan',
               'url'   =>  url('/r_026_pengelola_jurnal_buletin/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 26 Pengelola Jurnal Buletin gagal disimpan']);
       }
   }
   public function edit(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
    if (!Gate::allows('edit-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       return $r26pengelolajurnalbuletin;
   }

   public function update(Request $request, R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
    if (!Gate::allows('update-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'          =>  'required',
           'jabatan'                 =>  'required',
           'edisi_terbit'            =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_kegiatan.required' => 'Judul Kegiatan harus diisi',
           'jabatan.required'        => 'Jabatan harus diisi',
           'edisi_terbit.required'   => 'Edisi Terbit harus diisi',
           'is_bkd.required'         => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "ketua") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $update = R026PengelolaJurnalBuletin::where('id',$request->r26pengelolajurnalbuletin_id_edit)->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'judul_kegiatan'             =>  $request->judul_kegiatan,
           'jabatan'                    =>  $request->jabatan,
           'edisi_terbit'               =>  $request->edisi_terbit,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 26 Pengelola Jurnal Buletin diubah',
               'url'   =>  url('/r_026_pengelola_jurnal_buletin/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 26 Pengelola Jurnal Buletin gagal diubah']);
       }
   }
   public function delete(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
    if (!Gate::allows('delete-r026-pengelola-jurnal-buletin')) {
        abort(403);
    }
       $delete = $r26pengelolajurnalbuletin->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 26 Pengelola Jurnal Buletin remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_026_pengelola_jurnal_buletin')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 26 Pengelola Jurnal Buletin remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
        $r26pengelolajurnalbuletin->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R026PengelolaJurnalBuletin $r26pengelolajurnalbuletin){
        $r26pengelolajurnalbuletin->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
