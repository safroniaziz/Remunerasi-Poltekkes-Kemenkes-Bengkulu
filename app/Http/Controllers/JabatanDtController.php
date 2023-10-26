<?php

namespace App\Http\Controllers;

use App\Models\JabatanDt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class JabatanDtController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-jabatan-dt')) {
            abort(403);
        }
        $jabatandts = JabatanDt::orderBy('created_at','desc')->get();

        return view('backend/jabatan_dts.index',[
            'jabatandts'         =>  $jabatandts,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-jabatan-dt')) {
            abort(403);
        }
        return view('backend/jabatan_dts.create');
    }

    public function store(Request $request){
        if (!Gate::allows('store-jabatan-dt')) {
            abort(403);
        }
        $rules = [
            'nama_jabatan_dt'       =>  'required',
            'grade'                 =>  'required',
            'harga_point_dt'        =>  'required|numeric',
            'gaji_blu'              =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_dt.required'          => 'nama jabatan dt harus diisi',
            'grade.required'                    => 'grade harus diisi',
            'harga_point_dt.required'           => 'harga point dt harus diisi',
            'harga_point_dt.numeric'            => 'harga point dt harus berupa angka',
            'gaji_blu.required'                 => 'gaji blu harus diisi',
            'gaji_blu.numeric'                  => 'gaji blu harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = JabatanDt::create([
            'nama_jabatan_dt'       =>  $request->nama_jabatan_dt,
            'slug'                  =>  Str::slug($request->nama_jabatan_dt),
            'grade'                 =>  $request->grade,
            'harga_point_dt'        =>  $request->harga_point_dt,
            'gaji_blu'              =>  $request->gaji_blu,
        ]);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new Jabatan DT.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Jabatan DT baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_jabatan_dt/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Jabatan DT gagal disimpan']);
        }
    }
    public function edit(JabatanDt $jabatandt){
        if (!Gate::allows('edit-jabatan-dt')) {
            abort(403);
        }
        return view('backend.jabatan_dts.edit',[
            'jabatandt'   =>  $jabatandt,
        ]);
    }

    public function update(Request $request, JabatanDt $jabatandt){
        if (!Gate::allows('update-jabatan-dt')) {
            abort(403);
        }
        $rules = [
            'nama_jabatan_dt'       =>  'required',
            'grade'                 =>  'required',
            'harga_point_dt'        =>  'required|numeric',
            'gaji_blu'              =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_dt.required'          => 'nama jabatan dt harus diisi',
            'grade.required'                    => 'grade harus diisi',
            'harga_point_dt.required'           => 'harga point dt harus diisi',
            'harga_point_dt.numeric'            => 'harga point dt harus berupa angka',
            'gaji_blu.required'                 => 'gaji blu harus diisi',
            'gaji_blu.numeric'                  => 'gaji blu harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $oldData = $jabatandt->toArray();

        $update = $jabatandt->update([
            'nama_jabatan_dt'       =>  $request->nama_jabatan_dt,
            'slug'                  =>  Str::slug($request->nama_jabatan_dt),
            'grade'                 =>  $request->grade,
            'harga_point_dt'        =>  $request->harga_point_dt,
            'gaji_blu'              =>  $request->gaji_blu,
        ]);

        $newData = $jabatandt->toArray();

        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($jabatandt)
        ->event('updated')
        ->withProperties([
            'old_data' => $oldData, // Data lama
            'new_data' => $newData, // Data baru
        ])
        ->log(auth()->user()->nama_user . ' has updated the jabatan dt data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, jabatan dt berhasil diubah',
                'url'   =>  url('/manajemen_jabatan_dt/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jabatan dt anda gagal diubah']);
        }
    }
    public function delete(Jabatandt $jabatandt){
        if (!Gate::allows('delete-jabatan-dt')) {
            abort(403);
        }

        $oldData = $jabatandt->toArray();
        $delete = $jabatandt->delete();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($jabatandt)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user . ' has deleted the jabatan dt data.');
            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, jabatan dt remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('jabatan_dt')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, jabatan dt remunerasi gagal dihapus',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
}

