<?php

namespace Database\Factories;

use App\Models\Calendar;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $colors = ['red', 'yellow', 'blue', 'green'];

        return [
            'name' => $this->faker->text(100),
            'start' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 week'),
            'end' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 week'),
            'timed' => $this->faker->randomElement([0, 1]),
            'description' => $this->faker->text(50),
            'color' => $this->faker->randomElement($colors),
            'calendar_id' => Calendar::factory(),
        ];
    }
}


