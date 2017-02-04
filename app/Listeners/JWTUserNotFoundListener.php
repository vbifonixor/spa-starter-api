<?php

namespace App\Listeners;

class JWTUserNotFoundListener
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
            'errors' => ['User not found.'],
        ], 401);
    }
}
