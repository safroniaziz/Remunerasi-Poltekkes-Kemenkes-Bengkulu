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

class R20AssessorBkdLkdController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r020_assessor_bkd_lkds')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r020-assessor-bkd-lkd')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r020assessorbkdlkds = R020AssessorBkdLkd::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_020_assessor_bkd_lkds.index',[
           'pegawais'               =>  $pegawais,
           'periode'                =>  $periode,
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
           'is_bkd.required'           => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = ($request->jumlah_dosen / 8) * $this->nilai_ewmp->ewmp;

       $simpan = R020AssessorBkdLkd::create([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jumlah_dosen'      =>  $request->jumlah_dosen,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 20 Assessor BKD LKD baru berhasil ditambahkan',
               'url'   =>  url('/r_020_assessor_bkd_lkd/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 20 Assessor BKD LKD gagal disimpan']);
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
           'is_bkd.required'       => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = ($request->jumlah_dosen / 8) * $this->nilai_ewmp->ewmp;

       $update = R020AssessorBkdLkd::where('id',$request->r020assessorbkdlkd_id_edit)->update([
           'periode_id'        =>  $periode->id,
           'nip'               =>  $request->session()->get('nip_dosen'),
           'jumlah_dosen'      =>  $request->jumlah_dosen,
           'is_bkd'            =>  $request->is_bkd,
           'is_verified'       =>  0,
           'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 20 Assessor BKD LKD diubah',
               'url'   =>  url('/r_020_assessor_bkd_lkd/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 20 Assessor BKD LKD gagal diubah']);
       }
   }
   public function delete(R020AssessorBkdLkd $r020assessorbkdlkd){
    if (!Gate::allows('delete-r020-assessor-bkd-lkd')) {
        abort(403);
    }
       $delete = $r020assessorbkdlkd->delete();
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
   }
   public function bkdSetNonActive(R020AssessorBkdLkd $r020assessorbkdlkd){
       $update = $r020assessorbkdlkd->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_020_assessor_bkd_lkd')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R020AssessorBkdLkd $r020assessorbkdlkd){
       $update = $r020assessorbkdlkd->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_020_assessor_bkd_lkd')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
