<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    public function index(){
        $notification = array(
            'message' => 'Ooopps, menu laporan keuangan belum berfungsi',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}
