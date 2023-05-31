<?php

namespace App\Http\Controllers;

use App\Models\R015MenulisKaryaIlmiahDipublikasikan;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class R15MenulisKaryaIlmiahDipublikasikanController extends Controller
{
    public function index(Request $request, Pegawai $pegawai){
        if (!Gate::allows('read-r015-menulis-karya-ilmiah-dipublikasikan')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r015menuliskaryailmiahdipublikasikans = R015MenulisKaryaIlmiahDipublikasikan::orderBy('created_at','desc')->get();
        $periode = Periode::select('nama_periode')->where('is_active','1')->first();

        return view('backend/rubriks/r_015_menulis_karya_ilmiah_dipublikasikans.index',[
           'pegawais'                                    =>  $pegawais,
           'periode'                                     =>  $periode,
           'r015menuliskaryailmiahdipublikasikans'       =>  $r015menuliskaryailmiahdipublikasikans,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r015-menulis-karya-ilmiah-dipublikasikan')) {
        abort(403);
    }
       $rules = [
           'nip'             =>  'required|numeric',
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',

       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'nip.numeric'               => 'NIP harus berupa angka',
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jenis.required'            => 'Jumlah Penulis harus diisi',

       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $simpan = R015MenulisKaryaIlmiahDipublikasikan::create([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($simpan) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 15 menulis karya ilmiah dipublikasikan baru berhasil ditambahkan',
               'url'   =>  url('/r_015_menulis_karya_ilmiah_dipublikasikan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 15 menulis karya ilmiah dipublikasikan gagal disimpan']);
       }
   }
   public function edit(R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){
    if (!Gate::allows('edit-r015-menulis-karya-ilmiah-dipublikasikan')) {
        abort(403);
    }
       return $r015karyailmiahpublikasi;
   }

   public function update(Request $request, R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){
    if (!Gate::allows('update-r015-menulis-karya-ilmiah-dipublikasikan')) {
        abort(403);
    }
       $rules = [
           'nip'             =>  'required|numeric',
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',
       ];
       $text = [
           'nip.required'              => 'NIP harus dipilih',
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
           'jenis.required'            => 'Jumlah Penulis harus diisi',
       ];

       $validasi = Validator::make($request->all(), $rules, $text);
       if ($validasi->fails()) {
           return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
       }

       $periode = Periode::select('id')->where('is_active','1')->first();

       $update = R015MenulisKaryaIlmiahDipublikasikan::where('id',$request->r015karyailmiahpublikasi_id_edit)->update([
        'periode_id'        =>  $periode->id,
        'nip'               =>  $request->nip,
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'jenis'             =>  $request->jenis,
        'is_bkd'            =>  0,
        'is_verified'       =>  0,
        'point'             =>  null,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 15 menulis karya ilmiah dipublikasikan berhasil diubah',
               'url'   =>  url('/r_015_menulis_karya_ilmiah_dipublikasikan/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 15 menulis karya ilmiah dipublikasikan anda gagal diubah']);
       }
   }
   public function delete(R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){
    if (!Gate::allows('delete-r015-menulis-karya-ilmiah-dipublikasikan')) {
        abort(403);
    }
       $delete = $r015karyailmiahpublikasi->delete();
       if ($delete) {
           $notification = array(
               'message' => 'Yeay, Rubrik 15 menulis karya ilmiah dipublikasikan remunerasi berhasil dihapus',
               'alert-type' => 'success'
           );
           return redirect()->route('r_015_menulis_karya_ilmiah_dipublikasikan')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, Rubrik 15 menulis karya ilmiah dipublikasikan remunerasi gagal dihapus',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
   public function bkdSetNonActive(R015MenulisKaryaIlmiahDipublikasikan $r015menuliskaryailmiahdipublikasikan){
       $update = $r015menuliskaryailmiahdipublikasikan->update([
           'is_bkd' =>  0,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil dinonaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_015_menulis_karya_ilmiah_dipublikasikan')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal dinonaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

   public function bkdSetActive(R015MenulisKaryaIlmiahDipublikasikan $r015menuliskaryailmiahdipublikasikan){
       $update = $r015menuliskaryailmiahdipublikasikan->update([
           'is_bkd' =>  1,
       ]);
       if ($update) {
           $notification = array(
               'message' => 'Yeay, data bkd berhasil diaktifkan',
               'alert-type' => 'success'
           );
           return redirect()->route('r_015_menulis_karya_ilmiah_dipublikasikan')->with($notification);
       }else {
           $notification = array(
               'message' => 'Ooopps, data bkd gagal diaktifkan',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }
}
