<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function register(AuthRegisterRequest $request)
    {
        $user = Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return $this->success([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 'Registration successful.', 201);
    }

    public function login(AuthLoginRequest $request)
    {
        if (! Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials.', ['email' => ['Invalid credentials.']], 401);
        }

        $user = Auth::guard('customer')->user();
        $token = $user->createToken('api')->plainTextToken;

        return $this->success([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 'Login successful.');
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('customer')->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return $this->success(null, 'Logged out.');
    }

    public function me(Request $request)
    {
        $user = Auth::guard('customer')->user();

        return $this->success([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
