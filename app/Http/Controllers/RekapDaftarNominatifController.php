<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\RekapPerDosen;
use App\Models\RekapDaftarNominatif;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapLaporanNominatifExport;

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

    public function exportData(Request $request){
        $isRekap = RekapDaftarNominatif::where('periode_id',$this->periode->if)->get();
        if ($isRekap->count() > 0) {

        }
        else{
            $nominatifs = RekapPerDosen::with(['dosen'])->where('periode_id',$this->periode->id)->get();
        }

        return Excel::download(new RekapLaporanNominatifExport($nominatifs), 'data.xlsx');
    }
}
