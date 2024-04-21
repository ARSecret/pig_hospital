<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Transliterator;

use App\Models\User;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    static private string $passwordHash;
    
    public function configure(): static
    {
        self::$passwordHash = Hash::make('123');
        return $this->state(fn () => []);
    }

    public function definition(): array
    {
        return array_merge(
            [
                'password' => self::$passwordHash,
            ],
            self::generateGenderFields(fake()->randomElement(['male', 'female']))
        );
    }

    public function gender($gender): Factory
    {
        return $this->state(fn () => self::generateGenderFields($gender));
    }

    static public function generateGenderFields($gender)
    {
        $firstName = fake('ru_RU')->firstName($gender);
        $lastName = fake('ru_RU')->lastName($gender);

        $username = self::generateUsername($firstName, $lastName);
        // $email = self::generateEmail($username);
        $email = fake()->unique()->safeEmail();

        return [
            'gender' => $gender,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'patronymic' => null,
            'username' => $username,
            'email' => $email,
        ];
    }

    static public function generateUsername(
        string $firstName,
        string $lastName
    ): string {
        $transliterator = Transliterator::create('Russian-Latin/BGN');

        $username = implode('_', [$firstName, $lastName]);
        $username = str_replace('ё', 'е', $username);
        $username = str_replace('ь', '', $username);
        $username = $transliterator->transliterate($username);
        $username = strtolower($username);
        $extraChar = 1;
        while (User::where('username', $username)->count() > 0) {
            $username .= $extraChar;
            $extraChar += 1;
        }

        return $username;
    }

    static public function generateEmail(string $username)
    {
        $email = fake()->email();
        $host  = explode('@', $email)[1];
        return $username . '@' . $host;
    }
}
