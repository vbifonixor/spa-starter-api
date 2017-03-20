<?php

namespace Tests\Support;

use League\Fractal\Manager;
use Tests\Samples\Transformer;
use App\Support\ResponseFactory;
use Illuminate\Http\JsonResponse;
use App\Support\TransformerHandler;
use PHPUnit_Framework_TestCase as TestCase;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ResponseFactoryTest extends TestCase
{
    /**
     * Response factory.
     *
     * @var \App\Support\ResponseFactory
     */
    protected $response;

    public function setUp()
    {
        parent::setUp();

        $handler = new TransformerHandler(new Manager, new DataArraySerializer);
        $this->response = new ResponseFactory($handler);
    }

    public function testCanSetTheStatusCode()
    {
        $response = $this->response->withStatusCode(418);

        $this->assertInstanceOf(ResponseFactory::class, $response);
        $this->assertEquals(418, $response->statusCode());
    }

    public function testMakeSimpleJsonResponse()
    {
        $statusCode = 418;
        $body = 'How could you forget the pie!';
        $headers = ['Ned' => 'Stark'];

        $response = $this->response->withStatusCode($statusCode)->withJson($body, $headers);

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
        $response = $this->response->withResource(['some data']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'data' => ['some data'],
        ], $response->getData(true));
    }

    public function testMakeResourceResponseWithMetadata()
    {
        $response = $this->response->withResource(['some data'], ['some metadata']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'data' => ['some data'],
            'meta' => ['some metadata'],
        ], $response->getData(true));
    }

    public function testMakeErrorResponse()
    {
        $message = "I'm a teapot";
        $statusCode = 418;

        $response = $this->response->withStatusCode($statusCode)->withError($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($statusCode, $response->status());
        $this->assertEquals([
            'errors' => [$message],
        ], $response->getData(true));
    }

    public function testMakeNotFoundErrorResponse()
    {
        $response = $this->response->withNotFound("These aren't the droids you're looking for");

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->status());
        $this->assertEquals([
            'errors' => ["These aren't the droids you're looking for"],
        ], $response->getData(true));
    }

    public function testMakeNoContentResponse()
    {
        $response = $this->response->withNoContent();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->status());
        $this->assertEquals([], $response->getData(true));
    }

    public function testMakeInternalServerErrorResponse()
    {
        $response = $this->response->withInternalServerError('Something went really wrong!');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->status());
        $this->assertEquals([
            'errors' => ['Something went really wrong!'],
        ], $response->getData(true));
    }

    public function testMakeUnauthorizedErrorResponse()
    {
        $response = $this->response->withUnauthorized('You shall not pass!');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
        $this->assertEquals([
            'errors' => ['You shall not pass!'],
        ], $response->getData(true));
    }

    public function testMakeTooManyRequestsErrorResponse()
    {
        $response = $this->response->withTooManyRequests('You stop that shit right now!');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(429, $response->status());
        $this->assertEquals([
            'errors' => ['You stop that shit right now!'],
        ], $response->getData(true));
    }

    public function testMakeCreatedResponse()
    {
        $response = $this->response->withCreated(['resource']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals([
            'data' => ['resource'],
        ], $response->getData(true));
    }

    public function testMakeItemResponse()
    {
        $response = $this->response->withItem([
            'status' => 1,
        ], new Transformer);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([
            'data' => ['status' => 'OK'],
        ], $response->getData(true));
    }

    public function testMakeCollectionResponse()
    {
        $response = $this->response->withCollection([
            ['status' => 1],
            ['status' => 0],
        ], new Transformer);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([
            'data' => [
                ['status' => 'OK'],
                ['status' => 'NO'],
            ],
        ], $response->getData(true));
    }

    public function testMakeCollectionResponseWithPagination()
    {
        $mock = $this->getMockBuilder(LengthAwarePaginator::class)
            ->setMethods(['count'])
            ->getMockForAbstractClass();

        $response = $this->response->withPagination($mock, new Transformer);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertArraySubset([
            'meta' => ['pagination' => []],
        ], $response->getData(true));
    }
}
