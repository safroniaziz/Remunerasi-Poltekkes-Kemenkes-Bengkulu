<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WelcomeController extends Controller
{
    public function home(){
        $pengumumans = Pengumuman::all();
        return view('welcome',[
            'pengumumans'   =>  $pengumumans,
        ]);
    }

    public function pengumumanDetail(Pengumuman $pengumuman){
        return view('pengumuman_detail',[
            'pengumuman'    =>  $pengumuman
        ]);
    }

    public function downloadPengumuman (Pengumuman $pengumuman){
        if ($pengumuman) {
            $filePath = storage_path("app/public/{$pengumuman->file_pengumuman}");
            if (Storage::disk('public')->exists("{$pengumuman->file_pengumuman}")) {
                return response()->download($filePath);
            } else {
                // Handle file not found in storage
                abort(404);
            }
        } else {
            // Handle file record not found in the database
            abort(404);
        }
    }
}
