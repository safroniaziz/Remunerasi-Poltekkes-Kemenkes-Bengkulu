<?php 
$parameter = array(
	'action'=>'kelasperkuliahan',
//	'thsms'=>'20152',	// Tahun Akademik (5 digit angka)
//	'kdjen'=>'C',		// Kode Jenjang 
//	'kdpst'=>'3.1',		// Kode Prodi
	'thsms'=>'20221',	// Tahun Akademik (5 digit angka)
	'kdjen'=>'D',		// Kode Jenjang 
	'kdpst'=>'D4133',		// Kode Prodi
	'kelas_kuliah'=>'',	// Search Kelas (Optional) 
	'kelas_prodi'=>'',	// Search Kelas Prodi (Reguler atau Karyawan - Kode dapat dilihat di get Prodi) (Optional) 
	'kdkmk'=>'',		// Search Kode MK (Optional)
	'id_kls'=>'',		// search ID Kelas Perkuliahan | can string or array (Optional)
	'search'=>'',		// Search Kode Mata Kuliah / Nama Mata Kuliah Sesuai (Optional)
	'offset'=>'10',		// Search Kode Mata Kuliah / Nama Mata Kuliah Sesuai (Optional)
	'limit'=>'10',		// Search Kode Mata Kuliah / Nama Mata Kuliah Sesuai (Optional)
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