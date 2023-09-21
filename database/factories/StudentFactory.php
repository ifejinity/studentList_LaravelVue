<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_type' => fake()->randomElement(['local', 'foreign']),
            'name' => fake()->name(),
            'age' => fake()->numberBetween(17, 25),
            'city' => fake()->city(),
            'gender' => fake()->randomElement(['male', 'female']),
            'mobile_number' => '09' . fake()->unique()->shuffle('123456789'),
            'grades' => fake()->numberBetween(75, 100),
            'email' => fake()->unique()->safeEmail()
        ];
    }
}
