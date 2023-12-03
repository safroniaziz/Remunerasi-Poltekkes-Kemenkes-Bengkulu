<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R014KaryaInovasi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R14DosenKaryaInovasiController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r014karyainovasis = R014KaryaInovasi::where('nip',$_SESSION['data']['kode'])
                                            ->where('periode_id',$this->periode->id)
                                             ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_014_karya_inovasis.index',[
           'pegawais'                =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r014karyainovasis'       =>  $r014karyainovasis,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|regex:/^[0-9]+$/|min:0',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jumlah_penulis.min'        => 'Jumlah Penulis tidak boleh kurang dari 0',
           'jumlah_penulis.regex'      => 'Format Penulis tidak valid',
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
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
        'keterangan'        =>  $request->keterangan,

       ]);
       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($simpan)
            ->event('dosen_created')
            ->withProperties([
                'created_fields' => $simpan, // Contoh informasi tambahan
            ])
            ->log($_SESSION['data']['nama'] . ' has created a new R14 Karya Inovasi.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 14 Karya Inovasi baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_014_karya_inovasi/'),
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
   public function edit($r014karyainovasi){
    return R014KaryaInovasi::where('id',$r014karyainovasi)->first();
   }

   public function update(Request $request, R014KaryaInovasi $r014karyainovasi){
       $rules = [
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|regex:/^[0-9]+$/|min:0',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jumlah_penulis.min'        => 'Jumlah Penulis tidak boleh kurang dari 0',
           'jumlah_penulis.regex'      => 'Format Penulis tidak valid',
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
        'nip'               =>  $_SESSION['data']['kode'],
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

       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();
       if (!empty($dosen)) {
       activity()
           ->causedBy($dosen)
           ->performedOn($data)
           ->event('dosen_updated')
           ->withProperties([
               'old_data' => $oldData, // Data lama
               'new_data' => $newData, // Data baru
           ])
           ->log($_SESSION['data']['nama'] . ' has updated the R14 Karya Inovasi.');

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Karya Inovasi berhasil diubah',
                'url'   =>  url('/dosen/r_014_karya_inovasi/'),
            ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Karya Inovasi anda gagal diubah']);
            }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete($r014karyainovasi){
        $data =  R014KaryaInovasi::where('id',$r014karyainovasi)->first();
        $oldData = $data->toArray();
        $delete = R014KaryaInovasi::where('id',$r014karyainovasi)->delete();
        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($data)
            ->event('dosen_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log($_SESSION['data']['nama'] . ' has deleted the R14 Karya Inovasi data.');

            if ($delete) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Karya Inovasi berhasil dihapus',
                    'url'   =>  route('dosen.r_014_karya_inovasi'),
                ]);
               }else {
                   $notification = array(
                       'message' => 'Ooopps, Rubrik Karya Inovasi remunerasi gagal dihapus',
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

    public function verifikasi(R014KaryaInovasi $r014karyainovasi){
        $r014karyainovasi->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R014KaryaInovasi $r014karyainovasi){
        $r014karyainovasi->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
