<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Listeners\JWTAbsentTokenListener;
use App\Listeners\JWTExpiredTokenListener;
use App\Listeners\JWTInvalidTokenListener;
use App\Listeners\JWTUserNotFoundListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'tymon.jwt.absent' => [
            JWTAbsentTokenListener::class,
        ],
        'tymon.jwt.expired' => [
            JWTExpiredTokenListener::class,
        ],
        'tymon.jwt.invalid' => [
            JWTInvalidTokenListener::class,
        ],
        'tymon.jwt.user_not_found' => [
            JWTUserNotFoundListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
