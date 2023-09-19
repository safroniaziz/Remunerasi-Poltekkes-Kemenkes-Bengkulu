var oAuth2Siakad = {
    'url': 'https://siakad.poltekkesbengkulu.ac.id/',
    'params': {
        'title': 'Login',
        'client_id': '23020001',
        'oAuth2': true,
        'mod': 'form',
        'theme': 'theme-1' /* theme-1 | theme-2 */
    },
    'type': 'dosen',
    'jquery': true,
    'bootstrap': true,
    'url_callback': '/oauth-callback' // Mengarahkan ke rute OAuth2 callback dalam Laravel
}
