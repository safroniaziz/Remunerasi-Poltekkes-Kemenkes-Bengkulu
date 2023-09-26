<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R029MemperolehPenghargaan;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R29DosenMemperolehPenghargaanController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r029memperolehpenghargaans = R029MemperolehPenghargaan::where('nip',$_SESSION['data']['kode'])
                                                                ->where('periode_id',$this->periode->id)
                                                               ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_029_memperoleh_penghargaans.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r029memperolehpenghargaans'     =>  $r029memperolehpenghargaans,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_penghargaan'       =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_penghargaan.required' => 'Judul Penghargaan harus diisi',
           'is_bkd.required'            => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "dosen_berprestasi_nasional") {
            $ewmp = 0.5;
        }else{
            $ewmp = 0.5;
        }
        $point = $ewmp;
       $simpan = R029MemperolehPenghargaan::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'judul_penghargaan' =>  $request->judul_penghargaan,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
           'keterangan'        =>  $request->keterangan,

       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 29 Memperoleh Penghargaan baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_029_memperoleh_penghargaan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 29 Memperoleh Penghargaan gagal disimpan']);
       }
   }
   public function edit($r29memperolehpenghargaan){
    return R029MemperolehPenghargaan::where('id',$r29memperolehpenghargaan)->first();
   }

   public function update(Request $request, R029MemperolehPenghargaan $r29memperolehpenghargaan){
       $rules = [
           'judul_penghargaan'       =>  'required',
           'is_bkd'                  =>  'required',
       ];
       $text = [
           'judul_penghargaan.required' => 'Judul Penghargaan harus diisi',
           'is_bkd.required'            => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jabatan == "dosen_berprestasi_nasional") {
            $ewmp = 0.5;
        }else{
            $ewmp = 0.5;
        }
        $point = $ewmp;
       $update = R029MemperolehPenghargaan::where('id',$request->r29memperolehpenghargaan_id_edit)->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_penghargaan'          =>  $request->judul_penghargaan,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
           'keterangan'                 =>  $request->keterangan,

       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Memperoleh Penghargaan diubah',
               'url'   =>  url('/dosen/r_029_memperoleh_penghargaan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Memperoleh Penghargaan gagal diubah']);
       }
   }
   public function delete($r29memperolehpenghargaan){
    $delete = R029MemperolehPenghargaan::where('id',$r29memperolehpenghargaan)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Memperoleh Penghargaan dihapus',
            'url'   =>  route('dosen.r_029_memperoleh_penghargaan'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Memperoleh Penghargaan remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R029MemperolehPenghargaan $r29memperolehpenghargaan){
        $r29memperolehpenghargaan->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R029MemperolehPenghargaan $r29memperolehpenghargaan){
        $r29memperolehpenghargaan->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
