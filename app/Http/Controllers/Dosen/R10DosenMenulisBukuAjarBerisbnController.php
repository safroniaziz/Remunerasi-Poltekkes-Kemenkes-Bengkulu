<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R010MenulisBukuAjarBerisbn;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;

class R10DosenMenulisBukuAjarBerisbnController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r010_menulis_buku_ajar_berisbns')->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r010menulisbukuajarberisbns = R010MenulisBukuAjarBerisbn::where('nip',$_SESSION['data']['kode'])
                                                                ->where('periode_id',$this->periode->id)
                                                                 ->orderBy('created_at','desc')->get();
        return view('backend/dosen/rubriks/r_010_menulis_buku_ajar_berisbns.index',[
           'pegawais'                          =>  $pegawais,
           'periode'                 =>  $this->periode,
           'r010menulisbukuajarberisbns'       =>  $r010menulisbukuajarberisbns,
       ]);
   }

   public function store(Request $request){
       $rules = [
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|regex:/^[0-9]+$/|min:0',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jumlah_penulis.min'        => 'Jumlah Penulis tidak boleh kurang dari 0',
           'jumlah_penulis.regex'      => 'Format Penulis tidak valid',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }

       $simpan = R010MenulisBukuAjarBerisbn::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
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
           ->log($_SESSION['data']['nama'] . ' has created a new R10 Menguji Seminar hasil Kti Lta Skripsi.');

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 10 Menulis Buku Ajar Berisbn baru berhasil ditambahkan',
                'url'   =>  url('/dosen/r_010_menulis_buku_ajar_berisbn/'),
            ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 10 Menulis Buku Ajar Berisbn gagal disimpan']);
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
   public function edit($r010menulisbukuajarberisbn){
    return R010MenulisBukuAjarBerisbn::where('id',$r010menulisbukuajarberisbn)->first();
   }

   public function update(Request $request, R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
       $rules = [
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|regex:/^[0-9]+$/|min:0',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jumlah_penulis.min'        => 'Jumlah Penulis tidak boleh kurang dari 0',
           'jumlah_penulis.regex'      => 'Format Penulis tidak valid',
           'is_bkd.required'           => 'Status rubrik harus dipilih',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

        if ($request->penulis_ke=='penulis_utama') {
            $point = 0.5 * $this->nilai_ewmp->ewmp;
        }
        else{
            $point = (0.5 * $this->nilai_ewmp->ewmp) / $request->jumlah_penulis;
        }

        $data =  R010MenulisBukuAjarBerisbn::where('id',$request->r010menulisbukuajarberisbn_id_edit)->first();
        $oldData = $data->toArray();
    $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
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
           ->log($_SESSION['data']['nama'] . ' has updated the R10 Menguji Seminar hasil Kti Lta Skripsi data.');

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Menulis Buku Ajar Berisbn berhasil diubah',
                'url'   =>  url('/dosen/r_010_menulis_buku_ajar_berisbn/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 10 Menulis Buku Ajar Berisbn anda gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete($r010menulisbukuajarberisbn){
       $data =  R010MenulisBukuAjarBerisbn::where('id',$r010menulisbukuajarberisbn)->first();
       $oldData = $data->toArray();
       $delete = R010MenulisBukuAjarBerisbn::where('id',$r010menulisbukuajarberisbn)->delete();

       $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy($dosen)
           ->performedOn($data)
           ->event('dosen_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log($_SESSION['data']['nama'] . ' has deleted the R10 Menguji Seminar hasil Kti Lta Skripsi data.');

           if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik Menulis Buku Ajar Berisbn berhasil dihapus',
                'url'   =>  route('dosen.r_010_menulis_buku_ajar_berisbn'),
            ]);
           }else {
               $notification = array(
                   'message' => 'Ooopps, Rubrik Menulis Buku Ajar Berisbn remunerasi gagal dihapus',
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

    public function verifikasi(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
        $r010menulisbukuajarberisbn->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R010MenulisBukuAjarBerisbn $r010menulisbukuajarberisbn){
        $r010menulisbukuajarberisbn->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
