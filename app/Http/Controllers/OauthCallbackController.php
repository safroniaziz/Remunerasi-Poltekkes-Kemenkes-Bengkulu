<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $data = json_decode($response, true); // Memparsing respons JSON menjadi array asosiatif
        $name = $data['data']['name']; // Mengakses nilai "name" dari array $data

        session_start();
        $_SESSION['data'] = [
            'nama'      => $data['data']['name'],
            'kode'      => $data['data']['kode'],
            'gelar'     => $data['data']['gelar'],
            'namatitle' => $data['data']['nametitle'],
            'nidn'      => $data['data']['nidn'],
        ];

        // echo json_encode($_SESSION['data']);

        echo "<script>
            if (window.top !== window.self) {
                window.top.location.href = '" . route('dosen.dashboard') . "';
            } else {
                window.location.href = '" . route('dosen.dashboard') . "';
            }
        </script>";

    }
}
