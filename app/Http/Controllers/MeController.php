<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    /**
     * Creates a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json([
            'data' => Auth::user(),
        ], 200);
    }
}
