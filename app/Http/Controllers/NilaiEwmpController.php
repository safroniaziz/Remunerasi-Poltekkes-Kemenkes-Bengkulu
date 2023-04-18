<?php

namespace App\Http\Controllers;

use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NilaiEwmpController extends Controller
{
    public function index(Request $request){
        $nama_rubrik = $request->query('nama_rubrik');
        if (!empty($nama_rubrik)) {
            $nilaiewmp = NilaiEwmp::where('nama_rubrik','LIKE','%'.$nama_rubrik.'%')
                                ->paginate(10);
        }else {
            $nilaiewmp = NilaiEwmp::paginate(10);
        }
        return view('backend/nilai_ewmps.index',[
            'nilaiewmp'         =>  $nilaiewmp,
            'nama_rubrik'       =>  $nama_rubrik,
        ]);
    }

    public function create(){
        return view('backend/nilai_ewmps.create');
    }

    public function store(Request $request){
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
            'ewmp.required'                 => 'Ewmp harus diisi',
            'ewmp.numeric'                  => 'Ewmp harus berupa angka',
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
            'is_active'                 =>  1,
        ]);

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
        return view('backend.nilaiewmps.edit',[
            'nilaiewmp'   =>  $nilaiewmp,
        ]);
    }

    public function update(Request $request, NilaiEwmp $nilaiewmp){
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
            'ewmp.required'                 => 'Ewmp harus diisi',
            'ewmp.numeric'                  => 'Ewmp harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $nilaiewmp->update([
            'kelompok_rubrik_id'        =>  $request->kelompok_rubrik_id,
            'nama_rubrik'               =>  $request->nama_rubrik,
            'slug'                      =>  Str::slug($request->nama_rubrik),
            'nama_tabel_rubrik'         =>  $request->nama_tabel_rubrik,
            'is_active'                 =>  1,
        ]);

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
        $update = $nilaiewmp->update([
            'is_active' =>  0,
        ]);
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
        $update = $nilaiewmp->update([
            'is_active' =>  1,
        ]);
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
}
