<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapDaftarNominatifController extends Controller
{
    public function index(){
        $notification = array(
            'message' => 'Ooopps, menu laporan daftar nominatif belum berfungsi',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}
