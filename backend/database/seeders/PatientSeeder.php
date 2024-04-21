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

        Patient::factory()->has(User::factory())->count(16)->create();
    }

    private function createTestPatient(): void
    {
        Patient::factory()->has(User::factory()->state([
            'first_name' => 'Иван',
            'last_name' => 'Петров',
            'username' => 'testpatient',
            'password' => Hash::make('test'),
            'email' => 'test@patient.com',
            'gender' => 'male',
        ]))->create();
    }
}
