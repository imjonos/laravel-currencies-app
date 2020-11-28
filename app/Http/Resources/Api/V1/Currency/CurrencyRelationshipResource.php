<?php

namespace App\Http\Resources\Api\V1\Currency;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CurrencyRelationshipResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => CurrencyIdentifierResource::collection($this->collection),
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('currencies.show',['currency' => $this->id])
            ],
        ];
    }
}
