<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R022ReviewerEclerePenelitianMhs;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R22DosenReviewerEclerePenelitianMhsController extends Controller
{
    private $nilai_ewmp;
    public function __construct()
    {
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r022_reviewer_eclere_penelitian_mhs')->first();
    }

    public function index(Request $request, Pegawai $pegawai){
        $pegawais = Pegawai::all();
        $r022reviewereclerepenelitianmhs = R022ReviewerEclerePenelitianMhs::where('nip',$_SESSION['data']['kode'])
                                                                          ->orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/dosen/rubriks/r_022_reviewer_eclere_penelitian_mhs.index',[
           'pegawais'                           =>  $pegawais,
           'periode'                            =>  $periode,
           'r022reviewereclerepenelitianmhs'    =>  $r022reviewereclerepenelitianmhs,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_protokol_penelitian'  =>  'required',
           'is_bkd'                     =>  'required',
       ];
       $text = [
           'judul_protokol_penelitian.required' => 'Judul Protokol Penelitian harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R022ReviewerEclerePenelitianMhs::create([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_protokol_penelitian'  =>  $request->judul_protokol_penelitian,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 22 Reviewer Eclere Penelitian mhs baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_022_reviewer_eclere_penelitian_mhs/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 22 Reviewer Eclere Penelitian mhs gagal disimpan']);
       }
   }
   public function edit($r22revieweclerepenelitimhs){
    return R022ReviewerEclerePenelitianMhs::where('id',$r22revieweclerepenelitimhs)->first();
   }

   public function update(Request $request, R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
       $rules = [
           'judul_protokol_penelitian'  =>  'required',
           'is_bkd'                     =>  'required',
       ];
       $text = [
           'judul_protokol_penelitian.required' => 'Judul Protokol Penelitian harus diisi',
           'is_bkd.required'                    => 'Rubrik BKD harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }
       $periode = Periode::select('id')->where('is_active','1')->first();

       $point = $this->nilai_ewmp->ewmp;

       $update = R022ReviewerEclerePenelitianMhs::where('id',$request->r22revieweclerepenelitimhs_id_edit)->update([
           'periode_id'                 =>  $periode->id,
           'nip'                        =>  $_SESSION['data']['kode'],
           'judul_protokol_penelitian'  =>  $request->judul_protokol_penelitian,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik Reviewer Eclere Penelitian mhs diubah',
               'url'   =>  url('/dosen/r_022_reviewer_eclere_penelitian_mhs/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik Reviewer Eclere Penelitian mhs gagal diubah']);
       }
   }
   public function delete($r22revieweclerepenelitimhs){
    $delete = R022ReviewerEclerePenelitianMhs::where('id',$r22revieweclerepenelitimhs)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik Reviewer Eclere Penelitian mhs dihapus',
            'url'   =>  route('dosen.r_022_reviewer_eclere_penelitian_mhs'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik Reviewer Eclere Penelitian mhs remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
        $r22revieweclerepenelitimhs->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
        $r22revieweclerepenelitimhs->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
