<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller
{
    public function cariDosen(Request $request){
        $dosen = Pegawai::where('nip',$request->session()->get('nip_dosen'))->first();
        return view('backend.cari_dosen',[
            'dosen' =>  $dosen,
        ]);
    }

    public function removeSession(Request $request){
        $request->session()->forget('nama_dosen');
        $request->session()->forget('nip_dosen');
        $request->session()->forget('jurusan');

        return redirect()->route('cari_dosen');
    }

    public function getDataDosen(Request $request){
        $keyword = $request->keyword;
        $dataDosen = Pegawai::where('nip','LIKE','%'.$keyword.'%')
                            ->orWhere('nama','LIKE','%'.$keyword.'%')->get();
        return $dataDosen;
    }

    public function cari(Request $request){
        $rules = [
            'dosen'                     =>  'required',
        ];
        $text = [
            'dosen.required'              => 'Silahkan cari nama/nip dosen terlebih dahulu',
        ];
 
        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            $error = array(
                'message' => 'Ooopps, '.$validasi->errors()->first(),
                'alert-type' => 'error'
            );
            return redirect()->route('cari_dosen')->with($error);
        }
        
        $dosen = Pegawai::where('nip',$request->dosen_nip)->first();
        $request->session()->put('nama_dosen',$dosen->nama);
        $request->session()->put('nip_dosen',$dosen->nip);
        $request->session()->put('jurusan',$dosen->jurusan);

        $success = array(
            'message' => 'Berhasil, data dosen berhasil ditemukan',
            'alert-type' => 'success'
        );
        return redirect()->route('cari_dosen')->with($success);
    }
}