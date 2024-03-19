<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    private function hasAccess(User $user, Patient $patient): bool {
        if ($user->patient == $patient) {
            return true;
        }

        if ($user->doctor && $user->doctor->getPatients()->contains($patient)) {
            return true;
        }

        if ($user->nurse && $user->nurse->doctor->getPatients()->contains($patient)) {
            return true;
        }

        return false;
    }

    public function view(User $user, Patient $patient): bool
    {
        return $this->hasAccess($user, $patient);
    }   

    public function viewAppointments(User $user, Patient $patient): bool
    {
        return $this->hasAccess($user, $patient);
    }

    public function viewCaseRecords(User $user, Patient $patient): bool
    {
        return $this->hasAccess($user, $patient);
    }

    public function createCaseRecord(User $user, Patient $patient): bool
    {
        if ($user->doctor && $user->doctor->getPatients()->contains($patient)) {
            return true;
        }

        return false;
    }
}
