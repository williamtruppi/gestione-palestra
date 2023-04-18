<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{

    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $name = $this->faker->name();
        $email = $this->faker->email();
        $phone = $this->faker->phoneNumber();
        $card_id = Card::factory();

        $startDate = '2022-06-01';
        $endDate = now()->toDateString(); // ottieni la data di oggi come stringa
        $membership_date = $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');

        $type = $this->faker->randomElement([1, 2, 3]);
        $duration = $this->faker->randomElement([1, 3, 6, 12]);
        $status = $this->faker->randomElement([0, 1, 2, 3, 4]); 
        // 0 - non attivo, 1 - attivo, 2 - scaduto, 3 - sospeso, 4 - decaduto

        return [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'card_id' => $card_id,
            'membership_date' => $membership_date,
            'membership_type' => $type,
            'membership_duration' => $duration,
            'membership_status' => $status,
        ];
    }
}
