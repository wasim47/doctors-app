<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CancelationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => 1,
            'schedule_id' => 1,
            'cancelation_date' => fake()->date(),
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
