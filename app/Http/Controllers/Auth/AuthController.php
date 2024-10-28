<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'country_code' => $data['country_code'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->safe()->only(['email', 'password']);
            $remember = (bool) $request->safe()->input('remember');

            if (!Auth::attempt($credentials, $remember)) {
                return response()->json([
                    'message' => 'Wrong password for this email address'
                ], 401);
            }

            /**
             * @var \App\Models\User $user
             */
            $user = Auth::user();
            $token = $remember
                ? $user->createToken('auth_token', ['*'], now()->addYear())->plainTextToken
                : $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Logged out'
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
