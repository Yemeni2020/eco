<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $allowed = config('app.supported_locales', ['ar', 'en']);
        $locale = $request->route('locale')
            ?? Session::get('locale')
            ?? config('app.locale');

        if (!in_array($locale, $allowed, true)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);
        Session::put('locale', $locale);
        URL::defaults(['locale' => $locale]);

        view()->share('htmlLang', $locale);
        view()->share('htmlDir', $locale === 'ar' ? 'rtl' : 'ltr');
        view()->share('currentLocale', $locale);
        view()->share('availableLocales', collect($allowed)->mapWithKeys(fn ($code) => [$code => strtoupper($code)]));

        return $next($request);
    }
}
