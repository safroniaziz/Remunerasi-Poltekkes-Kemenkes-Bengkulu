<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R03MembimbingPencapaianKompetensi;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;

class R03DosenMembimbingPencapaianKompetensiController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r03_membimbing_pencapaian_kompetensis')->first();
    }

    public function index(){
         $pegawais = Pegawai::all();
         $r03membimbingpencapaiankompetensis = R03MembimbingPencapaianKompetensi::where('nip',$_SESSION['data']['kode'])
                                                                                ->where('periode_id',$this->periode->id)
                                                                                ->orderBy('created_at','desc')->get();
        return view('backend/dosen/rubriks/r_03_membimbing_pencapaian_kompetensis.index',[
            'pegawais'                              =>  $pegawais,
            'periode'                               =>  $this->periode,
            'r03membimbingpencapaiankompetensis'    =>  $r03membimbingpencapaiankompetensis,
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

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $simpan = R03MembimbingPencapaianKompetensi::create([
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
            ->log($_SESSION['data']['nama'] . ' has created a new R3 Membimbing Capaian Kompetensi.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Membimbing Pencapaian Kompetensi baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_03_membimbing_pencapaian_kompetensi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Membimbing Pencapaian Kompetensi gagal disimpan']);
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
    public function edit($r03bimbingcapaiankompetensi){
        return R03MembimbingPencapaianKompetensi::where('id',$r03bimbingcapaiankompetensi)->first();
    }

    public function update(Request $request, R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
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

        $point = $this->nilai_ewmp->ewmp*$request->jumlah_mahasiswa;

        $data =  R03MembimbingPencapaianKompetensi::where('id',$request->r03membimbingpencapaiankompetensi_id_edit)->first();
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
            ->log($_SESSION['data']['nama'] . ' has updated the R3 Membimbing Capaian Kompetensi.');

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Membimbing Pencapaian Kompetensi berhasil diubah',
                    'url'   =>  url('/dosen/r_03_membimbing_pencapaian_kompetensi/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Membimbing Pencapaian Kompetensi anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function delete($r03bimbingcapaiankompetensi){


        $data =  R03MembimbingPencapaianKompetensi::where('id',$r03bimbingcapaiankompetensi)->first();
        $oldData = $data->toArray();
        $delete = R03MembimbingPencapaianKompetensi::where('id',$r03bimbingcapaiankompetensi)->delete();

        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($data)
            ->event('dosen_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log($_SESSION['data']['nama'] . ' has deleted the R01 Perkuliahan Teori data.');

            if ($delete) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Bimbingan Capaian Kompetensi berhasil dihapus',
                    'url'   =>  route('dosen.r_03_membimbing_pencapaian_kompetensi'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps,  Rubrik Bimbingan Capaian Kompetensi gagal dihapus']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function verifikasi(R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
        $r03bimbingcapaiankompetensi->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R03MembimbingPencapaianKompetensi $r03bimbingcapaiankompetensi){
        $r03bimbingcapaiankompetensi->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
