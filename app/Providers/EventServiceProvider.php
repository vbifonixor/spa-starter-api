<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'tymon.jwt.absent' => [
            \App\Listeners\JWTAbsentTokenListener::class,
        ],
        'tymon.jwt.expired' => [
            \App\Listeners\JWTExpiredTokenListener::class,
        ],
        'tymon.jwt.invalid' => [
            \App\Listeners\JWTInvalidTokenListener::class,
        ],
        'tymon.jwt.user_not_found' => [
            \App\Listeners\JWTUserNotFoundListener::class,
        ],
    ];
}
