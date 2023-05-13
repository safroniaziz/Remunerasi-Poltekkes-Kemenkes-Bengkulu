<?php

namespace App\Http\Controllers;

use App\Models\JabatanFungsional;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JabatanFungsionalController extends Controller
{
    public function index(){
        $jabatanfungsionals = JabatanFungsional::get();
        return view('backend/jabatan_fungsionals.index',[
            'jabatanfungsionals'         =>  $jabatanfungsionals,
        ]);
    }

    public function create(){
        $dosens = Pegawai::all();
        return view('backend/jabatan_fungsionals.create',compact('dosens'));
    }

    public function store(Request $request){
        $rules = [
            'nama_jabatan_fungsional'       =>  'required',
            'nip'                           =>  'required|numeric',
            'tmt_jabatan_fungsional'        =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_fungsional.required'  => 'nama jabatan fungsional harus diisi',
            'nip.required'                      => 'Nip harus dipilih',
            'nip.numeric'                       => 'Nip harus berupa angka',
            'tmt_jabatan_fungsional.required'   => 'tmt jabatan fungsional harus diisi',
            'tmt_jabatan_fungsional.numeric'    => 'tmt jabatan fungsional harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $simpan = JabatanFungsional::create([
            'nip'                           =>  $request->nip,
            'nama_jabatan_fungsional'       =>  $request->nama_jabatan_fungsional,
            'slug'                          =>  Str::slug($request->nama_jabatan_fungsional),
            'tmt_jabatan_fungsional'        =>  $request->tmt_jabatan_fungsional,
            'is_active'                     =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Jabatan fungsional baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_jabatan_fungsional/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Jabatan fungsional gagal disimpan']);
        }
    }
    public function edit(JabatanFungsional $jabatanfungsional){
        $dosens = Pegawai::all();
        return view('backend.jabatan_fungsionals.edit',compact('dosens'),[
            'jabatanfungsional'   =>  $jabatanfungsional,
        ]);
    }

    public function update(Request $request, JabatanFungsional $jabatanfungsional){
        $rules = [
            'nama_jabatan_fungsional'       =>  'required',
            'nip'                           =>  'required|numeric',
            'tmt_jabatan_fungsional'        =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_fungsional.required'          => 'nama jabatan fungsional harus diisi',
            'nip.required'                              => 'Nip harus dipilih',
            'nip.numeric'                               => 'Nip harus berupa angka',
            'tmt_jabatan_fungsional.required'           => 'harga point fungsional harus diisi',
            'tmt_jabatan_fungsional.numeric'            => 'harga point fungsional harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $jabatanfungsional->update([
            'nip'                           =>  $request->nip,
            'nama_jabatan_fungsional'       =>  $request->nama_jabatan_fungsional,
            'slug'                          =>  Str::slug($request->nama_jabatan_fungsional),
            'tmt_jabatan_fungsional'        =>  $request->tmt_jabatan_fungsional,
            'is_active'                     =>  1,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, jabatan fungsional berhasil diubah',
                'url'   =>  url('/manajemen_jabatan_fungsional/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jabatan fungsional anda gagal diubah']);
        }
    }
    public function setNonActive(JabatanFungsional $jabatanfungsional){
        $update = $jabatanfungsional->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data jabatan fungsional berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('jabatan_fungsional')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data jabatan Fungsional gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(JabatanFungsional $jabatanfungsional){
        $update = $jabatanfungsional->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data jabatan Fungsional berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('jabatan_fungsional')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data jabatan Fungsional gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function delete(JabatanFungsional $jabatanfungsional){
        $delete = $jabatanfungsional->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, jabatan fungsional remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('jabatan_fungsional')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, jabatan fungsional remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
