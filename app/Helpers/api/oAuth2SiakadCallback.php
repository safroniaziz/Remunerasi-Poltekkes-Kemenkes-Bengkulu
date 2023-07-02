<?php 

date_default_timezone_set('Asia/Jakarta');
error_reporting(E_ALL);
ini_set('display_errors',1);

include_once 'ApiEnc.class.php';
include_once 'curl.api.php';
include_once 'config.php';

$parameter = array(
	'action'=>'oAuthToken',
	'token'=>$_GET['token'],
);

$hashed_string = ApiEnc::encrypt(
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
$data = [
    'nama'      => $data['data']['name'],
    'kode'      => $data['data']['kode'],
    'gelar'     => $data['data']['gelar'],
    'namatitle' => $data['data']['nametitle'],
    'nidn'      => $data['data']['nidn'],
];

print_r($data);
// echo "<script>
//     if (window.top !== window.self) {
//         window.top.location.href = 'https://poltekkes.risetsetiawan.org/public/home';
//     } else {
//         window.location.href = 'https://poltekkes.risetsetiawan.org/public/home';
//     }
// </script>";

?>

