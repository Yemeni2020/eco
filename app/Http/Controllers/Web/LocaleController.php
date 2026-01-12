<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
class LocaleController extends Controller
{
    public function switch(string $locale)
    {
        $allowed = config('app.supported_locales', ['ar', 'en']);
        $locale = in_array($locale, $allowed, true) ? $locale : config('app.locale');

        session(['locale' => $locale]);

        $target = url()->previous() ?: route('home', ['locale' => $locale]);
        $localized = $this->rebuildPath($target, $locale, $allowed);

        return redirect($localized);
    }

    private function rebuildPath(string $url, string $locale, array $allowed): string
    {
        $parsed = parse_url($url);
        if (!is_array($parsed)) {
            return route('home', ['locale' => $locale]);
        }

        $segments = array_values(array_filter(explode('/', $parsed['path'] ?? ''), fn ($segment) => $segment !== ''));
        if (count($segments) > 0 && in_array($segments[0], $allowed, true)) {
            $segments[0] = $locale;
        } else {
            array_unshift($segments, $locale);
        }

        $path = '/' . implode('/', $segments);
        $scheme = $parsed['scheme'] ?? request()->getScheme();
        $host = $parsed['host'] ?? request()->getHost();
        $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';

        return "{$scheme}://{$host}{$port}{$path}{$query}";
    }
}
