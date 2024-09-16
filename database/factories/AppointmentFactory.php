<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppointmentFactory extends Factory
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
            'patient_id' => 1,
            'schedule_id' => 1,
            'appointment_date' => fake()->date(),
            'appointment_time' => fake()->time(),
            'appointment_type' => fake()->name(),
            'reason' => fake()->name(),
            'serial_no' => 12,
            'appointment_status' => 'Pending',
            'payment_status' => 'Paid',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
