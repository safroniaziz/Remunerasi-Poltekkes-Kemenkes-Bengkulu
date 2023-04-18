<?php

namespace App\Http\Controllers;
use App\Models\KelompokRubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class KelompokRubrikController extends Controller
{
    public function index(Request $request){
        $nama_kelompok_rubrik = $request->query('nama_kelompok_rubrik');
        if (!empty($nama_kelompok_rubrik)) {
            $kelompokrubriks = KelompokRubrik::where('nama_kelompok_rubrik','LIKE','%'.$nama_kelompok_rubrik.'%')
                                ->paginate(10);

        }else {
            $kelompokrubriks = KelompokRubrik::paginate(10);
        }
        return view('backend/kelompok_rubriks.index',[
            'kelompokrubriks'         =>  $kelompokrubriks,
            'nama_kelompok_rubrik'    =>  $nama_kelompok_rubrik,
        ]);
    }

    public function create(){
        return view('backend/kelompok_rubriks.create');
    }

    public function store(Request $request){
        $rules = [
            'nama_kelompok_rubrik'       =>  'required',
        ];
        $text = [
            'nama_kelompok_rubrik.required'  => 'nama Kelompok Rubrik harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = KelompokRubrik::create([
            'nama_kelompok_rubrik'          =>  $request->nama_kelompok_rubrik,
            'slug'                          =>  Str::slug($request->nama_kelompok_rubrik),
            'is_active'                     =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Kelompok Rubrik baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_kelompok_rubrik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Kelompok Rubrik gagal disimpan']);
        }
    }
    public function edit(KelompokRubrik $kelompokrubrik){
        return view('backend.kelompok_rubriks.edit',[
            'kelompokrubrik'   =>  $kelompokrubrik,
        ]);
    }

    public function update(Request $request, KelompokRubrik $kelompokrubrik){
        $rules = [
            'nama_kelompok_rubrik'       =>  'required',
        ];
        $text = [
            'nama_kelompok_rubrik.required'          => 'nama Kelompok Rubrik harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $kelompokrubrik->update([
            'nama_kelompok_rubrik'       =>  $request->nama_kelompok_rubrik,
            'slug'                          =>  Str::slug($request->nama_kelompok_rubrik),
            'is_active'                     =>  1,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Kelompok Rubrik berhasil diubah',
                'url'   =>  url('/manajemen_kelompok_rubrik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Kelompok Rubrik anda gagal diubah']);
        }
    }
    public function setNonActive(KelompokRubrik $kelompokrubrik){
        $update = $kelompokrubrik->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data Kelompok Rubrik berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('kelompok_rubrik')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data kelompok rubrik gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(KelompokRubrik $kelompokrubrik){
        $update = $kelompokrubrik->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data Kelompok Rubrik berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('kelompok_rubrik')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data Kelompok Rubrik gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
