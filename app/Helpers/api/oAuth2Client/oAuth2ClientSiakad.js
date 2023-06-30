var oAuth2Siakad = {
	'url':'http://siakad.poltekkesbengkulu.ac.id/',
	'params':{
		'title':'Login',
		'client_id':'23020001', 
		'oAuth2':true,
		'mod':'form',
		'theme':'theme-1' /* theme-1 | theme-2 */
	},
	'type':'dosen',
	'jquery':true,	// optional if you have jquery fill false
	'bootstrap':true,	// optional if you have bootstrap fill false
	'url_callback':'https://api.risetsetiawan.org/oAuth2SiakadCallback.php',
}