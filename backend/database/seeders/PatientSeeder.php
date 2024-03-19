<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Transliterator;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createTestPatient();

        $password_hash = Hash::make('123');
        $transliterator = Transliterator::create('Russian-Latin/BGN');
        for ($i = 0; $i < 100; $i++) {
            $gender = fake()->randomElement(['male', 'female']);
            $first_name = fake('ru_RU')->firstName($gender);
            $last_name = fake('ru_RU')->lastName($gender);

            $login = implode('_', [$first_name, $last_name]);
            $login = $transliterator->transliterate($login);
            $login = strtolower($login);
            $extraChar = '1';
            while (DB::table('users')->where('login', $login)->exists()) {
                $login .= $extraChar;
                $extraChar += 1;
            }

            $mail_service = fake()->randomElement(['yandex.ru', 'gmail.com', 'mail.ru']);
            $email = "$login@$mail_service";

            $user_id = DB::table('users')->insertGetId(
                [
                    'login' => $login,
                    'gender' => $gender,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'patronymic' => null,
                    'email' => $email,
                    'role' => 'patient',
                    'password' => $password_hash,
                ]
            );

            DB::table('patients')->insert(
                [
                'user_id' => $user_id,
                'birthdate' => fake()->dateTimeBetween('-90 years', '-18 years'),
                ]
            );
        }
    }

    private function createTestPatient(): void
    {
        $testPatientUser = new User;
        $testPatientUser->first_name = 'Петр';
        $testPatientUser->last_name = 'Иванов';
        $testPatientUser->login = 'testpatient';
        $testPatientUser->password = Hash::make('test');
        $testPatientUser->email = 'test@patient.com';
        $testPatientUser->gender = 'male';
        $testPatientUser->role = 'patient';
        $testPatientUser->save();

        $testDoctor = new Patient;
        $testDoctor->user()->associate($testPatientUser);
        $testDoctor->birthdate = fake()->dateTimeBetween('-80 years', '-18 years');
        $testDoctor->save();
    }
}
