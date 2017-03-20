<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;

class MeController extends Controller
{
    /**
     * Show authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return $this->response->withItem(Auth::user(), new UserTransformer);
    }
}
