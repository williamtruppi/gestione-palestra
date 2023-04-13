<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{

    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $name = $this->faker->randomElement(['Pesi', 'Crossfit', 'Calisthenics']);
        $description = $this->faker->text();
        $instructor = $this->faker->name();

        return [
            'name' => $name,
            'description' => $description,
            'instructor' => $instructor
        ];
    }
}
