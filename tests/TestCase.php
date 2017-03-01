<?php

namespace Tests;

use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;

abstract class TestCase extends LumenTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp()
    {
        parent::setUp();

        $this->setUpHelpers();
    }

    protected function setUpHelpers()
    {
        $uses = array_flip(class_uses_recursive(get_class($this)));

        if (isset($uses[WithoutMiddleware::class])) {
            $this->disableMiddlewareForAllTests();
        }
    }
}
