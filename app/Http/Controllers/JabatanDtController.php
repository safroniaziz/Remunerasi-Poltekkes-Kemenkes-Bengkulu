<?php

namespace App\Http\Controllers;

use App\Models\JabatanDt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

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
            'grade'                 =>  'required|numeric',
            'harga_point_dt'        =>  'required|numeric',
            'job_value'             =>  'required|numeric',
            'pir'                   =>  'required|numeric',
            'harga_jabatan'         =>  'required|numeric',
            'gaji_blu'              =>  'required|numeric',
            'insentif_maximum'      =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_dt.required'          => 'nama jabatan dt harus diisi',
            'grade.required'                    => 'grade harus diisi',
            'grade.numeric'                     => 'grade harus berupa angka',
            'harga_point_dt.required'           => 'harga point dt harus diisi',
            'harga_point_dt.numeric'            => 'harga point dt harus berupa angka',
            'job_value.required'                => 'job value harus diisi',
            'job_value.numeric'                 => 'job value harus berupa angka',
            'pir.required'                      => 'pir harus diisi',
            'pir.numeric'                       => 'pir harus berupa angka',
            'harga_jabatan.required'            => 'harga jabatan  harus diisi',
            'harga_jabatan.numeric'             => 'harga jabatan harus berupa angka',
            'gaji_blu.required'                 => 'gaji blu harus diisi',
            'gaji_blu.numeric'                  => 'gaji blu harus berupa angka',
            'insentif_maximum.required'         => 'insentif maximum harus diisi',
            'insentif_maximum.numeric'          => 'insentif maximum harus berupa angka',
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
            'job_value'             =>  $request->job_value,
            'pir'                   =>  $request->pir,
            'harga_jabatan'         =>  $request->harga_jabatan,
            'gaji_blu'              =>  $request->gaji_blu,
            'insentif_maximum'      =>  $request->insentif_maximum,
        ]);

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
            'grade'                 =>  'required|numeric',
            'harga_point_dt'        =>  'required|numeric',
            'job_value'             =>  'required|numeric',
            'pir'                   =>  'required|numeric',
            'harga_jabatan'         =>  'required|numeric',
            'gaji_blu'              =>  'required|numeric',
            'insentif_maximum'      =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_dt.required'          => 'nama jabatan dt harus diisi',
            'grade.required'                    => 'grade harus diisi',
            'grade.numeric'                     => 'grade harus berupa angka',
            'harga_point_dt.required'           => 'harga point dt harus diisi',
            'harga_point_dt.numeric'            => 'harga point dt harus berupa angka',
            'job_value.required'                => 'job value harus diisi',
            'job_value.numeric'                 => 'job value harus berupa angka',
            'pir.required'                      => 'pir harus diisi',
            'pir.numeric'                       => 'pir harus berupa angka',
            'harga_jabatan.required'            => 'harga jabatan  harus diisi',
            'harga_jabatan.numeric'             => 'harga jabatan harus berupa angka',
            'gaji_blu.required'                 => 'gaji blu harus diisi',
            'gaji_blu.numeric'                  => 'gaji blu harus berupa angka',
            'insentif_maximum.required'         => 'insentif maximum harus diisi',
            'insentif_maximum.numeric'          => 'insentif maximum harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $jabatandt->update([
            'nama_jabatan_dt'       =>  $request->nama_jabatan_dt,
            'slug'                  =>  Str::slug($request->nama_jabatan_dt),
            'grade'                 =>  $request->grade,
            'harga_point_dt'        =>  $request->harga_point_dt,
            'job_value'             =>  $request->job_value,
            'pir'                   =>  $request->pir,
            'harga_jabatan'         =>  $request->harga_jabatan,
            'gaji_blu'              =>  $request->gaji_blu,
            'insentif_maximum'      =>  $request->insentif_maximum,
        ]);

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
        $delete = $jabatandt->delete();

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
