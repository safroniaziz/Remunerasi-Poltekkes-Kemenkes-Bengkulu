<?php

namespace App\Http\Controllers;

use App\Models\PangkatGolongan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class PangkatGolonganController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-pangkat-golongan')) {
            abort(403);
        }
        $nama_pangkat = $request->query('nama_pangkat');
        if (!empty($nama_pangkat)) {
            $pangkatgolongans = PangkatGolongan::where('nama_pangkat','LIKE','%'.$nama_pangkat.'%')
                                ->paginate(10);

        }else {
            $pangkatgolongans = PangkatGolongan::paginate(10);
        }
        return view('backend/pangkat_golongans.index',[
            'pangkatgolongans'         =>  $pangkatgolongans,
            'nama_pangkat'    =>  $nama_pangkat,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-pangkat-golongan')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        return view('backend/pangkat_golongans.create',compact('dosens'));
    }

    public function store(Request $request){
        if (!Gate::allows('store-pangkat-golongan')) {
            abort(403);
        }
        $rules = [
            'nip'                         =>  'required|numeric',
            'nama_pangkat'                =>  'required',
            'golongan'                    =>  'required',
            'tmt_pangkat_golongan'        =>  'required|numeric',
        ];
        $text = [
            'nama_pangkat.required'             => 'nama jabatan fungsional harus diisi',
            'nip.required'                      => 'Nip harus dipilih',
            'nip.numeric'                       => 'Nip harus berupa angka',
            'golongan.required'                 => 'golongan harus diisi',
            'tmt_pangkat_golongan.required'     => 'tmt jabatan fungsional harus diisi',
            'tmt_pangkat_golongan.numeric'      => 'tmt jabatan fungsional harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = PangkatGolongan::create([
            'nip'                           =>  $request->nip,
            'nama_pangkat'                  =>  $request->nama_pangkat,
            'slug'                          =>  Str::slug($request->nama_pangkat),
            'golongan'                      =>  $request->golongan,
            'tmt_pangkat_golongan'          =>  $request->tmt_pangkat_golongan,
            'is_active'                     =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Jabatan fungsional baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_pangkat_golongan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Jabatan fungsional gagal disimpan']);
        }
    }
    public function edit(PangkatGolongan $pangkatgolongan){
        if (!Gate::allows('edit-pangkat-golongan')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        return view('backend.pangkat_golongans.edit',compact('dosens'),[
            'pangkatgolongan'   =>  $pangkatgolongan,
        ]);
    }

    public function update(Request $request, PangkatGolongan $pangkatgolongan){
        if (!Gate::allows('update-pangkat-golongan')) {
            abort(403);
        }
        $rules = [
            'nama_pangkat'                =>  'required',
            'nip'                         =>  'required|numeric',
            'golongan'                    =>  'required',
            'tmt_pangkat_golongan'        =>  'required|numeric',
        ];
        $text = [
            'nama_pangkat.required'                   => 'nama jabatan fungsional harus diisi',
            'nip.required'                            => 'Nip harus dipilih',
            'nip.numeric'                             => 'Nip harus berupa angka',
            'golongan.required'                       => 'golongan harus diisi',
            'tmt_pangkat_golongan.required'           => 'harga point fungsional harus diisi',
            'tmt_pangkat_golongan.numeric'            => 'harga point fungsional harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $pangkatgolongan->update([
            'nip'                           =>  $request->nip,
            'nama_pangkat'                  =>  $request->nama_pangkat,
            'slug'                          =>  Str::slug($request->nama_pangkat),
            'golongan'                      =>  $request->golongan,
            'tmt_pangkat_golongan'          =>  $request->tmt_pangkat_golongan,
            'is_active'                     =>  1,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, jabatan fungsional berhasil diubah',
                'url'   =>  url('/manajemen_pangkat_golongan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jabatan fungsional anda gagal diubah']);
        }
    }
    public function setNonActive(PangkatGolongan $pangkatgolongan){
        $update = $pangkatgolongan->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data jabatan fungsional berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('pangkat_golongan')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data jabatan Fungsional gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(PangkatGolongan $pangkatgolongan){
        $update = $pangkatgolongan->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data jabatan Fungsional berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('pangkat_golongan')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data jabatan Fungsional gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function delete(PangkatGolongan $pangkatgolongan){
        if (!Gate::allows('delete-pangkat-golongan')) {
            abort(403);
        }
        $delete = $pangkatgolongan->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, jabatan fungsional remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('pangkat_golongan')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, jabatan fungsional remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
