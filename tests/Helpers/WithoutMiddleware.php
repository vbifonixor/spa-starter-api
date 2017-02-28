<?php

namespace Tests\Helpers;

trait WithoutMiddleware
{
    /**
     * Prevent all middleware from being executed for this test class.
     *
     * @return self
     */
    protected function disableMiddlewareForAllTests()
    {
        $this->app->instance('middleware.disable', true);

        return $this;
    }
}
