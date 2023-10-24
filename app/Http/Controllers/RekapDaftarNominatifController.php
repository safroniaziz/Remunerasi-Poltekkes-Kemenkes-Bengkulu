<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\RekapDaftarNominatif;
use App\Models\RekapPerDosen;
use Illuminate\Http\Request;

class RekapDaftarNominatifController extends Controller
{
    private $periode;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
    }
    
    public function index(){
        $isRekap = RekapDaftarNominatif::where('periode_id',$this->periode->if)->get();
        if ($isRekap->count() > 0) {

        }
        else{
            $nominatifs = RekapPerDosen::with(['dosen'])->where('periode_id',$this->periode->id)->paginate(10);
        }

        // $nominatifs = RekapDaftarNominatif::
        return view('backend.laporan_nominatif.index',[
            'nominatifs'    =>  $nominatifs
        ]);
    }
}
