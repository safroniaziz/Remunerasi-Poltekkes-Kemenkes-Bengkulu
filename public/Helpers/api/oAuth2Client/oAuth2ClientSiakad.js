var oAuth2Siakad = {
    // Disalurkan lewat proxy HTTPS kita (server SIAKAD hanya HTTP) agar tidak
    // terjadi mixed content. Lihat route 'siakad.proxy' + SiakadProxyController.
    'url': '/siakad-proxy/',
    'params': {
        'title': 'Login',
        'client_id': '23060001',
        'oAuth2': true,
        'mod': 'form',
        'theme': 'theme-1' /* theme-1 | theme-2 */
    },
    'type': 'dosen',
    'jquery': true,
    'bootstrap': true,
    'url_callback': '/oauth-callback' // Mengarahkan ke rute OAuth2 callback dalam Laravel
}
