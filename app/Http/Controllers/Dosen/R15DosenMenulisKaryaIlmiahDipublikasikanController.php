<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\R015MenulisKaryaIlmiahDipublikasikan;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R15DosenMenulisKaryaIlmiahDipublikasikanController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }

    public function index(){
        $pegawais = Pegawai::all();
        $r015menuliskaryailmiahdipublikasikans = R015MenulisKaryaIlmiahDipublikasikan::where('nip',$_SESSION['data']['kode'])
                                                                                    ->where('periode_id',$this->periode->id)
                                                                                     ->orderBy('created_at','desc')->get();
        return view('backend/dosen/rubriks/r_015_menulis_karya_ilmiah_dipublikasikans.index',[
           'pegawais'                                    =>  $pegawais,
           'r015menuliskaryailmiahdipublikasikans'       =>  $r015menuliskaryailmiahdipublikasikans,
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

        if ($request->jenis == "Q1") {
            $ewmp = 15.00;
        }elseif ($request->jenis == "Q2") {
            $ewmp = 10.00;
        }elseif ($request->jenis == "Q3") {
            $ewmp = 8.00;
        }elseif ($request->jenis == "Q4") {
            $ewmp = 6.00;
        }elseif ($request->jenis == "sinta_1") {
            $ewmp = 10.00;
        }elseif ($request->jenis == "sinta_2") {
            $ewmp = 8.00;
        }elseif ($request->jenis == "sinta_3") {
            $ewmp = 6.00;
        }elseif ($request->jenis == "sinta_4") {
            $ewmp = 4.00;
        }elseif ($request->jenis == "sinta_5") {
            $ewmp = 2.00;
        }elseif ($request->jenis == "sinta_6") {
            $ewmp = 1.00;
        }elseif ($request->jenis == "oral_presentation_internasional") {
            $ewmp = 2.00;
        }elseif ($request->jenis == "oral_presentation_nasional") {
            $ewmp = 1.00;
        }elseif ($request->jenis == "poster_internasional") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.50;
        }
        if ($request->penulis_ke == "penulis_utama") {
            $point = (60/100)*$ewmp;
        }else {
            $point = ((40/100)*$ewmp)/$request->jumlah_penulis;
        }
       $simpan = R015MenulisKaryaIlmiahDipublikasikan::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 15 menulis karya ilmiah dipublikasikan baru berhasil ditambahkan',
               'url'   =>  url('/dosen/r_015_menulis_karya_ilmiah_dipublikasikan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 15 menulis karya ilmiah dipublikasikan gagal disimpan']);
       }
   }
   public function edit($r015karyailmiahpublikasi){
    return R015MenulisKaryaIlmiahDipublikasikan::where('id',$r015karyailmiahpublikasi)->first();
   }

   public function update(Request $request, R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){
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
       
        if ($request->jenis == "Q1") {
            $ewmp = 15.00;
        }elseif ($request->jenis == "Q2") {
            $ewmp = 10.00;
        }elseif ($request->jenis == "Q3") {
            $ewmp = 8.00;
        }elseif ($request->jenis == "Q4") {
            $ewmp = 6.00;
        }elseif ($request->jenis == "sinta_1") {
            $ewmp = 10.00;
        }elseif ($request->jenis == "sinta_2") {
            $ewmp = 8.00;
        }elseif ($request->jenis == "sinta_3") {
            $ewmp = 6.00;
        }elseif ($request->jenis == "sinta_4") {
            $ewmp = 4.00;
        }elseif ($request->jenis == "sinta_5") {
            $ewmp = 2.00;
        }elseif ($request->jenis == "sinta_6") {
            $ewmp = 1.00;
        }elseif ($request->jenis == "oral_presentation_internasional") {
            $ewmp = 2.00;
        }elseif ($request->jenis == "oral_presentation_nasional") {
            $ewmp = 1.00;
        }elseif ($request->jenis == "poster_internasional") {
            $ewmp = 1.00;
        }else{
            $ewmp = 0.50;
        }
        if ($request->penulis_ke == "penulis_utama") {
            $point = (60/100)*$ewmp;
        }else {
            $point = ((40/100)*$ewmp)/$request->jumlah_penulis;
        }
       $update = R015MenulisKaryaIlmiahDipublikasikan::where('id',$request->r015karyailmiahpublikasi_id_edit)->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $_SESSION['data']['kode'],
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 15 menulis karya ilmiah dipublikasikan berhasil diubah',
               'url'   =>  url('/dosen/r_015_menulis_karya_ilmiah_dipublikasikan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik menulis karya ilmiah dipublikasikan anda gagal diubah']);
       }
   }
   public function delete($r015karyailmiahpublikasi){
    $delete = R015MenulisKaryaIlmiahDipublikasikan::where('id',$r015karyailmiahpublikasi)->delete();
       if ($delete) {
        return response()->json([
            'text'  =>  'Yeay, Rubrik menulis karya ilmiah dipublikasikan berhasil dihapus',
            'url'   =>  route('dosen.r_015_menulis_karya_ilmiah_dipublikasikan'),
        ]);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik menulis karya ilmiah dipublikasikan remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){
        $r015karyailmiahpublikasi->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){
        $r015karyailmiahpublikasi->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
