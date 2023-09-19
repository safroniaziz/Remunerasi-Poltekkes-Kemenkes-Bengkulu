<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pesan;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\JabatanDs;
use App\Models\JabatanDt;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(){
        $periodeAktif = Periode::where('is_active',1)->first();
        $jumlahDosen = Pegawai::where('is_active',1)->count();
        $jumlahRubrik = NilaiEwmp::count();
        $jumlahJurusan = Pegawai::distinct('jurusan')->count('jurusan');
        $jumlahJabatanDt = JabatanDt::count();
        $jumlahJabatanDs = JabatanDs::count();
        $jumlahPesanBelumDibaca = Pesan::where('is_read',0)->count();
        $jumlahVerifikator = User::whereHas('roles', function ($query) {
            $query->where('name', 'verifikator');
        })->count();
        $jumlahUserRole =   3;
        return view('backend.dashboard',[
            'periodeAktif'              => $periodeAktif,
            'jumlahRubrik'              => $jumlahRubrik,
            'jumlahDosen'               => $jumlahDosen,
            'jumlahJurusan'             => $jumlahJurusan,
            'jumlahJabatanDt'           => $jumlahJabatanDt,
            'jumlahJabatanDs'           => $jumlahJabatanDs,
            'jumlahPesanBelumDibaca'    => $jumlahPesanBelumDibaca,
            'jumlahVerifikator'         => $jumlahVerifikator,
            'jumlahUserRole'            => $jumlahUserRole,
        ]);
    }
}
