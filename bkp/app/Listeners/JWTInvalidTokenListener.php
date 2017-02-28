<?php

namespace App\Listeners;

class JWTInvalidTokenListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        return response()->json([
            'errors' => ['Token invalid.'],
        ], 401);
    }
}
