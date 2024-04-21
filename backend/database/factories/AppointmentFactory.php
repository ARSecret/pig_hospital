<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Enums\AppointmentStatus;
use App\Models\Patient;
use Database\Seeders\AppointmentSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    private Patient $patient;
    private Doctor $doctor;

    public function definition(): array
    {
        $this->doctor = Doctor::inRandomOrder()->first();

        return [
            'doctor_id' => $this->doctor->id,
        ];
    }

    public function successful(): Factory
    {
        return $this->state(
            function (array $attributes) {
                do {
                    $datetime = fake()->date_timeBetween('-10 years', 'yesterday');
                    $possibleDatetimes = $this->doctor->getPossibleAppointmentDatetimes($datetime);
                } while (empty($possibleDatetimes));

                return [
                    'status' => AppointmentStatus::Successful,
                    'date_time' => fake()->randomElement($possibleDatetimes),
                ];
            }
        );
    }

    public function failed(): Factory
    {
        return $this->state(
            function (array $attributes) {
                do {
                    $datetime = fake()->date_timeBetween('-10 years', 'yesterday');
                    $possibleDatetimes = $this->doctor->getPossibleAppointmentDatetimes($datetime);
                } while (empty($possibleDatetimes));

                return [
                    'status' => fake()->randomElement([
                        AppointmentStatus::Cancelled,
                        AppointmentStatus::DidntCome,
                    ]),
                    'date_time' => fake()->randomElement($possibleDatetimes),
                ];
            }
        );
    }

    public function created(): Factory
    {
        return $this->state(
            function (array $attributes) {
                do {
                    $datetime = fake()->date_timeBetween('today', '+2 months');
                    $availableDatetimes = $this->doctor->getPossibleAppointmentDatetimes($datetime);
                } while (empty($availableDatetimes));

                return [
                    'status' => fake()->randomElement([
                        AppointmentStatus::Created,
                        AppointmentStatus::Confirmed,
                    ]),
                    'date_time' => fake()->randomElement($availableDatetimes),
                ];
            }
        );
    }
}
