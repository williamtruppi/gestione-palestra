<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{

    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $course_id = Course::factory();
        $description = $this->faker->text();
        $max_capacity = $this->faker->numberBetween(5, 15);
        $start_time = $this->faker->time();
        $end_time = $start_time + 3600;

        return [
            'course_id' => $course_id,
            'description' => $description,
            'max_capacity' => $max_capacity,
            'start_time' => $start_time,
            'end_time' => $end_time
        ];
    }
}
