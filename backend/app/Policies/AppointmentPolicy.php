<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function create(User $user): bool
    {
        return $user->patient || $user->nurse;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->patient == $appointment->patient 
            || $user->doctor == $appointment->doctor
            || $user->nurse && $user->nurse->doctor == $appointment->doctor;
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return $user->doctor == $appointment->doctor
            || $user->nurse && $user->nurse->doctor == $appointment->doctor;
    }
}
