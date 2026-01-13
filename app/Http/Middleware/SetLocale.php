<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Support\LocaleSegment;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $allowed = config('app.supported_locales', ['ar', 'en']);
        $segment = $request->route('locale')
            ?? Session::get('locale')
            ?? config('app.locale');

        $normalized = LocaleSegment::normalize($segment);
        $baseLocale = LocaleSegment::base($normalized);

        app()->setLocale($baseLocale);
        Session::put('locale', $normalized);
        URL::defaults(['locale' => $normalized]);

        view()->share('htmlLang', $baseLocale);
        view()->share('htmlDir', $baseLocale === 'ar' ? 'rtl' : 'ltr');
        view()->share('currentLocale', $normalized);
        view()->share('availableLocales', collect($allowed)->mapWithKeys(fn ($code) => [$code => strtoupper($code)]));

        return $next($request);
    }
}
