<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Client;

class ClientTransformer extends TransformerAbstract
{
    public function transform(Client $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => (string) $model->name,
        ];
    }
}