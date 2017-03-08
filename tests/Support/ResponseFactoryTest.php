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

    public function testMakeSimpleJsonResponse()
    {
        $statusCode = 418;
        $body = 'You sexy thing!';
        $headers = ['Ned' => 'Stark'];

        $factory = new ResponseFactory;
        $response = $factory->withStatusCode($statusCode)->withJson($body, $headers);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($statusCode, $response->status());
        $this->assertEquals($body, $response->getData(true));

        foreach ($headers as $header => $value) {
            $this->assertTrue(
                $response->headers->has($header),
                'Failed to assert that the header "'.$header.'" is present in the returned response.'
            );
        }
    }

    public function testMakeResourceResponse()
    {
        $factory = new ResponseFactory;
        $response = $factory->withResource(['some data']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'data' => ['some data'],
        ], $response->getData(true));
    }

    public function testMakeResourceResponseWithMetadata()
    {
        $factory = new ResponseFactory;
        $response = $factory->withResource(['some data'], ['some metadata']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'data' => ['some data'],
            'metadata' => ['some metadata'],
        ], $response->getData(true));
    }

    public function testMakeErrorResponse()
    {
        $message = "I'm a teapot";
        $statusCode = 418;

        $factory = new ResponseFactory;
        $response = $factory->withStatusCode($statusCode)->withError($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($statusCode, $response->status());
        $this->assertEquals([
            'errors' => [$message],
        ], $response->getData(true));
    }

    public function testMakeNotFoundErrorResponse()
    {
        $factory = new ResponseFactory;
        $response = $factory->withNotFound("These aren't the droids you're looking for");

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->status());
        $this->assertEquals([
            'errors' => ["These aren't the droids you're looking for"],
        ], $response->getData(true));
    }

    public function testMakeNoContentResponse()
    {
        $factory = new ResponseFactory;
        $response = $factory->withNoContent();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->status());
        $this->assertEquals([], $response->getData(true));
    }

    public function testMakeInternalServerErrorResponse()
    {
        $factory = new ResponseFactory;
        $response = $factory->withInternalServerError('Something went really wrong!');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->status());
        $this->assertEquals([
            'errors' => ['Something went really wrong!'],
        ], $response->getData(true));
    }

    public function testMakeUnauthorizedErrorResponse()
    {
        $factory = new ResponseFactory;
        $response = $factory->withUnauthorized('You shall not pass!');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
        $this->assertEquals([
            'errors' => ['You shall not pass!'],
        ], $response->getData(true));
    }

    public function testMakeTooManyRequestsErrorResponse()
    {
        $factory = new ResponseFactory;
        $response = $factory->withTooManyRequests('You stop that shit right now!');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(429, $response->status());
        $this->assertEquals([
            'errors' => ['You stop that shit right now!'],
        ], $response->getData(true));
    }

    public function testMakeCreatedResponse()
    {
        $factory = new ResponseFactory;
        $response = $factory->withCreated(['resource']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals([
            'data' => ['resource'],
        ], $response->getData(true));
    }
}
