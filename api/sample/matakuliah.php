<?php 
$parameter = array(
	'action'=>'matakuliah',
	'thsms'=>'20152',	// Tahun Akademik (5 digit angka)
	'kdjen'=>'C',		// Kode Jenjang 
	'kdpst'=>'3.1',		// Kode Prodi
	'kdkmk'=>'',		// Search Kode MK (Optional) | can string or array (Optional)
	'id_mk'=>'',		// search ID MK Perkuliahan | can string or array (Optional)
	'search'=>'',		// Search Kode Mata Kuliah / Nama Mata Kuliah Sesuai (Optional)
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