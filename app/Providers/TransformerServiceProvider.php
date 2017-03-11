<?php

namespace App\Providers;

use League\Fractal\Manager;
use App\Support\TransformerHandler;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Serializer\DataArraySerializer;
use App\Support\Contracts\TransformerHandler as TransformerHandlerContract;

class TransformerServiceProvider extends ServiceProvider
{
    /**
     * Boot the transformer handler configurations.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(TransformerHandlerContract::class, function ($app) {
            $fractal = new Manager;
            $serializer = new DataArraySerializer;
            return new TransformerHandler($fractal, $serializer);
        });
    }
}
