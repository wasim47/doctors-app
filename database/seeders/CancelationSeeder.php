<?php

namespace Database\Seeders;

use App\Models\Cancelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CancelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cancelation::factory(10)->create();
    }
}
