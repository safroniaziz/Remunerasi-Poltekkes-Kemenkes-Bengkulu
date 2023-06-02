<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PointRubrikDosenController extends Controller
{
    public function index(){
        $dosens = Pegawai::all();
        return view('backend/point_rubrik_dosen.index');
    }
}
