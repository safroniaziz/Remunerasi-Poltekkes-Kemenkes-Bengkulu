<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\RekapDaftarNominatif;
use App\Models\RekapPerDosen;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;

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
            activity()
            ->causedBy(auth()->user()->id)
            ->event('accessed')
            ->log(auth()->user()->name . ' has accessed the Rekap Daftar Nominatif value page.');
        return view('backend.laporan_nominatif.index',[
            'nominatifs'    =>  $nominatifs
        ]);
    }
}
