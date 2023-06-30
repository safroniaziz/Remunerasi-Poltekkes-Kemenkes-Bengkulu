<?php 

if (!defined('loader_api_siakad')) {
	define('loader_api_siakad',1);
	date_default_timezone_set('Asia/Jakarta');

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once(app_path('Helpers/api/ApiEnc.class.php'));
	require_once(app_path('Helpers/api/curl.api.php'));
	require_once(app_path('Helpers/api/config.php'));
}
?>