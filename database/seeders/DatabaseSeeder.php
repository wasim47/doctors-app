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
        $this->call([
            SpecialtySeeder::class,
            DoctorSeeder::class,
            HospitalSeeder::class,
            PatientSeeder::class,
            BlogSeeder::class,
            ScheduleSeeder::class,
            CancelationSeeder::class,
            AppointmentSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
