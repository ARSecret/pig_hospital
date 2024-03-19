<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Patient::all() as $patient) {
            Appointment::factory()->for($patient)->count(3)->failed()->create();
            Appointment::factory()->for($patient)->count(3)->created()->create();
            Appointment::factory()->for($patient)->count(3)->successful()->create();
        }
    }
}
