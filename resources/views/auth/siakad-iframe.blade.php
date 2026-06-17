{{-- oAuth2Siakad Widget By mkapl.com / irfan.inside@gmail.com --}}
<link href="{{ asset('Helpers/api/oAuth2Client/oAuth2ClientSiakad.css') }}" rel="stylesheet">
<div class="container-fluid" id="oAuth2Siakad"></div>
<script src="{{ asset('Helpers/api/oAuth2Client/oAuth2ClientSiakad.js') }}"></script>
<script>
    // Server SIAKAD hanya melayani HTTP; arahkan base URL & callback widget ke
    // domain HTTPS kita (lewat proxy) memakai url() agar base path (mis. /public)
    // selalu tepat dan tidak terjadi mixed content.
    if (typeof oAuth2Siakad !== 'undefined') {
        oAuth2Siakad.url = "{{ rtrim(url('/siakad-proxy'), '/') }}/";
        oAuth2Siakad.url_callback = "{{ url('/oauth-callback') }}";
    }
</script>
{{-- Dimuat lewat proxy HTTPS kita karena server SIAKAD hanya melayani HTTP --}}
<script src="{{ url('/siakad-proxy/application/js/oAuth2/') }}"></script>
