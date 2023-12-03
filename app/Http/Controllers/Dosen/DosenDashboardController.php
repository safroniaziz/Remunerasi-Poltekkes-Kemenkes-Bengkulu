<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DosenDashboardController extends Controller
{
    public function dashboard(){
        $periodeAktif = Periode::where('is_active',1)->first();
        return view('backend.dosen.dashboard',[
            'periodeAktif'   =>  $periodeAktif,
        ]);
    }

    public function loginSubmit(Request $request){
        $request->validate([
            'nip' => 'required|numeric',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('nip', 'password');

        if (Auth::guard('pegawai')->attempt($credentials)) {
            return redirect()->route('dosen.dashboard')->with(['success'    =>  'Login Successfull']);
        }else{
            return redirect('/login')->with(['error'    =>  '1']);
        }
    }
}
