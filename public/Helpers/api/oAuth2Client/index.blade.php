<!-- oAuth2Siakad By mkapl.com / irfan.inside@gmail.com -->
<link href="oAuth2ClientSiakad.css" rel="stylesheet">
<div class="container-fluid" id="oAuth2Siakad"></div>
<script src="oAuth2ClientSiakad.js"></script>
<script src="https://siakad.poltekkesbengkulu.ac.id/application/js/oAuth2/"></script>
<!-- oAuth2Siakad By mkapl.com / irfan.inside@gmail.com -->
<link href="oAuth2ClientSiakad.css" rel="stylesheet">
<div class="container-fluid" id="oAuth2Siakad"></div>
<script src="oAuth2ClientSiakad.js"></script>
<script src="https://siakad.poltekkesbengkulu.ac.id/application/js/oAuth2/"></script>

<script>
    if (window !== top) {
        if (window.location !== window.parent.location) {
            // Frame dalam mode redirect, tidak perlu melakukan redirect lagi
            console.log('Frame sudah di-redirect');
        } else {
            // Frame belum di-redirect, lakukan redirect ke halaman baru
            top.location.href = 'https://poltekkes.risetsetiawan.org/public/home';
        }
    }
</script>
