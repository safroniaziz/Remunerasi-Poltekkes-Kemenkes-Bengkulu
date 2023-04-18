<?php

namespace App\Http\Controllers;

use App\Models\JabatanDs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JabatanDsController extends Controller
{
    public function index(Request $request){
        $nama_jabatan_ds = $request->query('nama_jabatan_ds');
        if (!empty($nama_jabatan_ds)) {
            $jabatands = JabatanDs::where('nama_jabatan_ds','LIKE','%'.$nama_jabatan_ds.'%')
                                ->paginate(10);

        }else {
            $jabatands = JabatanDs::paginate(10);
        }
        return view('backend/jabatan_ds.index',[
            'jabatands'         =>  $jabatands,
            'nama_jabatan_ds'    =>  $nama_jabatan_ds,
        ]);
    }

    public function create(){
        return view('backend/jabatan_ds.create');
    }

    public function store(Request $request){
        $rules = [
            'nama_jabatan_ds'       =>  'required',
            'grade'                 =>  'required|numeric',
            'harga_point_ds'        =>  'required|numeric',
            'job_value'             =>  'required|numeric',
            'pir'                   =>  'required|numeric',
            'harga_jabatan'         =>  'required|numeric',
            'gaji_blu'              =>  'required|numeric',
            'insentif_maximum'      =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_ds.required'          => 'nama jabatan ds harus diisi',
            'grade.required'                    => 'grade harus diisi',
            'grade.numeric'                     => 'grade harus berupa angka',
            'harga_point_ds.required'           => 'harga point ds harus diisi',
            'harga_point_ds.numeric'            => 'harga point ds harus berupa angka',
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

        $simpan = JabatanDs::create([
            'nama_jabatan_ds'       =>  $request->nama_jabatan_ds,
            'slug'                  =>  Str::slug($request->nama_jabatan_ds),
            'grade'                 =>  $request->grade,
            'harga_point_ds'        =>  $request->harga_point_ds,
            'job_value'             =>  $request->job_value,
            'pir'                   =>  $request->pir,
            'harga_jabatan'         =>  $request->harga_jabatan,
            'gaji_blu'              =>  $request->gaji_blu,
            'insentif_maximum'      =>  $request->insentif_maximum,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Jabatan Ds baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_jabatan_ds/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Jabatan Ds gagal disimpan']);
        }
    }
    public function edit(Jabatands $jabatands){
        return view('backend.jabatan_ds.edit',[
            'jabatands'   =>  $jabatands,
        ]);
    }

    public function update(Request $request, Jabatands $jabatands){
        $rules = [
            'nama_jabatan_ds'       =>  'required',
            'grade'                 =>  'required|numeric',
            'harga_point_ds'        =>  'required|numeric',
            'job_value'             =>  'required|numeric',
            'pir'                   =>  'required|numeric',
            'harga_jabatan'         =>  'required|numeric',
            'gaji_blu'              =>  'required|numeric',
            'insentif_maximum'      =>  'required|numeric',
        ];
        $text = [
            'nama_jabatan_ds.required'          => 'nama jabatan ds harus diisi',
            'grade.required'                    => 'grade harus diisi',
            'grade.numeric'                     => 'grade harus berupa angka',
            'harga_point_ds.required'           => 'harga point ds harus diisi',
            'harga_point_ds.numeric'            => 'harga point ds harus berupa angka',
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

        $update = $jabatands->update([
            'nama_jabatan_ds'       =>  $request->nama_jabatan_ds,
            'slug'                  =>  Str::slug($request->nama_jabatan_ds),
            'grade'                 =>  $request->grade,
            'harga_point_ds'        =>  $request->harga_point_ds,
            'job_value'             =>  $request->job_value,
            'pir'                   =>  $request->pir,
            'harga_jabatan'         =>  $request->harga_jabatan,
            'gaji_blu'              =>  $request->gaji_blu,
            'insentif_maximum'      =>  $request->insentif_maximum,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, jabatan ds berhasil diubah',
                'url'   =>  url('/manajemen_jabatan_ds/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jabatan ds anda gagal diubah']);
        }
    }
}
