<?php

namespace App\Http\Controllers;

use App\Models\R015MenulisKaryaIlmiahDipublikasikan;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class R15MenulisKaryaIlmiahDipublikasikanController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    public function index(Request $request){
        if (!Gate::allows('read-r015-menulis-karya-ilmiah-dipublikasikan')) {
            abort(403);
        }
        $pegawais = Pegawai::all();
        $r015menuliskaryailmiahdipublikasikans = R015MenulisKaryaIlmiahDipublikasikan::where('nip',$request->session()->get('nip_dosen'))
                                                                                    ->where('periode_id',$this->periode->id)
                                                                                    ->orderBy('created_at','desc')->get();

        return view('backend/rubriks/r_015_menulis_karya_ilmiah_dipublikasikans.index',[
           'pegawais'                                    =>  $pegawais,
           'periode'                                     =>  $this->periode,
           'r015menuliskaryailmiahdipublikasikans'       =>  $r015menuliskaryailmiahdipublikasikans,
       ]);
   }

   public function store(Request $request){
    if (!Gate::allows('store-r015-menulis-karya-ilmiah-dipublikasikan')) {
        abort(403);
    }
       $rules = [
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
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
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
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
           ->log(auth()->user()->nama_user. ' has created a new R15 Menulis Karya Ilmiah Dipublikasi On ' .$dosen);

           if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 15 menulis karya ilmiah dipublikasikan baru berhasil ditambahkan',
                'url'   =>  url('/r_015_menulis_karya_ilmiah_dipublikasikan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 15 menulis karya ilmiah dipublikasikan gagal disimpan']);
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
           'judul'           =>  'required',
           'penulis_ke'      =>  'required',
           'jumlah_penulis'  =>  'required|numeric',
           'jenis'           =>  'required',
           'is_bkd'          =>  'required',
       ];
       $text = [
           'judul.required'            => 'Judul harus diisi',
           'penulis_ke.required'       => 'Penulis harus diisi',
           'jumlah_penulis.required'   => 'Jumlah Penulis harus diisi',
           'jumlah_penulis.numeric'    => 'Jumlah Penulis harus berupa angka',
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
        $data =  R015MenulisKaryaIlmiahDipublikasikan::where('id',$request->r015karyailmiahpublikasi_id_edit)->first();
        $oldData = $data->toArray();
       $update = $data->update([
        'periode_id'        =>  $this->periode->id,
        'nip'               =>  $request->session()->get('nip_dosen'),
        'judul'             =>  $request->judul,
        'penulis_ke'        =>  $request->penulis_ke,
        'jumlah_penulis'    =>  $request->jumlah_penulis,
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
           ->log(auth()->user()->nama_user. ' has updated the R15 Menulis Karya Ilmiah Dipublikasi data On ' .$dosen);

           if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Rubrik 15 menulis karya ilmiah dipublikasikan berhasil diubah',
                'url'   =>  url('/r_015_menulis_karya_ilmiah_dipublikasikan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Rubrik 15 menulis karya ilmiah dipublikasikan anda gagal diubah']);
        }
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }

   }
   public function delete(Request $request, R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){
    if (!Gate::allows('delete-r015-menulis-karya-ilmiah-dipublikasikan')) {
        abort(403);
    }
       $data =  $r015karyailmiahpublikasi->first();
       $oldData = $data->toArray();
       $delete = $r015karyailmiahpublikasi->delete();

       $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();

       if (!empty($dosen)) {
           activity()
           ->causedBy(auth()->user()->id)
           ->performedOn($data)
           ->event('verifikator_deleted')
           ->withProperties([
               'old_data' => $oldData, // Data lama
           ])
           ->log(auth()->user()->nama_user. ' has deleted the R15 Menulis Karya Ilmiah Dipublikasi data ' .$dosen);

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
       }else{
           $notification = array(
               'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
   }

    public function verifikasi(Request $request, R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){

        $verifikasi=  $r015karyailmiahpublikasi->update([
            'is_verified'   =>  1,
        ]);

        $data =  $r015karyailmiahpublikasi->first();
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
            ->log(auth()->user()->nama_user. ' has Verified the R15 Menulis Karya Ilmiah Dipublikasi data ' .$dosen);

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

    public function tolak(Request $request, R015MenulisKaryaIlmiahDipublikasikan $r015karyailmiahpublikasi){

        $verifikasi= $r015karyailmiahpublikasi->update([
            'is_verified'   =>  0,
        ]);

        $data =  $r015karyailmiahpublikasi->first();
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
            ->log(auth()->user()->nama_user. ' has Cancel Verification the R15 Menulis Karya Ilmiah Dipublikasi data ' .$dosen);

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
