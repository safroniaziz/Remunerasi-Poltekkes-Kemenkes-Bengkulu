<?php

namespace App\Http\Controllers;

use App\Models\RiwayatJabatanDt;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class RiwayatJabatanDtController extends Controller
{
    public function index(){
        if (!Gate::allows('read-riwayat-jabatan-dt')) {
            abort(403);
        }
        $riwayatjabatandts = RiwayatJabatanDt::orderBy('created_at','desc')->get();

        return view('backend/riwayat_jabatan_dts.index',[
            'riwayatjabatandts'         =>  $riwayatjabatandts,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-riwayat-jabatan-dt')) {
            abort(403);
        }
        $dosens = Pegawai::all();

        return view('backend/riwayat_jabatan_dts.create',compact('dosens'));
    }

    public function store(Request $request){
        if (!Gate::allows('store-riwayat-jabatan-dt')) {
            abort(403);
        }
        $rules = [
            'nip'                           =>  'required',
            'nip'                           =>  'required|numeric',
            'tmt_jabatan_fungsional'        =>  'required|numeric',
        ];
        $text = [
            'nip.required'                      => 'nama Riwayat Jabatan DT harus diisi',
            'nip.required'                      => 'Nip harus dipilih',
            'nip.numeric'                       => 'Nip harus berupa angka',
            'tmt_jabatan_fungsional.required'   => 'tmt Riwayat Jabatan DT harus diisi',
            'tmt_jabatan_fungsional.numeric'    => 'tmt Riwayat Jabatan DT harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $simpan = RiwayatJabatanDt::create([
            'nip'                           =>  $request->nip,
            'slug'                          =>  Str::slug($request->nip),
            'tmt_jabatan_fungsional'        =>  $request->tmt_jabatan_fungsional,
            'is_active'                     =>  1,
        ]);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new Riwayat Riwayat Jabatan DT.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Riwayat Jabatan DT baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_riwayat_jabatan_dt/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Riwayat Jabatan DT gagal disimpan']);
        }
    }
    public function edit(RiwayatJabatandt $riwayatjabatandt){
        if (!Gate::allows('edit-riwayat-jabatan-dt')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        return view('backend.riwayat_jabatan_dts.edit',compact('dosens'),[
            'riwayatjabatandt'   =>  $riwayatjabatandt,
        ]);
    }

    public function update(Request $request, RiwayatJabatandt $riwayatjabatandt){
        if (!Gate::allows('update-riwayat-jabatan-dt')) {
            abort(403);
        }
        $rules = [
            'nip'                           =>  'required',
            'nip'                           =>  'required|numeric',
            'tmt_jabatan_fungsional'        =>  'required|numeric',
        ];
        $text = [
            'nip.required'                              => 'nama Riwayat Jabatan DT harus diisi',
            'nip.required'                              => 'Nip harus dipilih',
            'nip.numeric'                               => 'Nip harus berupa angka',
            'tmt_jabatan_fungsional.required'           => 'harga point fungsional harus diisi',
            'tmt_jabatan_fungsional.numeric'            => 'harga point fungsional harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $oldData = $riwayatjabatandt->toArray();

        $update = $riwayatjabatandt->update([
            'nip'                           =>  $request->nip,
            'slug'                          =>  Str::slug($request->nip),
            'tmt_jabatan_fungsional'        =>  $request->tmt_jabatan_fungsional,
            'is_active'                     =>  1,
        ]);
        $newData = $riwayatjabatandt->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($riwayatjabatandt)
            ->event('updated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has updated the Riwayat Jabatan DT data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Riwayat Jabatan DT berhasil diubah',
                'url'   =>  url('/manajemen_riwayat_jabatan_dt/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Riwayat Jabatan DT anda gagal diubah']);
        }
    }
    public function setNonActive(RiwayatJabatandt $riwayatjabatandt){

        $oldData = $riwayatjabatandt->toArray();
        $update = $riwayatjabatandt->update([
            'is_active' =>  0,
        ]);
        $newData = $riwayatjabatandt->toArray();
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($nilaiewmp)
        ->event('deactivated')
        ->withProperties([
            'old_data' => $oldData, // Data lama
            'new_data' => $newData, // Data baru
        ])
        ->log(auth()->user()->nama_user . ' has deactivated the ewmp data.');
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data Riwayat Jabatan DT berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('jabatan_fungsional')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data Riwayat Jabatan DT gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(RiwayatJabatandt $riwayatjabatandt){

        $oldData = $riwayatjabatandt->toArray();
        $update = $riwayatjabatandt->update([
            'is_active' =>  1,
        ]);
        $newData = $riwayatjabatandt->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($riwayatjabatandt)
            ->event('activated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has activated the ewmp data.');
            if ($update) {
                $notification = array(
                    'message' => 'Yeay, data Riwayat Jabatan DT berhasil diaktifkan',
                    'alert-type' => 'success'
                );
                return redirect()->route('jabatan_fungsional')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, data Riwayat Jabatan DT gagal diaktifkan',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
    public function delete(RiwayatJabatandt $riwayatjabatandt){
        if (!Gate::allows('delete-riwayat-jabatan-dt')) {
            abort(403);
        }

        $oldData = $riwayatjabatandt->toArray();
        $delete = $riwayatjabatandt->delete();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($riwayatjabatandt)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user . ' has deleted the Riwayat Jabatan DT  data.');
            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, Riwayat Jabatan DT remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('jabatan_fungsional')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, Riwayat Jabatan DT remunerasi gagal dihapus',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
}
