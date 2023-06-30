<?php 

if (!defined('loader_api_siakad')) {
	define('loader_api_siakad',1);
	date_default_timezone_set('Asia/Jakarta');

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	include_once dirname(__FILE__).'/ApiEnc.class.php';
	include_once dirname(__FILE__).'/curl.api.php';
	include_once dirname(__FILE__).'/config.php';
}
?>