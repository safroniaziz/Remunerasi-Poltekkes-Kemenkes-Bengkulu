<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index(Request $request){
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $dosens = Pegawai::where('nama','LIKE','%'.$nama.'%')
                                ->paginate(10);

        }else {
            $dosens = Pegawai::paginate(10);
        }
        return view('backend/dosens.index',[
            'dosens'    =>  $dosens,
            'nama'    =>  $nama,
        ]);
    }

    public function create(){
        return view('backend/dosens.create');
    }

    public function store(Request $request){
        $rules = [
            'nama'                  =>  'required',
            'nip'                   =>  'required|numeric|unique:pegawais',
            'nidn'                  =>  'required|numeric',
            'email'                 =>  'required|numeric|email|unique:pegawais',
            'jenis_kelamin'         =>  'required',
            'jurusan'               =>  'required',
            'nomor_rekening'        =>  'required|numeric',
            'npwp'                  =>  'required|numeric',
            'no_whatsapp'           =>  'required|numeric',
            'is_serdos'             =>  'required|numeric',
            'no_sertifikat_serdos'  =>  'numeric',
        ];
        $text = [
            'nama.required'                     => 'Nama Lengkap harus diisi',
            'nip.required'                      => 'Nip harus dipilih',  
            'nip.numeric'                       => 'Nip harus berupa angka',  
            'nip.unique'                        => 'Nip sudah digunakan',  
            'nidn.required'                     => 'Jenis Kegiatan harus dipilih',  
            'nidn.numeric '                     => 'NIDN harus berupa angka',  
            'email.required'                    => 'Email harus diisi', 
            'email.numeric'                     => 'Email harus berupa angka', 
            'email.email'                       => 'Email harus berupa email', 
            'email.unique'                      => 'Email sudah digunakan', 
            'jenis_kelamin.required'            => 'Jenis kelamin harus dipilih', 
            'jurusan.required'                  => 'Jurusan harus diisi',    
            'nomor_rekening.required'           => 'Nomor Rekening harus diisi',    
            'nomor_rekening.numeric'            => 'Nomor Rekening harus berupa angka',    
            'npwp.required'                     => 'NPWP harus diisi',   
            'npwp.numeric'                      => 'NPWP harus berupa angka',   
            'no_whatsapp.numeric'               => 'Nomor WhatsApp harus berupa angka ',   
            'is_serdos.required'                => 'Status Serdos harus dipilih',   
            'no_sertifikat_serdos.numeric'      => 'Nomor Sertifikat Serdos harus dipilih',   
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
    }

    public function setNonActive(Pegawai $dosen){
        $update = $dosen->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data dosen berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data dosen gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(Pegawai $dosen){
        $update = $dosen->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data dosen berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data dosen gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
