<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PointRubrikDosenController extends Controller
{
    public function index(){
        $dosens = Pegawai::orderBy('total_point','desc')->get();
        return view('backend/point_rubrik_dosen.index',[
            'dosens'    =>  $dosens,
        ]);
    }
}
