<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengumumanController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-pengumumen')) {
            abort(403);
        }
        $isi_pengumuman = $request->query('isi_pengumuman');
        if (!empty($isi_pengumuman)) {
            $pengumumans = Pengumuman::where('isi_pengumuman','LIKE','%'.$isi_pengumuman.'%')
                                ->paginate(10);

        }else {
            $pengumumans = Pengumuman::paginate(10);
        }
        return view('backend/pengumumans.index',[
            'pengumumans'    =>  $pengumumans,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-pengumumen')) {
            abort(403);
        }
        $rules = [
            'judul_pengumuman'     => 'required',
            'isi_pengumuman'       => 'required',
            'tanggal_pengumuman'   => 'required',
            'file_pengumuman'      => 'nullable|mimes:pdf|max:1024', // PDF dengan ukuran maksimal 1MB (1024 KB)
        ];
        
        $text = [
            'judul_pengumuman.required'     => 'Judul Pengumuman harus diisi',
            'isi_pengumuman.required'       => 'Isi Pengumuman harus diisi',
            'tanggal_pengumuman.required'   => 'Tanggal Pengumuman harus diisi',
            'file_pengumuman.mimes'         => 'File Pengumuman harus berupa file PDF',
            'file_pengumuman.max'           => 'File Pengumuman tidak boleh lebih dari 1MB',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $pengumumanAttributes = [
            'judul_pengumuman'            =>  $request->judul_pengumuman,
            'isi_pengumuman'            =>  $request->isi_pengumuman,
            'slug'                      =>  Str::slug($request->judul_pengumuman),
            'tanggal_pengumuman'        =>  $request->tanggal_pengumuman,
        ];

        if ($request->hasFile('file_pengumuman')) {
            $file = $request->file('file_pengumuman');
            $fileName = $file->store('file_pengumumans', 'public');
            $pengumumanAttributes['file_pengumuman'] = $fileName;
        }

        $create = Pengumuman::create($pengumumanAttributes);

        if ($create) {
            return response()->json([
                'text'  =>  'Yeay, Pengumuman baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_pengumuman/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Pengumuman gagal disimpan']);
        }
    }
    public function edit(Pengumuman $pengumuman){
        if (!Gate::allows('edit-pengumumen')) {
            abort(403);
        }
        return $pengumuman;
    }

    public function update(Request $request){
        if (!Gate::allows('update-pengumumen')) {
            abort(403);
        }
        $rules = [
            'judul_pengumuman'     => 'required',
            'isi_pengumuman'       => 'required',
            'tanggal_pengumuman'   => 'required',
            'file_pengumuman'      => 'nullable|mimes:pdf|max:1024', // PDF dengan ukuran maksimal 1MB (1024 KB)
        ];
        
        $text = [
            'judul_pengumuman.required'     => 'Judul Pengumuman harus diisi',
            'isi_pengumuman.required'       => 'Isi Pengumuman harus diisi',
            'tanggal_pengumuman.required'   => 'Tanggal Pengumuman harus diisi',
            'file_pengumuman.mimes'         => 'File Pengumuman harus berupa file PDF',
            'file_pengumuman.max'           => 'File Pengumuman tidak boleh lebih dari 1MB',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $pengumumanAttributes = [
            'judul_pengumuman'            =>  $request->judul_pengumuman,
            'isi_pengumuman'            =>  $request->isi_pengumuman,
            'slug'                      =>  Str::slug($request->judul_pengumuman),
            'tanggal_pengumuman'        =>  $request->tanggal_pengumuman,
        ];

        if ($request->hasFile('file_pengumuman')) {
            $file = $request->file('file_pengumuman');
            $fileName = $file->store('file_pengumumans', 'public');
            $pengumumanAttributes['file_pengumuman'] = $fileName;
        }

        $update = Pengumuman::where('id',$request->pengumuman_id)->update($pengumumanAttributes);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Pengumuman berhasil diubah',
                'url'   =>  url('/manajemen_pengumuman/'),
            ]);
        }else {
            return response()->json(['error'  =>  0, 'text'   =>  'Oopps, Pengumuman anda gagal diubah'],422);
        }
    }

    public function delete(Pengumuman $pengumuman){
        if (!Gate::allows('delete-pengumumen')) {
            abort(403);
        }
        $delete = $pengumuman->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, pengumuman remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('pengumuman')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, pengumuman remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function download(Pengumuman $pengumuman){
        if ($pengumuman) {
            $filePath = storage_path("app/public/{$pengumuman->file_pengumuman}");
            if (Storage::disk('public')->exists("{$pengumuman->file_pengumuman}")) {
                return response()->download($filePath);
            } else {
                // Handle file not found in storage
                abort(404);
            }
        } else {
            // Handle file record not found in the database
            abort(404);
        }
    }
    
    public function detail(Pengumuman $pengumuman){
        return view('backend.pengumumans.detail',[
            'pengumuman'    =>  $pengumuman,
        ]);
    }
}
