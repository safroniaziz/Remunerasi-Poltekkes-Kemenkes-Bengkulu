<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R09MengujiSeminarHasilKtiLtaSkripsi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R09DosenMengujiSeminarHasilKtiLtaSkripsiController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r09mengujiseminarhasilktiltaskripsis = R09MengujiSeminarHasilKtiLtaSkripsi::where('nip',$_SESSION['data']['kode'])
                                                                                    ->where('periode_id',$this->periode->id)
                                                                                   ->orderBy('created_at','desc')->get();
        return view('backend/dosen/rubriks/r_09_menguji_seminar_hasil_kti_lta_skripsis.index',[
           'pegawais'                                   =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r09mengujiseminarhasilktiltaskripsis'       =>  $r09mengujiseminarhasilktiltaskripsis,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
           'jenis'                 =>  'required',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
           'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
           'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
           'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
           'jenis.required'            => 'Jenis Seminar harus dipilih',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];
       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.10;
        }else{
            $ewmp = 0.13;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
       $simpan = R09MengujiSeminarHasilKtiLtaSkripsi::create([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
            ->log($_SESSION['data']['nama'] . ' has created a new R09 Menguji Seminar hasil Kti Lta Skripsi.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Menguji Seminar hasil Kti Lta Skripsi baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_09_menguji_seminar_hasil_kti_lta_skripsi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Menguji Seminar hasil Kti Lta Skripsi gagal disimpan']);
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
   public function edit($r09mengujiseminarhasil){
    return R09MengujiSeminarhasilKtiLtaSkripsi::where('id',$r09mengujiseminarhasil)->first();
   }

   public function update(Request $request, R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
       $rules = [
           'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
           'jenis'                 =>  'required',
           'is_bkd'                =>  'required',
       ];
       $text = [
           'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
           'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
           'jumlah_mahasiswa.min'      => 'Jumlah Mahasiswa tidak boleh kurang dari 0',
           'jumlah_mahasiswa.regex'    => 'Format Mahasiswa tidak valid',
           'jenis.required'            => 'Jenis Seminar harus dipilih',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];
       if ($request->jenis == "KTI" || $request->jenis == "LTA") {
            $ewmp = 0.10;
        }else{
            $ewmp = 0.13;
        }
        $point = $request->jumlah_mahasiswa * $ewmp;
       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $data =  R09MengujiSeminarHasilKtiLtaSkripsi::where('id',$request->r09mengujiseminarhasil_id_edit)->first();
       $oldData = $data->toArray();

       $update = $data->update([
           'periode_id'        =>  $this->periode->id,
           'nip'               =>  $_SESSION['data']['kode'],
           'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
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
           ->log($_SESSION['data']['nama'] . ' has updated the R09 Menguji Seminar hasil Kti Lta Skripsi data.');

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Menguji Seminar hasil Kti Lta Skripsi berhasil diubah',
                'url'   =>  url('/dosen/r_09_menguji_seminar_hasil_kti_lta_skripsi/'),
            ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Menguji Seminar hasil Kti Lta Skripsi anda gagal diubah']);
            }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete($r09mengujiseminarhasil){
       $data =  R09MengujiSeminarhasilKtiLtaSkripsi::where('id',$r09mengujiseminarhasil)->first();
       $oldData = $data->toArray();
       $delete = R09MengujiSeminarhasilKtiLtaSkripsi::where('id',$r09mengujiseminarhasil)->delete();
       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy($dosen)
           ->performedOn($data)
           ->event('dosen_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log($_SESSION['data']['nama'] . ' has deleted the R09 Menguji Seminar hasil Kti Lta Skripsi data.');

           if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Menguji Seminar hasil Kti Lta Skripsi berhasil dihapus',
                'url'   =>  route('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi'),
            ]);
           }else {
               $notification = array(
                   'message' => 'Ooopps, Rubrik Menguji Seminar hasil Kti Lta Skripsi remunerasi gagal dihapus',
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

    public function verifikasi(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
        $r09mengujiseminarhasil->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R09MengujiSeminarhasilKtiLtaSkripsi $r09mengujiseminarhasil){
        $r09mengujiseminarhasil->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
