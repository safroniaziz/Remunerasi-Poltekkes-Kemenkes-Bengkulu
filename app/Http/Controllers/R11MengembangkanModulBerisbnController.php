<?php

namespace App\Http\Controllers;

use App\Models\R011MengembangkanModulBerisbn;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R11MengembangkanModulBerisbnController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r011_mengembangkan_modul_berisbns')->first();
    }

    public function index(Request $request){
        if (!Gate::allows('read-r011-mengembangkan-modul-berisbn')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r011mengembangkanmodulberisbns = R011MengembangkanModulBerisbn::where('nip',$request->session()->get('nip_dosen'))
                                                                        ->where('periode_id',$this->periode->id)
                                                                       ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_011_mengembangkan_modul_berisbns.index',[
           'pegawais'                             =>  $pegawais,
           'periode'                              =>  $this->periode,
           'r011mengembangkanmodulberisbns'       =>  $r011mengembangkanmodulberisbns,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
       $rules = [
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'is_bkd'          =>  'required',

       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
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

       $simpan = R011MengembangkanModulBerisbn::create([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
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
            ->log(auth()->user()->nama_user. ' has created a new R11 Mengembangkan Modul ISBN On ' .$dosen);

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik 11 mengembangkan modul berisbn baru berhasil ditambahkan',
                    'url'   =>  url('/r_011_mengembangkan_modul_berisbn/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn gagal disimpan']);
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
   public function edit(R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
    if (!Gate::allows('edit-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
       return $r011mengembangkanmodulberisbn;
   }

   public function update(Request $request, R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
    if (!Gate::allows('update-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
       $rules = [
           'judul'           =>  'required',
           'isbn'            =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'isbn.required'             => 'ISBN harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
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
        $data =  R011MengembangkanModulBerisbn::where('id',$request->r011mengembangkanmodulberisbn_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul'             =>  $request->judul,
        'isbn'              =>  $request->isbn,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
        'is_bkd'            =>  $request->is_bkd,
        'is_verified'       =>  0,
        'point'             =>  $point,
        'keterangan'        =>  $request->keterangan,
       ]);

       if ($update) {
           return response()->json([
               'text'  =>  'Yeay, Rubrik 11 mengembangkan modul berisbn berhasil diubah',
               'url'   =>  url('/r_011_mengembangkan_modul_berisbn/'),
           ]);
       }else {
           return response()->json(['text' =>  'Oopps, Rubrik 11 mengembangkan modul berisbn anda gagal diubah']);
       }
   }
   public function delete(Request $request, R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){
    if (!Gate::allows('delete-r011-mengembangkan-modul-berisbn')) {
        abort(403);
    }
       $data =  $r011mengembangkanmodulberisbn->first();
       $oldData = $data->toArray();
       $delete = $r011mengembangkanmodulberisbn->delete();
       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R11 Mengembangkan Modul ISBN data ' .$dosen);

           if ($delete) {
            $notification = array(
                'message' => 'Yeay, Rubrik 11 mengembangkan modul berisbn remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('r_011_mengembangkan_modul_berisbn')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, Rubrik 11 mengembangkan modul berisbn remunerasi gagal dihapus',
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

    public function verifikasi(Request $request,R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){

        $verifikasi= $r011mengembangkanmodulberisbn->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r011mengembangkanmodulberisbn->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R11 Mengembangkan Modul ISBN data ' .$dosen);

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

    public function tolak(Request $request,R011MengembangkanModulBerisbn $r011mengembangkanmodulberisbn){

        $verifikasi=  $r011mengembangkanmodulberisbn->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r011mengembangkanmodulberisbn->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R11 Mengembangkan Modul ISBN data ' .$dosen);

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
