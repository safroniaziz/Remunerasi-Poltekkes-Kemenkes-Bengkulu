<?php

namespace App\Http\Controllers;

use App\Models\R021ReviewerEclerePenelitianDosen;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R21ReviewerEclerePenelitianDosenController extends Controller
{
    private $nilai_ewmp;
    private $periode;

    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r021_reviewer_eclere_penelitian_dosens')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r021-reviewer-eclere-penelitian-dosen')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r021reviewereclerepenelitiandosens = R021ReviewerEclerePenelitianDosen::where('nip',$request->session()->get('nip_dosen'))
                                                                                ->where('periode_id',$this->periode->id)
                                                                                ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_021_reviewer_eclere_penelitian_dosens.index',[
           'pegawais'                              =>  $pegawais,
           'periode'                               =>  $this->periode,
           'r021reviewereclerepenelitiandosens'    =>  $r021reviewereclerepenelitiandosens,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r021-reviewer-eclere-penelitian-dosen')) {
        abort(403);
    }
       $rules = [
           'judul_protokol_penelitian'   =>  'required',
           'is_bkd'                      =>  'required',
       ];
       $text = [
           'judul_protokol_penelitian.required'     => 'Judul Protokol Penelitian harus diisi',
           'is_bkd.required'                        => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $point = $this->nilai_ewmp->ewmp;

       $simpan = R021ReviewerEclerePenelitianDosen::create([
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
           ->log(auth()->user()->nama_user. ' has created a new R21 Reviewer Eclere Penelitian Dosen On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 21 Reviewer Eclere Penelitian Dosen baru berhasil ditambahkan',
                'url'   =>  url('/r_021_reviewer_eclere_penelitian_dosen/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 21 Reviewer Eclere Penelitian Dosen gagal disimpan']);
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
   public function edit(R021ReviewerEclerePenelitianDosen $r21revieweclerepenelitidosen){
    if (!Gate::allows('edit-r021-reviewer-eclere-penelitian-dosen')) {
        abort(403);
    }
       return $r21revieweclerepenelitidosen;
   }

   public function update(Request $request, R021ReviewerEclerePenelitianDosen $r21revieweclerepenelitidosen){
    if (!Gate::allows('update-r021-reviewer-eclere-penelitian-dosen')) {
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
       $data =  R021ReviewerEclerePenelitianDosen::where('id',$request->r21revieweclerepenelitidosen_id_edit)->first();
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
           ->log(auth()->user()->nama_user. ' has updated the R21 Reviewer Eclere Penelitian Dosen data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 21 Reviewer Eclere Penelitian Dosen diubah',
                'url'   =>  url('/r_021_reviewer_eclere_penelitian_dosen/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 21 Reviewer Eclere Penelitian Dosen gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function delete(Request $request,R021ReviewerEclerePenelitianDosen $r21revieweclerepenelitidosen){
    if (!Gate::allows('delete-r021-reviewer-eclere-penelitian-dosen')) {
        abort(403);
    }

       $data =  $r21revieweclerepenelitidosen->first();
       $oldData = $data->toArray();
       $delete = $r21revieweclerepenelitidosen->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R21 Reviewer Eclere Penelitian Dosen data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 21 Reviewer Eclere Penelitian Dosen remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_021_reviewer_eclere_penelitian_dosen')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 21 Reviewer Eclere Penelitian Dosen remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R021ReviewerEclerePenelitianDosen $r21revieweclerepenelitidosen){

        $verifikasi= $r21revieweclerepenelitidosen->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r21revieweclerepenelitidosen->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R21 Reviewer Eclere Penelitian Dosen data ' .$dosen);

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

    public function tolak(Request $request,R021ReviewerEclerePenelitianDosen $r21revieweclerepenelitidosen){

        $verifikasi=  $r21revieweclerepenelitidosen->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r21revieweclerepenelitidosen->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R21 Reviewer Eclere Penelitian Dosen data ' .$dosen);

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
