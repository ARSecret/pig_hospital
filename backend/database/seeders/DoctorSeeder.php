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

        Doctor::factory()->count(12)->has(Nurse::factory())->create();
    }

    private function createTestDoctor(): void
    {
        $testDoctorUser = new User;
        $testDoctorUser->first_name = 'Иван';
        $testDoctorUser->last_name = 'Петров';
        $testDoctorUser->login = 'testdoctor';
        $testDoctorUser->password = Hash::make('test');
        $testDoctorUser->email = 'test@doctor.com';
        $testDoctorUser->gender = 'male';
        $testDoctorUser->role = 'doctor';
        $testDoctorUser->save();

        $testDoctor = new Doctor;
        $testDoctor->user()->associate($testDoctorUser);
        $testDoctor->speciality()->associate(Speciality::first());
        $testDoctor->save();
    }
}
