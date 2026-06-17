<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OauthCallbackController extends Controller
{
    public function oAuthCallback(){
        require_once app_path('Helpers/api/curl.api.php');
        require_once app_path('Helpers/api/config.php');

        date_default_timezone_set('Asia/Jakarta');
        error_reporting(E_ALL);
        ini_set('display_errors',1);

        $parameter = array(
            'action'=>'oAuthToken',
            'token'=>$_GET['token'],
        );
        $hashed_string = ApiEncController::encrypt(
            $parameter,
            $config['client_id'],
            $config['version'],
            $config['secret_key']
        );

        $data = array(
            'client_id' => $config['client_id'],
            'data' => $hashed_string,
        );

        $response = _curl_api($config['url'], json_encode($data));
        $responseData = json_decode($response, true); // Memparsing respons JSON menjadi array asosiatif

        // Pastikan respon valid dari SIAKAD
        if (!isset($responseData['data']['kode'])) {
            echo "<script>
                if (window.top !== window.self) {
                    window.top.location.href = '" . route('login') . "';
                } else {
                    window.location.href = '" . route('login') . "';
                }
            </script>";
            return;
        }

        $siakadData = $responseData['data'];
        $nip        = $siakadData['kode'];
        $nama       = $siakadData['name'];

        // ─────────────────────────────────────────────────
        // 1. Sinkronkan dengan user di tabel `users` Laravel
        // ─────────────────────────────────────────────────
        $user = User::firstOrCreate(
            ['pegawai_nip' => $nip],
            [
                'nama_user' => $nama,
                'email'     => $nip . '@poltekkes-bengkulu.ac.id',
                'password'  => bcrypt(\Illuminate\Support\Str::random(32)),
                'is_active' => 1,
            ]
        );

        // Update nama jika berbeda (misal ada perubahan di SIAKAD)
        if ($user->nama_user !== $nama) {
            $user->update(['nama_user' => $nama]);
        }

        // Berikan role 'dosen' jika belum memiliki role apapun
        if ($user->roles->isEmpty()) {
            $user->assignRole('dosen');
        }

        // ─────────────────────────────────────────────────
        // 2. Login ke Laravel Auth Guard
        // ─────────────────────────────────────────────────
        Auth::login($user, false);

        // ─────────────────────────────────────────────────
        // 3. Tetap simpan ke $_SESSION untuk kompatibilitas
        //    controller-controller dosen yang sudah ada
        // ─────────────────────────────────────────────────
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['data'] = [
            'nama'      => $siakadData['name'],
            'kode'      => $siakadData['kode'],
            'gelar'     => $siakadData['gelar']     ?? '',
            'namatitle' => $siakadData['nametitle']  ?? '',
            'nidn'      => $siakadData['nidn']       ?? '',
        ];

        echo "<script>
            if (window.top !== window.self) {
                window.top.location.href = '" . route('dosen.dashboard') . "';
            } else {
                window.location.href = '" . route('dosen.dashboard') . "';
            }
        </script>";
    }
}
