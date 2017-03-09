<?php

namespace Tests\Support;

use Illuminate\Http\Request;
use App\Support\QueryParameterBag;
use PHPUnit_Framework_TestCase as TestCase;

class QueryParameterBagTest extends TestCase
{
    /**
     * @dataProvider hasDataProvider
     */
    public function testCheckIfRequestHasParameter($name, $expected, $request)
    {
        $bag = new QueryParameterBag($request);

        $this->assertEquals($expected, $bag->has($name));
    }

    public function testCanGetAllParameters()
    {
        $queryParameters = [
            'limit' => 10,
            'order_by' => 'desc',
        ];

        $bag = new QueryParameterBag(new Request($queryParameters));

        $this->assertEquals($queryParameters, $bag->all());
    }

    /**
     * @dataProvider queryParametersProvider
     */
    public function testCanGetSingleParameter($expected, $request, $method, $default = null)
    {
        $bag = new QueryParameterBag($request);

        $this->assertEquals($expected, $bag->{$method}($default));
    }

    /**
     * Provide an array of arguments.
     *
     * @return bool
     */
    public function hasDataProvider()
    {
        return [
            ['limit', true, new Request(['limit' => 10])],
            ['include', false, new Request],
        ];
    }

    public function queryParametersProvider()
    {
        return [
            [50, new Request(['limit' => 50]), 'limit'],
            ['asc', new Request(['order_by' => 'asc']), 'orderBy'],
            ['title', new Request(['sort_by' => 'title']), 'sortBy'],
            [99, new Request(['page' => 99]), 'page'],
            ['books', new Request(['include' => 'books']), 'include'],
            ['default', new Request, 'parameter', 'default'],
        ];
    }
}
