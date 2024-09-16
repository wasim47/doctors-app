<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'designation' => fake()->title(),
            'degree' => 'MBBS',
            'biography' => fake()->bothify(),
            'email' => fake()->email(),
            'phone_no' => fake()->phoneNumber(),
            'regular_fee' => 500.00,
            'report_fee' => 500.00,
            'report_fee_applicable' => 350.00,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
