<?php

namespace App\Http\Controllers;

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    /**
     * Creates new user account.
     *
     * @param  SignUpRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(SignUpRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'data' => $user->toArray(),
            'metadata' => [
                'token' => $token,
            ],
        ], 201);
    }
}
