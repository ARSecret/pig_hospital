<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaseRecord>
 */
class CaseRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::inRandomOrder()->first()->id,
            'datetime' => fake()->date_timeBetween('-10 years', '-1 day'),
            'text' => fake('ru_RU')->text(200),
        ];
    }
}
