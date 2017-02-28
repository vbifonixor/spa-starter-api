<?php

namespace App\Listeners;

class JWTAbsentTokenListener
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
            'errors' => ['Token not provided.'],
        ], 400);
    }
}
