<?php

namespace App\Support\Contracts;

use League\Fractal\TransformerAbstract;

interface TransformerHandler
{
    /**
     * Transform a single item.
     *
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function item($data, TransformerAbstract $transformer);

    /**
     * Transform a collection of items.
     *
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function collection($data, TransformerAbstract $transformer);

    /**
     * Use a paginator adapter.
     *
     * @return self
     */
    public function usePaginatorAdapter();
}
