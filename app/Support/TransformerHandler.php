<?php

namespace App\Support;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\SerializerAbstract;

class TransformerHandler
{
    /**
     * Fractal manager.
     *
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * Creates a new instance of the transformer handler.
     *
     * @param Manager            $fractal
     * @param SerializerAbstract $serializer
     */
    public function __construct(Manager $fractal, SerializerAbstract $serializer)
    {
        $this->fractal = $fractal;
        $this->fractal->setSerializer($serializer);
    }

    /**
     * Transform a single item.
     *
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function item($data, TransformerAbstract $transformer)
    {
        $resource = new Item($data, $transformer);
        return $this->fractal->createData($resource)->toArray();
    }

    /**
     * Transform a collection of items.
     *
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function collection($data, TransformerAbstract $transformer)
    {
        $resource = new Collection($data, $transformer);
        return $this->fractal->createData($resource)->toArray();
    }
}
