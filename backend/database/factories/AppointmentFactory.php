<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Patient;
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
                    $datetime = fake()->dateTimeBetween('-10 years', 'yesterday');
                    $possibleDatetimes = $this->doctor->getPossibleAppointmentDatetimes($datetime);
                } while (empty($possibleDatetimes));

                return [
                    'status' => 'successful',
                    'datetime' => fake()->randomElement($possibleDatetimes),
                ];
            }
        );
    }

    public function failed(): Factory
    {
        return $this->state(
            function (array $attributes) {
                do {
                    $datetime = fake()->dateTimeBetween('-10 years', 'yesterday');
                    $possibleDatetimes = $this->doctor->getPossibleAppointmentDatetimes($datetime);
                } while (empty($possibleDatetimes));

                return [
                    'status' => fake()->randomElement(['cancelled', 'didnt-come']),
                    'datetime' => fake()->randomElement($possibleDatetimes),
                ];
            }
        );
    }

    public function created(): Factory
    {
        return $this->state(
            function (array $attributes) {
                do {
                    $datetime = fake()->dateTimeBetween('today', '+2 months');
                    $availableDatetimes = $this->doctor->getPossibleAppointmentDatetimes($datetime);
                } while (empty($availableDatetimes));

                return [
                    'status' => fake()->randomElement(['created', 'confirmed']),
                    'datetime' => fake()->randomElement($availableDatetimes),
                ];
            }
        );
    }
}
