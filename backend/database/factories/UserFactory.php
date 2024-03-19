<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

use Transliterator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    private static ?string $password_hash = null;

    public function definition(): array
    {
        if (self::$password_hash === null) {
            self::$password_hash = Hash::make('123');
        }

        $transliterator = Transliterator::create('Russian-Latin/BGN');

        $gender = fake()->randomElement(['male', 'female']);
        $first_name = fake('ru_RU')->firstName($gender);
        $last_name = fake('ru_RU')->lastName($gender);

        $login = implode('_', [$first_name, $last_name]);
        $login = str_replace('ё', 'е', $login);
        $login = str_replace('ь', '', $login);
        $login = $transliterator->transliterate($login);
        $login = strtolower($login);
        $extraChar = '1';
        while (User::where('login', $login)->count() > 0) {
            $login .= $extraChar;
            $extraChar += 1;
        }

        return [
            'login' => $login,
            'gender' => $gender,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'patronymic' => null,
            'email' => fake()->unique()->safeEmail(),
            'password' => self::$password_hash,
        ];
    }

    public function doctor(): Factory
    {
        return $this->state(
            function (array $attributes) {
                return [
                    'role' => 'doctor',
                ];
            }
        );
    }

    public function nurse(): Factory
    {
        return $this->state(
            function (array $attributes) {
                return [
                    'role' => 'nurse',
                ];
            }
        );
    }

    public function patient(): Factory
    {
        return $this->state(
            function (array $attributes) {
                return [
                    'role' => 'patient',
                ];
            }
        );
    }
}
