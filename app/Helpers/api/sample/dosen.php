<?php 
$parameter = array(
	'action'=>'dosen',
	'code'=>'',
	'search'=>'amin',
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
?>