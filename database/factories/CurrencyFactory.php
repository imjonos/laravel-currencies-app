<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'num_code' => $this->faker->numberBetween(),
            'char_code' => $this->faker->currencyCode,
            'nominal' => $this->faker->numberBetween(),
            'value' => $this->faker->numberBetween(0,100)
        ];
    }
}
