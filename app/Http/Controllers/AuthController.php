<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if ($token = Auth::guard('merchant')->attempt($credentials)) {
    //         return response()->json(compact('token'));
    //     } elseif ($token = Auth::guard('customer')->attempt($credentials)) {
    //         return response()->json(compact('token'));
    //     } else {
    //         return response()->json(['error' => 'invalid_credentials'], 401);
    //     }
    // }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        return response()->json(compact('token'));
    }

    // public function logout()
    // {
    //     try {
    //         JWTAuth::invalidate(JWTAuth::getToken());
    //         return response()->json(['message' => 'Successfully logged out']);
    //     } catch (JWTException $e) {
    //         return response()->json(['error' => 'could_not_invalidate_token'], 500);
    //     }
    // }
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'could_not_logout'], 500);
        }
    }
}
