<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Order;
use App\Models\Client;

class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $model)
    {
        return [
            'id' => (int) $model->id,
            'number' => (string) $model->number,
            'date' => (string) $model->date,
            'truckNumber' => (string) $model->truckNumber,
            'clientId' => (int) $model->clientId,
            'client' => (new ClientTransformer)->transform($model->client),
            'file' => (string) $model->file,
        ];
    }
}