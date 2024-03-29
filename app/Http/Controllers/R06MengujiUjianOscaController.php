<?php

namespace App\Http\Controllers;

use App\Models\R06MengujiUjianOsca;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class R06MengujiUjianOscaController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r06_menguji_ujian_oscas')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r06-menguji-ujian-osca')) {
            abort(403);
        }
         $pegawais = Pegawai::all();
         $r06mengujiujianoscas = R06MengujiUjianOsca::where('nip',$request->session()->get('nip_dosen'))
                                                     ->where('periode_id',$this->periode->id)
                                                    ->orderBy('created_at','desc')->get();

         return view('backend/rubriks/r_06_menguji_ujian_oscas.index',[
            'pegawais'                =>  $pegawais,
            'periode'                 =>  $this->periode,
            'r06mengujiujianoscas'    =>  $r06mengujiujianoscas,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-r06-menguji-ujian-osca')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = ($request->jumlah_mahasiswa/12)* $this->nilai_ewmp->ewmp;

        $simpan = R06MengujiUjianOsca::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
            ->log(auth()->user()->nama_user. ' has created a new R6 Meng Ujian Osca On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, R 06 Menguji Ujian Osca baru berhasil ditambahkan',
                    'url'   =>  url('/r_06_menguji_ujian_osca/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 06 Menguji Ujian Osca gagal disimpan']);
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
    public function edit(R06MengujiUjianOsca $r06mengujiujianosca){
        if (!Gate::allows('edit-r06-menguji-ujian-osca')) {
            abort(403);
        }
        return $r06mengujiujianosca;
    }

    public function update(Request $request, R06MengujiUjianOsca $r06mengujiujianosca){
        if (!Gate::allows('update-r06-menguji-ujian-osca')) {
            abort(403);
        }
        $rules = [
            'jumlah_mahasiswa'      =>  'required|numeric',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = ($request->jumlah_mahasiswa/12)* $this->nilai_ewmp->ewmp;
        $data =  R06MengujiUjianOsca::where('id',$request->r06mengujiujianosca_id_edit)->first();
        $oldData = $data->toArray();
        $update = $data->update([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $request->session()->get('nip_dosen'),
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
            ->log(auth()->user()->nama_user. ' has updated the R6 Meng Ujian Osca data On ' .$dosen);

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, R 06 Menguji Ujian Osca berhasil diubah',
                    'url'   =>  url('/r_06_menguji_ujian_osca/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R 06 Menguji Ujian Osca anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function delete(Request $request, R06MengujiUjianOsca $r06mengujiujianosca){
        if (!Gate::allows('delete-r06-menguji-ujian-osca')) {
            abort(403);
        }

        $data =  $r06mengujiujianosca->first();
        $oldData = $data->toArray();
        $delete = $r06mengujiujianosca->delete();

        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('verifikator_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user. ' has deleted the R6 Meng Ujian Osca data ' .$dosen);

            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, R06MengujiUjianOsca remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('r_06_menguji_ujian_osca')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, R06MengujiUjianOsca remunerasi gagal dihapus',
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

    public function verifikasi(Request $request, R06MengujiUjianOsca $r06mengujiujianosca){
        $verifikasi= $r06mengujiujianosca->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r06mengujiujianosca->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R6 Meng Ujian Osca data ' .$dosen);

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

    public function tolak(Request $request, R06MengujiUjianOsca $r06mengujiujianosca){
        $verifikasi= $r06mengujiujianosca->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r06mengujiujianosca->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R6 Meng Ujian Osca data ' .$dosen);

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
