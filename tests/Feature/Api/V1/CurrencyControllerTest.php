<?php

namespace Tests\Feature\Api\V1;

use App\Models\Currency;
use Tests\TestCase;

class CurrencyControllerTest extends TestCase
{

    /**
     * A basic feature test Index Action.
     *
     * @return void
     */
    public function testIndex()
    {
        $currency = Currency::first();
        $response = $this->ajaxWithOAuth('get', route('currencies.index'));
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'type' => 'currencies',
                    'id' => (string)$currency->id,
                    'attributes' => [
                        'name' => $currency->name
                    ]
                ]
            ]
        ]);


        $response = $this->ajaxWithOAuth('get', route('currencies.index'), [
            'page' => [
                'size' => 5,
                'number' => 2
            ]
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'type' => 'currencies',
                    'id' => '6'
                ]
            ]
        ]);

    }

    /**
     * A basic feature test Show Action.
     *
     * @return void
     */
    public function testShow()
    {
        $currency = Currency::first();
        $response = $this->ajaxWithOAuth('get', route('currencies.show', ['currency' => $currency->num_code]));
        $response->assertStatus(200);
        $response->assertJson([
                'data' => [
                    'type' => 'currencies',
                    'attributes' => [
                        'num_code' => (string)$currency->num_code,
                        'name' => $currency->name
                    ]
                ]
            ]
        );

    }
}
