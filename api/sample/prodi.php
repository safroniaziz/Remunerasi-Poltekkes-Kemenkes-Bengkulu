<?php 
$parameter = array(
	'action'=>'prodi',
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

print_r($parameter);
print_r($data);
$response = _curl_api($config['url'], json_encode($data));
?>