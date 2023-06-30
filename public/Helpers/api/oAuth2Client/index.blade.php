<!-- oAuth2Siakad By mkapl.com / irfan.inside@gmail.com -->
<link href="oAuth2ClientSiakad.css" rel="stylesheet">
<div class="container-fluid" id="oAuth2Siakad"></div>
<script>
    var oAuth2Siakad = {
	'url':'https://siakad.poltekkesbengkulu.ac.id/',
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
	// 'url_callback':'https://poltekkes.risetsetiawan.org/app/Helpers/api/oAuth2SiakadCallback.php',
	'url_callback':'https://poltekkes.risetsetiawan.org/public/callback',
    }
</script>
<script src="https://siakad.poltekkesbengkulu.ac.id/application/js/oAuth2/"></script>
