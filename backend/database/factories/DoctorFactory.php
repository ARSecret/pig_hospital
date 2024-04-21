<?php

namespace Database\Factories;

use App\Models\Doctor;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Speciality;
use App\Models\User;
use DateInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    static protected ?Collection $malePhotoUrls = null;
    static protected ?Collection $femalePhotoUrls = null;

    public function configure(): static
    {
        if (self::$malePhotoUrls == null) {
            self::$malePhotoUrls = collect(
                Storage::files('public/doctor-photos/male')
            )->map(fn ($photoPath) => Storage::url($photoPath));
        }
        if (self::$femalePhotoUrls == null) {
            self::$femalePhotoUrls = collect(
                Storage::files('public/doctor-photos/female')
            )->map(fn ($photoPath) => Storage::url($photoPath));
        }

        return $this;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lunchStart = fake()->randomElement([
            '12:00',
            '12:30',
            '13:00',
            '13:30',
        ]);
        $lunchEnd = (new DateTime($lunchStart))
            ->add(new DateInterval(fake()->randomElement([
                'PT30M',
                'PT1H',
            ])))
            ->format('H:i');

        return [
            'speciality_id' => Speciality::inRandomOrder()->first(),
            'workday_start' => fake()->randomElement([
                '06:00',
                '06:30',
                '07:00',
                '07:30',
                '08:00',
                '08:30',
                '09:00',
            ]),
            'workday_end' => fake()->randomElement([
                '16:00',
                '16:30',
                '17:00',
                '17:30',
                '18:00',
                '18:30',
                '19:00',
            ]),
            'lunch_start' => $lunchStart,
            'lunch_end' => $lunchEnd,
            'appointment_duration' => fake()->randomElement([
                'PT30M',
                'PT15M',
                'PT10M',
            ])
        ];
    }

    public function withPhoto(string $gender): Factory
    {
        return $this->state(function () use ($gender) {
            switch ($gender) {
                case 'male':
                    $photoUrl = self::$malePhotoUrls->pop();
                    break;
                case 'female':
                    $photoUrl = self::$femalePhotoUrls->pop();
                    break;
            }
            return [
                'photo_url' => $photoUrl,
            ];
        });
    }
}
