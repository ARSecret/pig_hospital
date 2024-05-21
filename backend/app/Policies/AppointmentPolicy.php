<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;

class AppointmentPolicy
{
    public function create(User $user): bool
    {
        return $user->concrete instanceof Patient;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->patient == $appointment->patient 
            || $user->doctor == $appointment->doctor
            || $user->nurse && $user->nurse->doctor == $appointment->doctor;
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return $user->concrete == $appointment->doctor;
    }
}
