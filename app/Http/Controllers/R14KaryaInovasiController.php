<?php

namespace App\Http\Controllers;

use App\Models\R014KaryaInovasi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R14KaryaInovasiController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r014-karya-inovasi')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r014karyainovasis = R014KaryaInovasi::where('nip',$request->session()->get('nip_dosen'))
                                             ->where('periode_id',$this->periode->id)
                                             ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_014_karya_inovasis.index',[
           'pegawais'                =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r014karyainovasis'       =>  $r014karyainovasis,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r014-karya-inovasi')) {
        abort(403);
    }
       $rules = [
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jenis.required'            => 'Jumlah Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jenis == "menghasilkan_pendapatan_blu") {
            $ewmp = 5.00;
        }elseif ($request->jenis == "paten_yang_belum_dikonversi") {
            $ewmp = 4.00;
        }elseif ($request->jenis == "paten_sederhana") {
            $ewmp = 4.00;
        }else{
            $ewmp = 1.00;
        }
        if ($request->penulis_ke == "penulis_utama") {
            $point = (60/100)*$ewmp;
        }else {
            $point = ((40/100)*$ewmp)/$request->jumlah_penulis;
        }
       $simpan = R014KaryaInovasi::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
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
            ->log(auth()->user()->nama_user. ' has created a new R14 Karya Inovasi On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 14 Karya Inovasi baru berhasil ditambahkan',
                    'url'   =>  url('/r_014_karya_inovasi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 14 Karya Inovasi gagal disimpan']);
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
   public function edit(R014KaryaInovasi $r014karyainovasi){
    if (!Gate::allows('edit-r014-karya-inovasi')) {
        abort(403);
    }
       return $r014karyainovasi;
   }

   public function update(Request $request, R014KaryaInovasi $r014karyainovasi){
    if (!Gate::allows('update-r014-karya-inovasi')) {
        abort(403);
    }
       $rules = [
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jenis.required'            => 'Jumlah Penulis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jenis == "menghasilkan_pendapatan_blu") {
            $ewmp = 5.00;
        }elseif ($request->jenis == "paten_yang_belum_dikonversi") {
            $ewmp = 4.00;
        }elseif ($request->jenis == "paten_sederhana") {
            $ewmp = 4.00;
        }else{
            $ewmp = 1.00;
        }
        if ($request->penulis_ke == "penulis_utama") {
            $point = (60/100)*$ewmp;
        }else {
            $point = ((40/100)*$ewmp)/$request->jumlah_penulis;
        }
        $data =  R014KaryaInovasi::where('id',$request->r014karyainovasi_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
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
           ->log(auth()->user()->nama_user. ' has updated the R14 Karya Inovasi data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 14 Karya Inovasi berhasil diubah',
                'url'   =>  url('/r_014_karya_inovasi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 14 Karya Inovasi anda gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function delete(Request $request, R014KaryaInovasi $r014karyainovasi){
    if (!Gate::allows('delete-r014-karya-inovasi')) {
        abort(403);
    }

       $data =  $r014karyainovasi->first();
       $oldData = $data->toArray();
       $delete = $r014karyainovasi->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R14 Karya Inovasi data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 14 Karya Inovasi remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_014_karya_inovasi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 14 Karya Inovasi remunerasi gagal dihapus',
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

    public function verifikasi(Request $request, R014KaryaInovasi $r014karyainovasi){

        $verifikasi= $r014karyainovasi->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r014karyainovasi->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R14 Karya Inovasi data ' .$dosen);

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

    public function tolak(Request $request, R014KaryaInovasi $r014karyainovasi){

        $verifikasi= $r014karyainovasi->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r014karyainovasi->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R14 Karya Inovasi data ' .$dosen);

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
