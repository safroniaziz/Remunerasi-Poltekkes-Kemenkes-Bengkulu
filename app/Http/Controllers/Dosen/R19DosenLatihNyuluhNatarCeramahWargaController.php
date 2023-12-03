<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R019LatihNyuluhNatarCeramahWarga;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R19DosenLatihNyuluhNatarCeramahWargaController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r019latihnyuluhnatarceramahwargas = R019LatihNyuluhNatarCeramahWarga::where('nip',$_SESSION['data']['kode'])
                                                                            ->where('periode_id',$this->periode->id)
                                                                             ->orderBy('created_at','desc')->get();

        return view('backend/dosen/rubriks/r_019_latih_nyuluh_natar_ceramah_wargas.index',[
           'pegawais'                               =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r019latihnyuluhnatarceramahwargas'       =>  $r019latihnyuluhnatarceramahwargas,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul_kegiatan'    =>  'required',
           'jenis'             =>  'required',
           'is_bkd'            =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul_kegiatan harus diisi',
           'jenis.required'            => 'Jenis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jenis == "insidentil") {
            $ewmp = 0.50;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;
       $simpan = R019LatihNyuluhNatarCeramahWarga::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_kegiatan'    =>  $request->judul_kegiatan,
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
            ->log($_SESSION['data']['nama'] . ' has created a new R19 Latih Nyuluh Natar Ceramah Masyarakat.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_019_latih_nyuluh_natar_ceramah_warga/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat gagal disimpan']);
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
   public function edit($r019latihnyuluhnatarceramahwarga){
    return R019LatihNyuluhNatarCeramahWarga::where('id',$r019latihnyuluhnatarceramahwarga)->first();
   }

   public function update(Request $request, R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
       $rules = [
           'judul_kegiatan'  =>  'required',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul_kegiatan.required'   => 'Judul Kegiatan harus diisi',
           'jenis.required'            => 'Jenis harus diisi',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       if ($request->jenis == "insidentil") {
            $ewmp = 0.50;
        }else{
            $ewmp = 0.25;
        }
        $point = $ewmp;

        $data =  R019LatihNyuluhNatarCeramahWarga::where('id',$request->r019latihnyuluhnatarceramahwarga_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul_kegiatan'    =>  $request->judul_kegiatan,
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
            ->log($_SESSION['data']['nama'] . ' has updated the R19 Latih Nyuluh Natar Ceramah Masyarakat data.');

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat berhasil diubah',
                    'url'   =>  url('/dosen/r_019_latih_nyuluh_natar_ceramah_warga/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

   }
   public function delete($r019latihnyuluhnatarceramahwarga){

       $data =  R01PerkuliahanTeori::where('id',$r01perkuliahanteori)->first();
       $oldData = $data->toArray();
       $delete = R019LatihNyuluhNatarCeramahWarga::where('id',$r019latihnyuluhnatarceramahwarga)->delete();

       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy($dosen)
           ->performedOn($data)
           ->event('dosen_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log($_SESSION['data']['nama'] . ' has deleted the R19 Latih Nyuluh Natar Ceramah Masyarakat data.');

           if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat berhasil dihapus',
                'url'   =>  route('dosen.r_019_latih_nyuluh_natar_ceramah_warga'),
            ]);
           }else {
               $notification = array(
                   'message' => 'Ooopps, Rubrik Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat remunerasi gagal dihapus',
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

    public function verifikasi(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
        $r019latihnyuluhnatarceramahwarga->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
        $r019latihnyuluhnatarceramahwarga->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
