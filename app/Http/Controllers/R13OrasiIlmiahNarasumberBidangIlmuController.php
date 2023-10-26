<?php

namespace App\Http\Controllers;

use App\Models\R013OrasiIlmiahNarasumberBidangIlmu;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R13OrasiIlmiahNarasumberBidangIlmuController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r013orasiilmiahnarasumberbidangilmus = R013OrasiIlmiahNarasumberBidangIlmu::where('nip',$request->session()->get('nip_dosen'))
                                                                                    ->where('periode_id',$this->periode->id)
                                                                                   ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_013_orasi_ilmiah_narasumber_bidang_ilmus.index',[
           'pegawais'                               =>  $pegawais,
           'periode'                                =>  $this->periode,
           'r013orasiilmiahnarasumberbidangilmus'   =>  $r013orasiilmiahnarasumberbidangilmus,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'    =>  'required',
           'tingkatan_ke'      =>  'required',
           'is_bkd'            =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul_kegiatan harus diisi',
           'tingkatan_ke.required'     => 'Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->tingkatan_ke=='internasional') {
            $point = 3;
        }elseif ($request->tingkatan_ke=='nasional') {
            $point = 2;
        }else{
            $point = 1;
        }

       $simpan = R013OrasiIlmiahNarasumberBidangIlmu::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'tingkatan_ke'      =>  $request->tingkatan_ke,
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
           ->log(auth()->user()->nama_user. ' has created a new R13 Orasi Ilmiah Narasumber Bidang Ilmu On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu baru berhasil ditambahkan',
                'url'   =>  url('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu gagal disimpan']);
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
   public function edit(R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
    if (!Gate::allows('edit-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }
       return $r013orasiilmiahnarasumber;
   }

   public function update(Request $request, R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
    if (!Gate::allows('update-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }
       $rules = [
           'judul_kegiatan'  =>  'required',
           'tingkatan_ke'    =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'tingkatan_ke.required'     => 'Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->tingkatan_ke=='internasional') {
            $point = 3;
        }elseif ($request->tingkatan_ke=='nasional') {
            $point = 2;
        }else{
            $point = 1;
        }
        $data =  R013OrasiIlmiahNarasumberBidangIlmu::where('id',$request->r013Orasiilmiahnarasumber_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_kegiatan'    =>  $request->judul_kegiatan,
        'tingkatan_ke'      =>  $request->tingkatan_ke,
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
           ->log(auth()->user()->nama_user. ' has updated the R13 Orasi Ilmiah Narasumber Bidang Ilmu data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu berhasil diubah',
                'url'   =>  url('/r_013_orasi_ilmiah_narasumber_bidang_ilmu/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu anda gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request,R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){
    if (!Gate::allows('delete-r013-orasi-ilmiah-narasumber-bidang-ilmu')) {
        abort(403);
    }

       $data =  $r013orasiilmiahnarasumber->first();
       $oldData = $data->toArray();
       $delete = $r013orasiilmiahnarasumber->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R13 Orasi Ilmiah Narasumber Bidang Ilmu data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_013_orasi_ilmiah_narasumber_bidang_ilmu')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){

        $verifikasi= $r013orasiilmiahnarasumber->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r013orasiilmiahnarasumber->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R13 Orasi Ilmiah Narasumber Bidang Ilmu data ' .$dosen);

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

    public function tolak(Request $request,R013OrasiIlmiahNarasumberBidangIlmu $r013orasiilmiahnarasumber){

        $verifikasi= $r013orasiilmiahnarasumber->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r013orasiilmiahnarasumber->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R13 Orasi Ilmiah Narasumber Bidang Ilmu data ' .$dosen);

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
