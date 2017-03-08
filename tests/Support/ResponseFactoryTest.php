<?php

namespace Tests\Support;

use App\Support\ResponseFactory;
use Illuminate\Http\JsonResponse;
use PHPUnit_Framework_TestCase as TestCase;

class ResponseFactoryTest extends TestCase
{
    public function testCanSetTheStatusCode()
    {
        $factory = new ResponseFactory;
        $response = $factory->withStatusCode(418);

        $this->assertInstanceOf(ResponseFactory::class, $response);
        $this->assertEquals(418, $response->statusCode());
    }

    public function testMakeErrorResponse()
    {
        $message = "I'm a teapot";
        $statusCode = 418;

        $factory = new ResponseFactory;
        $response = $factory->withStatusCode($statusCode)->withError($message);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals([
            'errors' => [$message],
        ], $response->getData(true));

        $this->assertEquals($statusCode, $response->status());
    }
}
