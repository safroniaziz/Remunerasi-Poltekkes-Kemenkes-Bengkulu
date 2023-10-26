<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R06MengujiUjianOsca;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;

class R06DosenMengujiUjianOscaController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r06_menguji_ujian_oscas')->first();
    }

    public function index(){
         $pegawais = Pegawai::all();
         $r06mengujiujianoscas = R06MengujiUjianOsca::where('nip',$_SESSION['data']['kode'])
                                                    ->where('periode_id',$this->periode->id)
                                                    ->orderBy('created_at','desc')->get();

            return view('backend/dosen/rubriks/r_06_menguji_ujian_oscas.index',[
                'pegawais'                =>  $pegawais,
                'periode'                 =>  $this->periode,
                'r06mengujiujianoscas'    =>  $r06mengujiujianoscas,
            ]);
        }

    public function store(Request $request){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = ($request->jumlah_mahasiswa/12)* $this->nilai_ewmp->ewmp;

        $simpan = R06MengujiUjianOsca::create([
            'periode_id'        =>  $this->periode->id,
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
            ->log($_SESSION['data']['nama'] . ' has created a new R06 Menguji Ujian Osca.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, R 06 Menguji Ujian Osca baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_06_menguji_ujian_osca/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, R06 Menguji Ujian Osca gagal disimpan']);
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
    public function edit($r06mengujiujianosca){
        return R06MengujiUjianOsca::where('id',$r06mengujiujianosca)->first();
    }

    public function update(Request $request, R06MengujiUjianOsca $r06mengujiujianosca){
        $rules = [
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
        ];
        $text = [
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
            'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
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
            'nip'               =>  $_SESSION['data']['kode'],
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
            ->log($_SESSION['data']['nama'] . ' has updated the R06 Menguji Ujian Osca data.');

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Menguji Ujian Osca berhasil diubah',
                    'url'   =>  url('/dosen/r_06_menguji_ujian_osca/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Menguji Ujian Osca anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
    public function delete($r06mengujiujianosca){
        $data =  R06MengujiUjianOsca::where('id',$r06mengujiujianosca)->first();
        $oldData = $data->toArray();
        $delete = R06MengujiUjianOsca::where('id',$r06mengujiujianosca)->delete();
        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($data)
            ->event('dosen_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log($_SESSION['data']['nama'] . ' has deleted the R06 Menguji Ujian Osca data.');

            if ($delete) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Menguji Ujian Osca berhasil dihapus',
                    'url'   =>  route('dosen.r_06_menguji_ujian_osca'),
                ]);
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

    public function verifikasi(R06MengujiUjianOsca $r06mengujiujianosca){
        $r06mengujiujianosca->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R06MengujiUjianOsca $r06mengujiujianosca){
        $r06mengujiujianosca->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
