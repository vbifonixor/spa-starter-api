<?php

namespace Tests\Support;

use League\Fractal\Scope;
use League\Fractal\Manager;
use App\Support\TransformerHandler;
use League\Fractal\TransformerAbstract;
use PHPUnit_Framework_TestCase as TestCase;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Serializer\SerializerAbstract;

class TransformerHandlerTest extends TestCase
{
    public function testCanTransformSingleItem()
    {
        $transformer = $this->getMockForAbstractClass(TransformerAbstract::class);
        $transform = $this->getMockForTransformerHandler([
            'status' => false,
        ]);

        $transformed = $transform->item([
            'status' => 0,
        ], $transformer);

        $this->assertEquals([
            'status' => false,
        ], $transformed);
    }

    public function testCanTransformCollection()
    {
        $collection = [
            [0], [1], [0],
        ];

        $transformer = $this->getMockForAbstractClass(TransformerAbstract::class);
        $transform = $this->getMockForTransformerHandler([
            [false, true, false],
        ]);

        $transformed = $transform->collection($collection, $transformer);

        $this->assertEquals([
            [false, true, false],
        ], $transformed);
    }

    protected function getMockForTransformerHandler(array $expected = [])
    {
        $scope = $this->getMockBuilder(Scope::class)
            ->disableOriginalConstructor()
            ->getMock();

        $scope->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue($expected));

        $fractal = $this->createMock(Manager::class);
        $fractal->expects($this->once())
            ->method('createData')
            ->will($this->returnValue($scope));

        $serializer = $this->getMockForAbstractClass(SerializerAbstract::class);

        return new TransformerHandler($fractal, $serializer);
    }
}
