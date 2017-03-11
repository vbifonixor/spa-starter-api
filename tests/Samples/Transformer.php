<?php

namespace Tests\Samples;

use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'status' => (bool) $data['status'],
        ];
    }
}
