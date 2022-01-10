<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarFactory extends Factory
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
            'color' => $this->faker->randomElement($colors),
            'visibility' => $this->faker->numberBetween(0, 1),
            'user_id' => User::factory(),
        ];
    }
}
