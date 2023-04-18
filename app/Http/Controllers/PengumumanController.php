<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function index(Request $request){
        $isi_pengumuman = $request->query('isi_pengumuman');
        if (!empty($isi_pengumuman)) {
            $pengumumans = Pengumuman::where('isi_pengumuman','LIKE','%'.$isi_pengumuman.'%')
                                ->paginate(10);

        }else {
            $pengumumans = Pengumuman::paginate(10);
        }
        return view('backend/pengumumans.index',[
            'pengumumans'         =>  $pengumumans,
            'isi_pengumuman'      =>  $isi_pengumuman,
        ]);
    }

    public function create(){
        return view('backend/pengumumans.create');
    }

    public function store(Request $request){
        $rules = [
            'isi_pengumuman'       =>  'required',
            'tanggal_pengumuman'   =>  'required|',
        ];
        $text = [
            'isi_pengumuman.required'       => 'nama Pengumuman harus diisi',
            'tanggal_pengumuman.required'   => 'tanggal Pengumuman harus diisi',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = Pengumuman::create([
            'isi_pengumuman'            =>  $request->isi_pengumuman,
            'slug'                      =>  Str::slug($request->isi_pengumuman),
            'tanggal_pengumuman'        =>  $request->tanggal_pengumuman,
            'is_active'                 =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Pengumuman baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_pengumuman/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Pengumuman gagal disimpan']);
        }
    }
    public function edit(Pengumuman $pengumuman){
        return view('backend.pengumumans.edit',[
            'pengumuman'   =>  $pengumuman,
        ]);
    }

    public function update(Request $request, Pengumuman $pengumuman){
        $rules = [
            'isi_pengumuman'       =>  'required',
            'tanggal_pengumuman'   =>  'required',
        ];
        $text = [
            'isi_pengumuman.required'          => 'isi Pengumuman harus diisi',
            'tanggal_pengumuman.required'      => 'tanggal pengumuman harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $pengumuman->update([
            'isi_pengumuman'       =>  $request->isi_pengumuman,
            'slug'                 =>  Str::slug($request->isi_pengumuman),
            'tanggal_pengumuman'   =>  $request->tanggal_pengumuman,
            'is_active'            =>  1,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Pengumuman berhasil diubah',
                'url'   =>  url('/manajemen_pengumuman/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Pengumuman anda gagal diubah']);
        }
    }
    public function setNonActive(Pengumuman $pengumuman){
        $update = $pengumuman->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data Pengumuman berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('pengumuman')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data Pengumuman gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(Pengumuman $pengumuman){
        $update = $pengumuman->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data Pengumuman berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('pengumuman')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data Pengumuman gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
