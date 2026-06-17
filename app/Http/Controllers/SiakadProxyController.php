<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Proxy aman untuk widget/aset SIAKAD.
 *
 * Server SIAKAD (lihat config services.siakad.target) hanya melayani HTTP.
 * Karena aplikasi diakses lewat HTTPS, browser memblokir resource HTTP
 * (mixed content). Controller ini mem-forward request browser ke SIAKAD
 * dari sisi server (HTTP), lalu mengembalikannya ke browser lewat domain
 * HTTPS kita sehingga tidak ada lagi konten tidak aman.
 *
 * Bukan open-proxy: tujuan dikunci ke host SIAKAD; hanya path yang diteruskan.
 */
class SiakadProxyController extends Controller
{
    public function proxy(Request $request, string $path = '')
    {
        $target = config('services.siakad.target');

        $url = $target . '/' . ltrim($path, '/');
        if ($query = $request->getQueryString()) {
            $url .= '?' . $query;
        }

        $method = strtoupper($request->method());

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 25,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => [
                'User-Agent: ' . ($request->userAgent() ?? 'Mozilla/5.0'),
                'Accept: ' . ($request->header('Accept') ?? '*/*'),
            ],
        ]);

        if (in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getContent());
            if ($contentType = $request->header('Content-Type')) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'User-Agent: ' . ($request->userAgent() ?? 'Mozilla/5.0'),
                    'Accept: ' . ($request->header('Accept') ?? '*/*'),
                    'Content-Type: ' . $contentType,
                ]);
            }
        }

        $raw = curl_exec($ch);

        if ($raw === false) {
            $error = curl_error($ch);
            curl_close($ch);

            return response('SIAKAD tidak dapat dihubungi: ' . $error, 502)
                ->header('Content-Type', 'text/plain; charset=utf-8');
        }

        $headerSize  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $status      = curl_getinfo($ch, CURLINFO_HTTP_CODE) ?: 200;
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $rawHeaders  = substr($raw, 0, $headerSize);
        $body        = substr($raw, $headerSize);
        curl_close($ch);

        // Untuk konten teks (JS/HTML/CSS/JSON), tulis ulang setiap rujukan ke
        // host SIAKAD agar ikut lewat proxy HTTPS kita. Ini menangani URL yang
        // ter-hardcode di dalam script widget (mis. //103.219.248.108/...),
        // yang kalau dibiarkan akan di-upgrade browser ke https dan gagal
        // (ERR_CONNECTION_RESET) karena server SIAKAD tak punya HTTPS.
        if ($this->isTextContent($contentType)) {
            $body = $this->rewriteBody($body);
        }

        $response = response($body, $status);
        $response->header('Content-Type', $contentType ?: 'text/html; charset=utf-8');

        // Teruskan redirect, tapi tulis ulang Location agar tetap lewat proxy
        // HTTPS kita (bukan kembali ke http://<host SIAKAD>).
        if ($location = $this->extractHeader($rawHeaders, 'Location')) {
            $response->header('Location', $this->rewriteLocation($location));
        }

        return $response;
    }

    private function extractHeader(string $rawHeaders, string $name): ?string
    {
        foreach (preg_split('/\r\n|\n/', $rawHeaders) as $line) {
            if (stripos($line, $name . ':') === 0) {
                return trim(substr($line, strlen($name) + 1));
            }
        }

        return null;
    }

    private function rewriteLocation(string $location): string
    {
        $target = config('services.siakad.target');

        // Redirect absolut ke host SIAKAD -> arahkan lewat proxy kita.
        if (str_starts_with($location, $target)) {
            $path = ltrim(substr($location, strlen($target)), '/');

            return url('/siakad-proxy/' . $path);
        }

        return $location;
    }

    private function isTextContent(?string $contentType): bool
    {
        if (! $contentType) {
            return true; // Banyak endpoint SIAKAD tak mengirim Content-Type; anggap teks.
        }

        return (bool) preg_match(
            '#(text/|javascript|json|xml|css|html)#i',
            $contentType
        );
    }

    private function rewriteBody(string $body): string
    {
        $host = parse_url(config('services.siakad.target'), PHP_URL_HOST);

        if (! $host) {
            return $body;
        }

        $proxyBase = rtrim(url('/siakad-proxy'), '/');

        // Ganti http://host, https://host, dan //host (protocol-relative)
        // menjadi base proxy kita dalam satu kali jalan.
        return preg_replace(
            '#(https?:)?//' . preg_quote($host, '#') . '#i',
            $proxyBase,
            $body
        );
    }
}
