<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogInTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_testpatient_can_log_in(): void
    {
        $logInResponse = $this->post('api/auth/log-in', [
            'username' => 'testpatient',
            'password' => 'test',
        ]);
        $logInResponse->assertStatus(200);

        $userResponse = $this->get('api/user');
        $userResponse->assertStatus(200);
        $userResponse->assertJson([
            'data' => [
                'username' => 'testpatient',
                'role' => 'patient',
            ],
        ]);
    }
}
