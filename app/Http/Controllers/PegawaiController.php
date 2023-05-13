<?php

namespace App\Http\Controllers;

use App\Models\JabatanDs;
use App\Models\JabatanFungsional;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index(Request $request){
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $dosens = Pegawai::with(['jabatanFungsionals'])->where('nama','LIKE','%'.$nama.'%')
                                ->paginate(10);

        }else {
            $dosens = Pegawai::with(['jabatanFungsionals'])->paginate(10);
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
            'email'                 =>  'required|email|unique:pegawais',
            'jenis_kelamin'         =>  'required',
            'jurusan'               =>  'required',
            'nomor_rekening'        =>  'required|numeric',
            'npwp'                  =>  'required|numeric',
            'no_whatsapp'           =>  'required|numeric',
            'is_serdos'             =>  'required',
        ];
        $text = [
            'nama.required'                     => 'Nama Lengkap harus diisi',
            'nip.required'                      => 'Nip harus dipilih',  
            'nip.numeric'                       => 'Nip harus berupa angka',  
            'nip.unique'                        => 'Nip sudah digunakan',  
            'nidn.required'                     => 'Jenis Kegiatan harus dipilih',  
            'nidn.numeric '                     => 'NIDN harus berupa angka',  
            'email.required'                    => 'Email harus diisi', 
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
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = Pegawai::create([
            'nama'                  =>  $request->nama,
            'slug'                  =>  Str::slug($request->nama),
            'nip'                   =>  $request->nip,
            'nidn'                  =>  $request->nidn,
            'email'                 =>  $request->email,
            'jenis_kelamin'         =>  $request->jenis_kelamin,
            'jurusan'               =>  $request->jurusan,
            'nomor_rekening'        =>  $request->nomor_rekening,
            'npwp'                  =>  $request->npwp,
            'no_whatsapp'           =>  $request->no_whatsapp,
            'is_serdos'             =>  $request->is_serdos == 'ya' ? 1 : 0,
            'no_sertifikat_serdos'  =>  $request->no_sertifikat_serdos,
            'is_active'             =>  1,
        ]);
        
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, dosen baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_dosen/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, usulan anda gagal disimpan']);
        }
    }

    public function edit(Pegawai $pegawai){
        return view('backend.dosens.edit',[
            'pegawai'   =>  $pegawai,
        ]);
    }

    public function update(Request $request, Pegawai $pegawai){
        $rules = [
            'nama'                  =>  'required',
            'nip'                   =>  'required',
            'nidn'                  =>  'required|numeric',
            'email'                 =>  'required|email|',
            'jenis_kelamin'         =>  'required',
            'jurusan'               =>  'required',
            'nomor_rekening'        =>  'required|numeric',
            'npwp'                  =>  'required|numeric',
            'no_whatsapp'           =>  'required|numeric',
            'is_serdos'             =>  'required',
        ];
        $text = [
            'nama.required'                     => 'Nama Lengkap harus diisi',
            'nip.required'                      => 'Nip harus dipilih',  
            'nip.numeric'                       => 'Nip harus berupa angka',  
            'nip.unique'                        => 'Nip sudah digunakan',  
            'nidn.required'                     => 'Jenis Kegiatan harus dipilih',  
            'nidn.numeric '                     => 'NIDN harus berupa angka',  
            'email.required'                    => 'Email harus diisi', 
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
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $pegawai->update([
            'nama'                  =>  $request->nama,
            'slug'                  =>  Str::slug($request->nama),
            'nip'                   =>  $request->nip,
            'nidn'                  =>  $request->nidn,
            'email'                 =>  $request->email,
            'jenis_kelamin'         =>  $request->jenis_kelamin,
            'jurusan'               =>  $request->jurusan,
            'nomor_rekening'        =>  $request->nomor_rekening,
            'npwp'                  =>  $request->npwp,
            'no_whatsapp'           =>  $request->no_whatsapp,
            'is_serdos'             =>  $request->is_serdos == 'ya' ? 1 : 0,
            'no_sertifikat_serdos'  =>  $request->no_sertifikat_serdos,
            'is_active'             =>  1,
        ]);
        
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, dosen baru berhasil diubah',
                'url'   =>  url('/manajemen_data_dosen/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, usulan anda gagal diubah']);
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

    public function riwayatJabatanFungsional(Pegawai $pegawai){
        $jabatans = JabatanDs::select('nama_jabatan_ds')->whereNotIn('nama_jabatan_ds',function($query) use ($pegawai) {
            $query->select('nama_jabatan_fungsional')->from('jabatan_fungsionals')->where('nip',$pegawai->nip);
         })->get();
        return view('backend.dosens.riwayat_jabatan_fungsional',[
            'pegawai'   =>  $pegawai,
            'jabatans'  =>  $jabatans,
        ]);
    }
    
    public function storeRiwayatJabatanFungsional(Request $request, Pegawai $pegawai){
        $rules = [
            'nama_jabatan_fungsional'       =>  'required',
            'tmt_jabatan_fungsional'        =>  'required|',
        ];
        $text = [
            'nama_jabatan_fungsional.required'      => 'Nama Jabatan Fungsional harus diisi',
            'tmt_jabatan_fungsional.required'       => 'TMT Jabatan Fungsional harus diisi',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = JabatanFungsional::create([
            'nip'                       =>  $pegawai->nip,
            'nama_jabatan_fungsional'   =>  $request->nama_jabatan_fungsional,
            'slug'                      =>  Str::slug($request->nama_jabatan_fungsional),
            'tmt_jabatan_fungsional'   =>  $request->tmt_jabatan_fungsional,
            'is_active'   =>  0,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, riwayat jabatan fungsional berhasil ditambahkan',
                'url'   =>  route('dosen.riwayat_jabatan_fungsional',[$pegawai->slug]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, riwayat jabatan fungsional gagal disimpan']);
        }
    }
}
