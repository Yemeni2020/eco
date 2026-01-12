<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Security\SecuritySettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    protected array $providers = ['google', 'facebook', 'apple'];

    public function redirect(string $provider, SecuritySettings $settings): RedirectResponse
    {
        if (! in_array($provider, $this->providers, true)) {
            abort(404);
        }

        $config = $settings->socialConfig($provider);
        if (empty($config['client_id']) || empty($config['client_secret'])) {
            return redirect()->route('login')->withErrors(['social' => 'Social login is not configured.']);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider, SecuritySettings $settings): RedirectResponse
    {
        if (! in_array($provider, $this->providers, true)) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['social' => 'Unable to authenticate via ' . ucfirst($provider) . '.']);
        }

        $email = $socialUser->getEmail();
        if (! $email) {
            return redirect()->route('login')->withErrors(['social' => 'No email returned by the provider.']);
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? $email,
                'password' => Hash::make(Str::random(32)),
            ]
        );

        Auth::login($user, true);

        return redirect()->intended('/');
    }
}
