<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
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

    /**
     * Boot the testing helper traits.
     *
     * @return void
     */
    protected function setUpHelpers()
    {
        $uses = array_flip(class_uses_recursive(get_class($this)));

        if (isset($uses[WithoutMiddleware::class])) {
            $this->disableMiddlewareForAllTests();
        }
    }

    /**
     * Assert if a piece of data is not in database.
     *
     * @param  string $table
     * @param  array  $data
     *
     * @return void
     */
    protected function dontSeeInDatabase($table, array $data)
    {
        $this->assertFalse(DB::table($table)->where($data)->count() > 0);
    }
}
