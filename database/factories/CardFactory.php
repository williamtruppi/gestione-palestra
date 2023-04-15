<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{

    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $code = $this->faker->unixTime();
        $status = $this->faker->randomElement([0, 1]);

        return [
            'code' => $code,
            'status' => $status
        ];
    }
}
