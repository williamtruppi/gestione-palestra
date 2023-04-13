<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{

    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'lesson_id' => Lesson::factory()
        ];
    }
}
