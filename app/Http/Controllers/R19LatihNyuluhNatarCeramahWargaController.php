<?php

namespace App\Http\Controllers;

use App\Models\R019LatihNyuluhNatarCeramahWarga;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R19LatihNyuluhNatarCeramahWargaController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r019-latih-nyuluh-natar-ceramah-warga')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r019latihnyuluhnatarceramahwargas = R019LatihNyuluhNatarCeramahWarga::where('nip',$request->session()->get('nip_dosen'))
                                                                            ->where('periode_id',$this->periode->id)
                                                                            ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_019_latih_nyuluh_natar_ceramah_wargas.index',[
           'pegawais'                               =>  $pegawais,
           'periode'                                =>  $this->periode,
           'r019latihnyuluhnatarceramahwargas'       =>  $r019latihnyuluhnatarceramahwargas,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r019-latih-nyuluh-natar-ceramah-warga')) {
        abort(403);
    }
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
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_kegiatan'    =>  $request->judul_kegiatan,
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
           ->log(auth()->user()->nama_user. ' has created a new R19 Latih Nyuluh Natar Ceramah Masyarakat On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat baru berhasil ditambahkan',
                'url'   =>  url('/r_019_latih_nyuluh_natar_ceramah_warga/'),
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
   public function edit(R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
    if (!Gate::allows('edit-r019-latih-nyuluh-natar-ceramah-warga')) {
        abort(403);
    }
       return $r019latihnyuluhnatarceramahwarga;
   }

   public function update(Request $request, R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
    if (!Gate::allows('update-r019-latih-nyuluh-natar-ceramah-warga')) {
        abort(403);
    }
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
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul_kegiatan'    =>  $request->judul_kegiatan,
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
           ->log(auth()->user()->nama_user. ' has updated the R19 Latih Nyuluh Natar Ceramah Masyarakat data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat berhasil diubah',
                'url'   =>  url('/r_019_latih_nyuluh_natar_ceramah_warga/'),
            ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat anda gagal diubah']);
            }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request,R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){
    if (!Gate::allows('delete-r019-latih-nyuluh-natar-ceramah-warga')) {
        abort(403);
    }
       $data =  $r019latihnyuluhnatarceramahwarga->first();
       $oldData = $data->toArray();
       $delete = $r019latihnyuluhnatarceramahwarga->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R19 Latih Nyuluh Natar Ceramah Masyarakat data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_019_latih_nyuluh_natar_ceramah_warga')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){

        $verifikasi= $r019latihnyuluhnatarceramahwarga->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r019latihnyuluhnatarceramahwarga->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R19 Latih Nyuluh Natar Ceramah Masyarakat data ' .$dosen);

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

    public function tolak(Request $request,R019LatihNyuluhNatarCeramahWarga $r019latihnyuluhnatarceramahwarga){

        $verifikasi= $r019latihnyuluhnatarceramahwarga->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r019latihnyuluhnatarceramahwarga->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R19 Latih Nyuluh Natar Ceramah Masyarakat data ' .$dosen);

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
