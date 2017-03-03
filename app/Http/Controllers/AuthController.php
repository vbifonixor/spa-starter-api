<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Make authenticated tokens based on users credentials.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function token(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'errors' => ['Invalid credentials'],
            ], 401);
        }

        return response()->json([
            'data' => [
                'token' => $token,
                'user' => Auth::user(),
            ],
        ]);
    }
}
