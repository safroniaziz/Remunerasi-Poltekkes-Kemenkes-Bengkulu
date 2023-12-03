<?php

namespace App\Http\Controllers;

use App\Models\NilaiEwmp;
use App\Models\KelompokRubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use Spatie\Activitylog\Traits\LogsActivity;

class NilaiEwmpController extends Controller
{
    public function index(){
        if (!Gate::allows('read-nilai-ewmp')) {
            abort(403);
        }
        $nilaiEwmps = NilaiEwmp::all();

        return view('backend/nilai_ewmps.index',[
            'nilaiEwmps'         =>  $nilaiEwmps,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-nilai-ewmp')) {
            abort(403);
        }
        $kelompokrubriks = KelompokRubrik::all();

        return view('backend/nilai_ewmps.create',compact('kelompokrubriks'));
    }

    public function store(Request $request){
        if (!Gate::allows('store-nilai-ewmp')) {
            abort(403);
        }
        $rules = [
            'kelompok_rubrik_id'   =>  'required',
            'nama_rubrik'          =>  'required',
            'nama_tabel_rubrik'    =>  'required',
            'ewmp'                 =>  'required|numeric',
        ];
        $text = [
            'kelompok_rubrik_id.required'   => 'Kelompok Rubrik harus diisi',
            'nama_rubrik.required'          => 'Nama Rubrik harus diisi',
            'nama_tabel_rubrik.required'    => 'Nama Tabel rubrik harus diisi',
            'ewmp.required'                 => 'Nilai Ewmp harus diisi',
            'ewmp.numeric'                  => 'Nilai Ewmp harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = NilaiEwmp::create([
            'kelompok_rubrik_id'        =>  $request->kelompok_rubrik_id,
            'nama_rubrik'               =>  $request->nama_rubrik,
            'slug'                      =>  Str::slug($request->nama_rubrik),
            'nama_tabel_rubrik'         =>  $request->nama_tabel_rubrik,
            'ewmp'                      =>  $request->ewmp,
            'is_active'                 =>  1,
        ]);

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($simpan)
            ->event('created')
            ->withProperties([
                'created_fields' => $simpan, // Contoh informasi tambahan
            ])
            ->log(auth()->user()->nama_user . ' has created a new ewmp.');

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, nilai ewmp baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_nilai_ewmp/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, nilai ewmp gagal disimpan']);
        }
    }
    public function edit(NilaiEwmp $nilaiewmp){
        if (!Gate::allows('edit-nilai-ewmp')) {
            abort(403);
        }
        $kelompokrubriks = KelompokRubrik::all();

        return view('backend.nilai_ewmps.edit',compact('kelompokrubriks'),[
            'nilaiewmp'   =>  $nilaiewmp,
        ]);
    }

    public function update(Request $request, NilaiEwmp $nilaiewmp){
        if (!Gate::allows('update-nilai-ewmp')) {
            abort(403);
        }
        $rules = [
            'kelompok_rubrik_id'   =>  'required',
            'nama_rubrik'          =>  'required',
            'nama_tabel_rubrik'    =>  'required',
            'ewmp'                 =>  'required|numeric',
        ];
        $text = [
            'kelompok_rubrik_id.required'   => 'Kelompok Rubrik harus diisi',
            'nama_rubrik.required'          => 'Nama Rubrik harus diisi',
            'nama_tabel_rubrik.required'    => 'Nama Tabel rubrik harus diisi',
            'ewmp.required'                 => 'Nilai Ewmp harus diisi',
            'ewmp.numeric'                  => 'Nilai Ewmp harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $oldData = $nilaiewmp->toArray();

        $update = $nilaiewmp->update([
            'kelompok_rubrik_id'        =>  $request->kelompok_rubrik_id,
            'nama_rubrik'               =>  $request->nama_rubrik,
            'nama_tabel_rubrik'         =>  $request->nama_tabel_rubrik,
            'ewmp'                      =>  $request->ewmp,
            'is_active'                 =>  1,
        ]);

        $newData = $nilaiewmp->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($nilaiewmp)
            ->event('updated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has updated the ewmp data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, nilai ewmp berhasil diubah',
                'url'   =>  url('/manajemen_nilai_ewmp/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, nilai ewmp anda gagal diubah']);
        }
    }
    public function setNonActive(NilaiEwmp $nilaiewmp){
        $oldData = $nilaiewmp->toArray();
        $update = $nilaiewmp->update([
            'is_active' =>  0,
        ]);
        $newData = $nilaiewmp->toArray();
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
                'message'    => 'Yeay, data nilai ewmp berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('nilai_ewmp')->with($notification);
        }else {
            $notification = array(
                'message'    => 'Ooopps, data nilai ewmp gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(NilaiEwmp $nilaiewmp){
        $oldData = $nilaiewmp->toArray();
        $update = $nilaiewmp->update([
            'is_active' =>  1,
        ]);
        $newData = $nilaiewmp->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($nilaiewmp)
            ->event('activated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has activated the ewmp data.');
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data nilai ewmp berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('nilai_ewmp')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data nilai ewmp gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function delete(NilaiEwmp $nilaiewmp){
        if (!Gate::allows('delete-nilai-ewmp')) {
            abort(403);
        }
        $oldData = $nilaiewmp->toArray();
        $delete = $nilaiewmp->delete();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($nilaiewmp)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user . ' has deleted the ewmp data.');
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Nilai Ewmp remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('nilai_ewmp')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, nilai ewmp remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
