<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerIsNotBlocked
{
    public function handle(Request $request, Closure $next): Response
    {
        $customer = Auth::guard('customer')->user();

        if ($customer && $customer->isBlocked()) {
            Auth::guard('customer')->logout();

            return redirect()->route('login')->withErrors([
                'phone' => __('Your account is blocked. Contact support for assistance.'),
            ]);
        }

        return $next($request);
    }
}
