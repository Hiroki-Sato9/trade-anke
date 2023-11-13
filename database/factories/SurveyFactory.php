<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'title' => fake()->text($maxNbChars = 10),
            'description' => fake()->sentence,
            'user_id' => User::factory(),
            'gender_id' => 1,
            'min_age' => fake()->numberBetween($min=0, $max=15),
            'max_age' => fake()->numberBetween($min=16, $max=99),
        ];
    }
}
