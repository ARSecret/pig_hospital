<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_shows_themselves(): void
    {
        $patient = Patient::first();
        $response = $this->actingAs($patient->user)
            ->get('api/patients/' . $patient->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'username' => $patient->username,
            ]
        ]);
    }

    public function test_doesnt_show_others(): void
    {
        $patient = Patient::first();
        $otherPatient = Patient::all()[1];
        $response = $this->actingAs($patient->user)
            ->get('api/patients/' . $otherPatient->id);

        $response->assertStatus(403);
    }

    public function test_shows_their_patients_to_doctor(): void
    {
        $doctor = Doctor::first();

        $response = $this->actingAs($doctor->user)
            ->get('api/patients/' . $doctor->getPatients()->random()->id);
        $response->assertStatus(200);
    }
}
