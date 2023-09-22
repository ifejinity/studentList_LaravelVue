<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Student::factory(300)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\Student::factory(100)->create([
        //     'student_type' => fake()->randomElement(['local', 'foreign']),
        //     'name' => fake()->name(),
        //     'age' => fake()->numberBetween(1, 100),
        //     'city' => fake()->city(),
        //     'gender' => fake()->randomElement(['male', 'female']),
        //     'mobile_number' => fake()->phoneNumber(),
        //     'grades' => fake()->numberBetween(75, 100),
        //     'email' => fake()->safeEmail()
        // ]);
    }

}
