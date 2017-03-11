<?php

namespace App\Support;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Support\Contracts\TransformerHandler as TransformerHandlerContract;

class TransformerHandler implements TransformerHandlerContract
{
    /**
     * Fracal manager.
     *
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * Use pagination.
     *
     * @var bool
     */
    protected $usePaginator = false;

    /**
     * Creates a new transformer handler instance.
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

        return $this->transformData($resource);
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

        if ($this->usePaginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($data));
        }

        return $this->transformData($resource);
    }

    /**
     * Use a paginator adapter.
     *
     * @return self
     */
    public function usePaginatorAdapter()
    {
        $this->usePaginator = true;

        return $this;
    }

    /**
     * Transform resource and convert it into an array.
     *
     * @param  ResourceAbstract $resource
     *
     * @return array
     */
    protected function transformData(ResourceAbstract $resource)
    {
        return $this->fractal->createData($resource)->toArray();
    }
}
