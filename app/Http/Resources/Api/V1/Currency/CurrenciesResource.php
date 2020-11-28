<?php

namespace App\Http\Resources\Api\V1\Currency;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CurrenciesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request):array
    {
        return [
            'data' => CurrencyResource::collection($this->collection),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function with($request)
    {

        return [
            'links'    => [
                'self' => route('currencies.index'),
            ]
        ];
    }
}
