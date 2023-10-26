<?php

namespace App\Http\Controllers;

use App\Models\R022ReviewerEclerePenelitianMhs;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R22ReviewerEclerePenelitianMhsController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r022_reviewer_eclere_penelitian_mhs')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r022-reviewer-eclere-penelitian-mhs')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r022reviewereclerepenelitianmhs = R022ReviewerEclerePenelitianMhs::where('nip',$request->session()->get('nip_dosen'))
                                                                        ->where('periode_id',$this->periode->id)
                                                                        ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_022_reviewer_eclere_penelitian_mhs.index',[
           'pegawais'                           =>  $pegawais,
           'periode'                            =>  $this->periode,
           'r022reviewereclerepenelitianmhs'    =>  $r022reviewereclerepenelitianmhs,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
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

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R022ReviewerEclerePenelitianMhs::create([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'judul_protokol_penelitian'  =>  $request->judul_protokol_penelitian,
           'is_bkd'                     =>  $request->is_bkd,
           'is_verified'                =>  0,
           'point'                      =>  $point,
           'keterangan'                 =>  $request->keterangan,
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
            ->log(auth()->user()->nama_user. ' has created a new R22 Reviewer Eclere Penelitian Mahasiswa On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 22 Reviewer Eclere Penelitian mhs baru berhasil ditambahkan',
                    'url'   =>  url('/r_022_reviewer_eclere_penelitian_mhs/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 22 Reviewer Eclere Penelitian mhs gagal disimpan']);
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
   public function edit(R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
    if (!Gate::allows('edit-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
       return $r22revieweclerepenelitimhs;
   }

   public function update(Request $request, R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
    if (!Gate::allows('update-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
       $rules = [
           'judul_protokol_penelitian'  =>  'required',
           'is_bkd'                     =>  'required',
       ];
       $text = [
           'judul_protokol_penelitian.required' => 'Judul Protokol Penelitian harus diisi',
           'is_bkd.required'                    => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;
       $data =  R022ReviewerEclerePenelitianMhs::where('id',$request->r22revieweclerepenelitimhs_id_edit)->first();
       $oldData = $data->toArray();
       $update = $data->update([
           'periode_id'                 =>  $this->periode->id,
           'nip'                        =>  $request->session()->get('nip_dosen'),
           'judul_protokol_penelitian'  =>  $request->judul_protokol_penelitian,
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
           ->log(auth()->user()->nama_user. ' has updated the R22 Reviewer Eclere Penelitian Mahasiswa data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 22 Reviewer Eclere Penelitian mhs diubah',
                'url'   =>  url('/r_022_reviewer_eclere_penelitian_mhs/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 22 Reviewer Eclere Penelitian mhs gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function delete(Request $request,R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){
    if (!Gate::allows('delete-r022-reviewer-eclere-penelitian-mhs')) {
        abort(403);
    }
       $data =  $r22revieweclerepenelitimhs->first();
       $oldData = $data->toArray();
       $delete = $r22revieweclerepenelitimhs->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R22 Reviewer Eclere Penelitian Mahasiswa data ' .$dosen);

           $delete = $r22revieweclerepenelitimhs->delete();
           if ($delete) {
               $notification = array(
                   'message' => 'Yeay, Rubrik 22 Reviewer Eclere Penelitian mhs remunerasi berhasil dihapus',
                   'alert-type' => 'success'
               );
               return redirect()->route('r_022_reviewer_eclere_penelitian_mhs')->with($notification);
           }else {
               $notification = array(
                   'message' => 'Ooopps, Rubrik 22 Reviewer Eclere Penelitian mhs remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){

        $verifikasi=   $r22revieweclerepenelitimhs->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r22revieweclerepenelitimhs->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R22 Reviewer Eclere Penelitian Mahasiswa data ' .$dosen);

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

    public function tolak(Request $request, R022ReviewerEclerePenelitianMhs $r22revieweclerepenelitimhs){

        $verifikasi=  $r22revieweclerepenelitimhs->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r22revieweclerepenelitimhs->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R22 Reviewer Eclere Penelitian Mahasiswa data ' .$dosen);

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
