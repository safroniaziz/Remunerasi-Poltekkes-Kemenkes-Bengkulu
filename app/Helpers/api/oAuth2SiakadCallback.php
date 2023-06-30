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
echo $response;
?>