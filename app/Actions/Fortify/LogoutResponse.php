<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    /**
     * Get the response for a successful logout.
     */
    public function toResponse($request)
    {
        return redirect()->route('home', ['locale' => config('app.locale')]);
    }
}
