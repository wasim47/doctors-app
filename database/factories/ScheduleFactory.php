<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ScheduleFactory extends Factory
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
            'title' => fake()->title(),
            'days_of_weeks' => json_encode(['Saturday','Sunday']),
            'shift' => fake()->title(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'minutes_per_appointment' => 15,
            'maximum_patients' => 40,
            'start _date' => fake()->date(),
            'end_date' => fake()->date(),
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
