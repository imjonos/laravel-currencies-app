<?php

namespace App\Http\Resources\Api\V1\Currency;

use App\Http\Resources\Api\V1\ApiResource;
use Carbon\Carbon;

class CurrencyResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = new Carbon($this->created_at);
        $this->setType('currencies');
        $this->setAttributes([
            'id' => $this->id,
            'name' => $this->name,
            'num_code' => $this->num_code,
            'char_code' => $this->char_code,
            'nominal' => $this->nominal,
            'value' => $this->value,
            'avg_value' => round($this->avg_value,2),
            'min_value' => round($this->min_value, 2),
            'max_value' => round($this->max_value, 2),
            'created_at' => $date->format('Y-m-d')
        ]);
        $this->setLinks([
            'self' => route('currencies.show',['currency' => $this->id])
        ]);


        return parent::toArray($request);
    }
}
