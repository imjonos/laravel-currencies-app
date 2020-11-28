<?php

namespace App\Http\Resources\Api\V1\Currency;

use App\Http\Resources\Api\V1\ApiResource;

class CurrencyIdentifierResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->setType('currencies');

        $this->setLinks([
            'self' => route('currencies.show',['currency' => $this->id])
        ]);
        return parent::toArray($request);
    }


}
