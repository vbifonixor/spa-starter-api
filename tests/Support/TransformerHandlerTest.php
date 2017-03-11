<?php

namespace Tests\Support;

use League\Fractal\Manager;
use Tests\Samples\Transformer;
use App\Support\TransformerHandler;
use PHPUnit_Framework_TestCase as TestCase;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransformerHandlerTest extends TestCase
{
    /**
     * Transformer handler.
     *
     * @var \App\Support\TransformerHandler
     */
    protected $transform;

    public function setUp()
    {
        parent::setUp();

        $this->transform = new TransformerHandler(new Manager, new DataArraySerializer);
    }

    public function testCanTransformItem()
    {
        $data = $this->transform->item(['status' => 0], new Transformer);

        $this->assertEquals([
            'data' => [
                'status' => 'NO',
            ],
        ], $data);
    }

    public function testCanTransformCollection()
    {
        $data = $this->transform->collection([
            ['status' => 0],
            ['status' => 1],
            ['status' => 0],
        ], new Transformer);

        $this->assertEquals([
            'data' => [
                ['status' => 'NO'],
                ['status' => 'OK'],
                ['status' => 'NO'],
            ],
        ], $data);
    }

    public function testCanTransformCollectionWithPagination()
    {
        $paginator = $this->getMockBuilder(LengthAwarePaginator::class)
            ->setMethods(['count'])
            ->getMockForAbstractClass();

        $transform = $this->transform->usePaginatorAdapter();

        $this->assertInstanceOf(TransformerHandler::class, $transform);

        $data = $transform->collection($paginator, new Transformer);

        $this->assertArraySubset([
            'meta' => ['pagination' => []],
        ], $data);
    }
}
