<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Doctor;

class DoctorPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user): bool
    {
        return true;
    }

    public function viewPatients(User $user, Doctor $doctor): bool
    {
        return $user->doctor == $doctor 
            || ($user->nurse && $user->nurse->doctor == $doctor);
    }

    public function viewAppointments(User $user, Doctor $doctor): bool
    {
        return $user->doctor == $doctor 
            || ($user->nurse && $user->nurse->doctor == $doctor);
    }

    public function viewAvailableAppointments(User $user): bool
    {
        return true;
    }
}
