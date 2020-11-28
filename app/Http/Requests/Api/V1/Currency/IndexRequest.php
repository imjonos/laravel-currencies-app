<?php

namespace App\Http\Requests\Api\V1\Currency;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter' => 'array',
            'filter.id' => 'numeric',
            'filter.base_currency' => 'numeric',
            'filter.date_from' => 'date',
            'filter.date' => 'date',
            'filter.date_to' => 'date',
            'page' => 'array',
            'page.number' => 'numeric',
            'page.size' => 'numeric'
        ];
    }
}
