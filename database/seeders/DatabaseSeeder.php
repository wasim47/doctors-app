<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
        $this->call([
            SpecialtySeeder::class,
            DoctorSeeder::class,
            HospitalSeeder::class,
            AppointmentSeeder::class,
            PatientSeeder::class,
            BlogSeeder::class,
            CancelationSeeder::class,
            ScheduleSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
