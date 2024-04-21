<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $this->createTestDoctor();

        Doctor::factory()->withPhoto('male')
            ->has(User::factory()->gender('male'))
            ->count(6)->create();
        Doctor::factory()->withPhoto('female')
            ->has(User::factory()->gender('female'))
            ->count(7)->create();
    }

    private function createTestDoctor(): void
    {
        Doctor::factory()->for(
            Speciality::whereName('терапевт')->first()
        )->has(User::factory()->state([
            'first_name' => 'Пётр',
            'last_name' => 'Иванов',
            'username' => 'testdoctor',
            'password' => Hash::make('test'),
            'email' => 'test@doctor.com',
            'gender' => 'male',
        ]))->create();
    }
}
