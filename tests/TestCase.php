<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;

abstract class TestCase extends LumenTestCase
{
    /**
     * Testing helper traits and their boot methods.
     *
     * @var array
     */
    private $testingHelpers = [
        WithoutMiddleware::class => 'disableMiddlewareForAllTests',
    ];

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

        foreach ($this->testingHelpers as $helper => $method) {
            if (! array_key_exists($helper, $uses)) {
                continue;
            }

            $this->{$method}();
        }
    }

    /**
     * Assert that a piece of data is not in database.
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
